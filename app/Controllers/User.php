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

    public function index()
    {
        return view('user/index');
    }

    public function datatables()
    {
        $request = Services::request();
        $datatable = new UserDataTable($request);

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
                <a href='". route_to('user_edit', $list->id) ."' class='btn btn-sm btn-warning'>Edit</a>
                <button class='btn btn-sm btn-danger' onclick='deleteModel(". $list->id .")'>Hapus</button>";
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function create()
    {
        // throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Aseg');
        // dd( $this->user->getData(1) );
        return view('user/create');
    }

    public function insert()
    {
        try{
            $new_data = [
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            ];

            $this->user->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menambahkan data user');
            return redirect()->to(route_to('user_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan data user');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $user = $this->user->getData($id);
        $data = [
            'user' => $user
        ];
        
        return view('user/edit', $data);
    }

    public function update($id)
    {
        try{
            $update_data = [
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            ];

            $this->user->updateData($id, $update_data);
            session()->setFlashdata('success', 'Berhasil mengubah data user');
            return redirect()->to(route_to('user_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data user');
            return redirect()->back()->withInput();
        }
    }
}
