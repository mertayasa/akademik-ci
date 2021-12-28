<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

use function PHPUnit\Framework\returnSelf;

class Profile extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function show($id)
    {
        $user = $this->user->getData($id);
        if($user){
            $user['foto'] = $this->user->getFoto($user['id']);
            if(($user['level'] == 'siswa' or $user['level'] == 'admin') and $user['id_ortu'] != null){
                $ortu = $this->user->getData($user['id_ortu']);
            }else{
                $ortu = [];
            }

            if(($user['level'] == 'ortu' or $user['level'] == 'admin')){
                $siswa = $this->user->where('id_ortu', $user['id'])->findAll();
                $nama_siswa = array_map(function($siswa)
                {
                    return $siswa['nama'];
                }, $siswa);
            }else{
                $nama_siswa = [];
            }


            $data = [
                'user' => $user,
                'ortu' => $ortu,
                'nama_siswa' => implode(', ', $nama_siswa),
                'level' => $user['level'],
            ];
            return view('profile/show', $data);
        }

        session()->setFlashdata('error', 'Akun pengguna tidak ditemukan');
        return redirect()->back();
    }

    public function edit()
    {
        $id = session()->get('id');
        $level = session()->get('level');
        $user = $this->user->getData($id);
        $user['foto'] = $this->user->getFoto($user['id']);
        
        $data = [
            'user' => $user,
            'include_form' => 'profile/form/'.$level
        ];

        return view('profile/edit', $data);
    }

    public function update()
    {
        try{
            $id = session()->get('id');
            $update_data = $this->request->getPost();
            if($update_data['password'] != ''){
                $update_data['password'] = password_hash($update_data['password'], PASSWORD_BCRYPT);
            }else{
                unset($update_data['password']);
                unset($update_data['password_confirmation']);
            }

            if($this->request->getPost('foto')){
                $base_64_foto = json_decode($this->request->getPost('foto'), true);
                $upload_image = uploadFile($base_64_foto, 'avatar');
    
                if ($upload_image === 0) {
                    session()->setFlashdata('error', 'Gagal mengupload gambar');
                    return redirect()->back()->withInput();
                }

                $update_data['foto'] = $upload_image;
            }

            $this->user->updateData($id, $update_data);
            session()->setFlashdata('success', 'Berhasil mengubah profil');
            return redirect()->back();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah profil');
            return redirect()->back()->withInput();
        }
    }
}
