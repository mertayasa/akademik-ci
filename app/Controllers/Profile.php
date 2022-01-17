<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\GuruKepsekModel;
use App\Models\OrtuModel;
use App\Models\SiswaModel;

use function PHPUnit\Framework\returnSelf;

class Profile extends BaseController
{
    protected $user;
    protected $admin;
    protected $siswa;
    protected $ortu;
    protected $guru;

    public function __construct()
    {
        // $this->user = new UserModel();
        $this->siswa = new SiswaModel();
        $this->guru = new GuruKepsekModel();
        $this->admin = new AdminModel();
        $this->ortu = new OrtuModel();
    }

    public function show($id)
    {
        // $user = $this->user->getData($id);
        // if($user){
        //     $user['foto'] = $this->user->getFoto($user['id']);
        //     if(($user['level'] == 'siswa' or $user['level'] == 'admin') and $user['id_ortu'] != null){
        //         $ortu = $this->user->getData($user['id_ortu']);
        //     }else{
        //         $ortu = [];
        //     }

        //     if(($user['level'] == 'ortu' or $user['level'] == 'admin')){
        //         $siswa = $this->user->where('id_ortu', $user['id'])->findAll();
        //         $nama_siswa = array_map(function($siswa)
        //         {
        //             return $siswa['nama'];
        //         }, $siswa);
        //     }else{
        //         $nama_siswa = [];
        //     }


        //     $data = [
        //         'user' => $user,
        //         'ortu' => $ortu,
        //         'nama_siswa' => implode(', ', $nama_siswa),
        //         'level' => $user['level'],
        //     ];
        //     return view('profile/show', $data);
        // }
        $user = [];
        if (session()->get('level') == 'admin') {
            $user = $this->admin->getData($id);
            if ($user) {
                $user['foto'] = $this->admin->getFoto($user['id']);
                $ortu = [];
            }
        } elseif (session()->get('level') == 'siswa') {
            $user = $this->siswa->getFoto($user['id']);
            $ortu = $this->ortu->getData($user['id_ortu']);
        } elseif (session()->get('level') == 'ortu') {
            $siswa = $this->siswa->where('id_ortu', $user['id'])->findAll();
            $nama_siswa = array_map(function ($siswa) {
                return $siswa['nama'];
            }, $siswa);
        } else {
            $user = $this->admin->getData(session()->get('id'));
        }

        $data = [
            'user' => $user,
            'ortu' => $ortu,
            'nama_siswa' => implode(', ', $nama_siswa),
            'level' => $user['level'],
        ];
        return view('profile/show', $data);

        // session()->setFlashdata('error', 'Akun pengguna tidak ditemukan');
        // return redirect()->back();
    }

    public function edit()
    {
        $id = session()->get('id');
        $level = session()->get('level');
        switch ($level) {
            case 'admin':
                $user = $this->admin->getData($id);
                $user['foto'] = $this->admin->getFoto($user['id']);
                break;
            case 'siswa':
                $user = $this->siswa->getData($id);
                $user['foto'] = $this->siswa->getFoto($user['id']);
                break;
            case 'ortu':
                $user = $this->ortu->getData($id);
                $user['foto'] = $this->ortu->getFoto($user['id']);
                break;
            case 'guru':
                $user = $this->guru->getData($id);
                $user['foto'] = $this->guru->getFoto($user['id']);
                break;
            case 'kepsek':
                $user = $this->guru->getData($id);
                $user['foto'] = $this->guru->getFoto($user['id']);
                break;
            default:
                $user = [];
        }

        $data = [
            'user' => $user,
            'include_form' => 'profile/form/' . $level
        ];

        return view('profile/edit', $data);
    }

    public function update()
    {
        $level = session()->get('level');
        try {
            $id = session()->get('id');
            $update_data = $this->request->getPost();
            if ($update_data['password'] != '') {
                $update_data['password'] = password_hash($update_data['password'], PASSWORD_BCRYPT);
            } else {
                unset($update_data['password']);
                unset($update_data['password_confirmation']);
            }

            if ($this->request->getPost('foto')) {
                $base_64_foto = json_decode($this->request->getPost('foto'), true);
                $upload_image = uploadFile($base_64_foto, 'avatar');

                if ($upload_image === 0) {
                    session()->setFlashdata('error', 'Gagal mengupload gambar');
                    return redirect()->back()->withInput();
                }

                $update_data['foto'] = $upload_image;
            }

            switch ($level) {
                case 'admin':
                    $this->admin->updateData($id, $update_data);
                    break;
                case 'siswa':
                    $this->siswa->updateData($id, $update_data);
                    break;
                case 'ortu':
                    $this->ortu->updateData($id, $update_data);
                    break;
                case 'guru':
                    $this->guru->updateData($id, $update_data);
                    break;
                case 'kepsek':
                    $this->guru->updateData($id, $update_data);
                    break;
                default:
                    $user = [];
            }
            session()->setFlashdata('success', 'Berhasil mengubah profil');
            return redirect()->back();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah profil');
            return redirect()->back()->withInput();
        }
    }
}
