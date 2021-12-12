<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenjangKelasModel;
use App\Models\KelasModel;

class Kelas extends BaseController
{
    protected $kelas;
    protected $jenjang_kelas;
    
    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->jenjang_kelas = new JenjangKelasModel();
    }

    public function index()
    {
        // $jenjang_kelas = $this->jenjang_kelas->getData();
        $jenjang_kelas = $this->jenjang_kelas->groupBy('jenjang')->get();
        dd($jenjang_kelas->last_query());
        echo "<pre>";
		print_r($jenjang_kelas->getResult());

        $data = [
            'jenjang_kelas' => $jenjang_kelas
        ];

        dd($data);

        return view('kelas/index');
    }

    public function datatables()
    {
        // $request = Services::request();
        // $datatable = new kelasDataTable($request);

        // if ($request->getMethod(true) === 'POST') {
        //     $lists = $datatable->getDatatables();
        //     $data = [];
        //     $no = $request->getPost('start');

        //     foreach ($lists as $list) {
        //         $no++;
        //         $row = [];
        //         $row[] = $no;
        //         $row[] = $list->nama;
        //         $row[] = $list->status;
        //         $row[] = "
        //         <a href='". route_to('kelas_edit', $list->id) ."' class='btn btn-sm btn-warning'>Edit</a>
        //         <button class='btn btn-sm btn-danger' onclick='deleteModel(`". route_to('kelas_destroy', $list->id) ."`, `kelasDataTable`, `Apakah anda yang menghapus data mata pelajaran ?`)'>Hapus</button>";
        //         $data[] = $row;
        //     }

        //     $output = [
        //         'draw' => $request->getPost('draw'),
        //         'recordsTotal' => $datatable->countAll(),
        //         'recordsFiltered' => $datatable->countFiltered(),
        //         'data' => $data,
        //     ];

        //     return json_encode($output);
        // }
    }

    public function create()
    {
        return view('kelas/create');
    }

    public function edit($id)
    {
        $kelas = $this->kelas->getData($id);
        $data = [
            'kelas' => $kelas
        ];  

        return view('kelas/edit', $data);
    }

    public function insert()
    {
        try{
            $new_data = [
                'nama' => $this->request->getPost('nama'),
                'status' => $this->request->getPost('status'),
            ];

            $this->kelas->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menambahkan data mata pelajaran');
            return redirect()->to(route_to('kelas_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan data mata pelajaran');
            return redirect()->back()->withInput();
        }
    }

    public function update($id)
    {
        try{
            $update_data = [
                'nama' => $this->request->getPost('nama'),
                'status' => $this->request->getPost('status'),
            ];

            $this->kelas->updateData($id, $update_data);
            session()->setFlashdata('success', 'Berhasil mengubah data mata pelajaran');
            return redirect()->to(route_to('kelas_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data mata pelajaran');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try{
            $this->kelas->delete($id);
        }catch(\Exception $e){
            return json_encode([
                'code' => 0,
                'message' => 'Gagal menghapus data mata pelajaran'
            ]);
        }

        return json_encode([
            'code' => 1,
            'message' => 'Berhasil menghapus data mata pelajaran'
        ]);
    }
}
