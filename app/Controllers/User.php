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
        $data = [
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
        $data = [
            'level' => $level
        ];
        return view('user/create', $data);
    }

    public function insert($level)
    {
        try{
            $allowed_level = ['admin', 'kepsek'];
            
            $new_data = $this->request->getPost();
            $new_data['level'] = $level == 'admin-kepsek' && in_array($new_data['level'], $allowed_level) ? $new_data['level'] : $level;
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
        $user = $this->user->getData($id);
        $data = [
            'level' => $level,
            'user' => $user
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
}
