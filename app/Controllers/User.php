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
        // dd($level);
        $data = [
            'level' => $level
        ];

        // throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Aseg');
        // dd( $this->user->getData(1) );
        return view('user/create', $data);
    }

    public function insert($level)
    {
        try{
            $new_data = [
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            ];

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
            $update_data = [
                'nama' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            ];

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
