<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataTables\UserDataTable;
use App\Models\UserModel;
use Config\Services;

class User extends BaseController
{
    protected $user;
    
    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index($level)
    {

        if($level == 'kepsek'){
            $kepsek = $this->user->where('level', 'kepsek')->findAll()[0] ?? [];
            if($kepsek){
                $kepsek['foto'] = $this->user->getFoto($kepsek['id']);
            }
        }else{
            $kepsek = [];
        }

        $data = [
            'kepsek' => $kepsek,
            'level' => $level
        ];

        return view('user/index', $data);
    }

    public function datatables($level)
    {
        $request = Services::request();
        $datatable = new UserDataTable($request, explode('-', $level));

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama;
                $row[] = $list->email;
                $row[] = $list->level;
                $row[] = ucfirst($list->status);
                $row[] = "
                <a href='". route_to('user_edit', $level, $list->id) ."' class='btn btn-sm btn-warning'>Edit</a>
                <button class='btn btn-sm btn-danger' onclick='deleteModel(`". route_to('user_destroy', $list->id) ."`, `userDataTable`, `Aseg`)'>Hapus</button>";
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data,
            ];

            return json_encode($output);
        }
    }

    public function create($level)
    {
        if($level == 'siswa'){
            $ortu = $this->user->select('id, nama')->where('level', 'ortu')->where('status', 'aktif')->findAll();
        }else{
            $ortu = [];
        }

        $data = [
            'level' => $level,
            'ortu' => $ortu
        ];

        return view('user/create', $data);
    }

    public function insert($level)
    {
        try{
            $allowed_level = ['admin', 'kepsek'];
            
            $new_data = $this->request->getPost();
            $new_data['level'] = $level == 'admin-kepsek' && in_array($new_data['level'], $allowed_level) ? $new_data['level'] : $level;
            if(!$new_data['password']){
                session()->setFlashdata('error', 'Password belum diisi');
                return redirect()->back()->withInput();
            }
            $new_data['password'] = password_hash($new_data['password'], PASSWORD_BCRYPT);
            
            $this->user->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menambahkan data user');
            return redirect()->to(route_to('user_index', $level));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan data user');
            return redirect()->back()->withInput();
        }
    }

    public function edit($level, $id)
    {
        if($level == 'siswa'){
            $ortu = $this->user->select('id, nama')->where('level', 'ortu')->findAll();
        }else{
            $ortu = [];
        }

        $user = $this->user->getData($id);
        $data = [
            'level' => $level,
            'user' => $user,
            'ortu' => $ortu
        ];
        
        return view('user/edit', $data);
    }

    public function update($level, $id)
    {
        try{
            $allowed_level = ['admin', 'kepsek'];
            
            $update_data = $this->request->getPost();
            $update_data['level'] = $level == 'admin-kepsek' && in_array($update_data['level'], $allowed_level) ? $update_data['level'] : $level;

            if($update_data['password'] != ''){
                $update_data['password'] = password_hash($update_data['password'], PASSWORD_BCRYPT);
            }
            
            $this->user->updateData($id, $update_data);
            session()->setFlashdata('success', 'Berhasil mengubah data user');
            return redirect()->to(route_to('user_index', $level));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data user');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id){
        try{
            $this->user->delete($id);
        }catch(\Exception $e){
            return json_encode([
                'code' => 0,
                'message' => 'Gagal menghapus data pengguna'
            ]);
        }

        return json_encode([
            'code' => 1,
            'message' => 'Berhasil menghapus data pengguna'
        ]);
    }

    public function kepsekCreate()
    {
        $data = [
            'level' => 'kepsek'
        ];
        return view('user/kepsek/create', $data);
    }

    public function kepsekInsert()
    {
        try{        
            $check_kepsek = $this->user->where('level', 'kepsek')->findAll();
            if(count($check_kepsek) > 0){
                session()->setFlashdata('error', 'Akun Kepala Sekolah Sudah Ada');
                return redirect()->back()->withInput();
            }
            
            $new_data = $this->request->getPost();

            if($this->request->getPost('foto')){
                $base_64_foto = json_decode($this->request->getPost('foto'), true);
                $upload_image = uploadFile($base_64_foto, 'avatar');
    
                if ($upload_image === 0) {
                    session()->setFlashdata('error', 'Gagal mengupload gambar');
                    return redirect()->back()->withInput();
                }

                $new_data['foto'] = $upload_image;
            }

            if(!$new_data['password']){
                session()->setFlashdata('error', 'Password belum diisi');
                return redirect()->back()->withInput();
            }
            
            $new_data['level'] = 'kepsek';
            $new_data['password'] = password_hash($new_data['password'], PASSWORD_BCRYPT);
            
            $this->user->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menambahkan profil kepala sekolah');
            return redirect()->to(route_to('user_index', 'kepsek'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan profil kepala sekolah');
            return redirect()->back()->withInput();
        }
    }

    public function kepsekEdit($id)
    {
        $kepsek = $this->user->getData($id);
        if($kepsek){
            $kepsek['foto'] = $this->user->getFoto($kepsek['id']);
        }else{
            $kepsek = [];
        }

        $data = [
            'kepsek' => $kepsek
        ];

        return view('user/kepsek/edit', $data);
    }

    public function kepsekUpdate($id)
    {
        try{        
            $update_data = $this->request->getPost();

            if($this->request->getPost('foto')){
                $base_64_foto = json_decode($this->request->getPost('foto'), true);
                $upload_image = uploadFile($base_64_foto, 'avatar');
    
                if ($upload_image === 0) {
                    session()->setFlashdata('error', 'Gagal mengupload gambar');
                    return redirect()->back()->withInput();
                }

                $update_data['foto'] = $upload_image;
            }

            if($update_data['password'] != ''){
                $update_data['password'] = password_hash($update_data['password'], PASSWORD_BCRYPT);
            }
            
            $this->user->updateData($id, $update_data);
            session()->setFlashdata('success', 'Berhasil mengubah profil kepala sekolah');
            return redirect()->to(route_to('user_index', 'kepsek'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah profil kepala sekolah');
            return redirect()->back()->withInput();
        }
    }
}
