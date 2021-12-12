<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataTables\KelasDataTable;
use App\Models\KelasModel;
use App\Models\TahunAjarModel;
use Config\Services;

class Kelas extends BaseController
{
    protected $kelas;
    
    public function __construct()
    {
        $this->kelas = new KelasModel();
    }

    public function index()
    {
        return view('kelas/index');
    }

    public function datatables()
    {
        $request = Services::request();
        $datatable = new KelasDataTable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = 'Kelas '.$list->jenjang;
                $row[] = $list->kode;
                $row[] = "
                <a href='". route_to('kelas_edit', $list->id) ."' class='btn btn-sm btn-warning'>Edit</a>
                <button class='btn btn-sm btn-danger' onclick='deleteModel(`". route_to('kelas_destroy', $list->id) ."`, `kelasDataTable`, `Apakah anda yang menghapus data jenjang kelas ?`)'>Hapus</button>";
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

    public function create()
    {
        $jenjang = [
            1 => 'Kelas 1',
            2 => 'Kelas 2',
            3 => 'Kelas 3',
            4 => 'Kelas 4',
            5 => 'Kelas 5',
            6 => 'Kelas 6'
        ];

        $data = [
            'jenjang' => $jenjang
        ];

        return view('kelas/create', $data);
    }

    public function edit($id)
    {
        $kelas = $this->kelas->getData($id);

        $jenjang = [
            1 => 'Kelas 1',
            2 => 'Kelas 2',
            3 => 'Kelas 3',
            4 => 'Kelas 4',
            5 => 'Kelas 5',
            6 => 'Kelas 6'
        ];

        $data = [
            'kelas' => $kelas,
            'jenjang' => $jenjang
        ];

        return view('kelas/edit', $data);
    }

    public function insert()
    {
        try{
            $new_data = [
                'kode' => $this->request->getPost('kode'),
                'jenjang' => $this->request->getPost('jenjang'),
            ];

            $this->kelas->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menambahkan data jenjang kelas');
            return redirect()->to(route_to('kelas_index'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan data jenjang kelas');
            return redirect()->back()->withInput();
        }
    }

    public function update($id)
    {
        try{
            $update_data = [
                'kode' => $this->request->getPost('kode'),
                'jenjang' => $this->request->getPost('jenjang'),
            ];

            $this->kelas->updateData($id, $update_data);
            session()->setFlashdata('success', 'Berhasil mengubah data jenjang kelas');
            return redirect()->to(route_to('kelas_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data jenjang kelas');
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
                'message' => 'Gagal menghapus data jenjang kelas'
            ]);
        }

        return json_encode([
            'code' => 1,
            'message' => 'Berhasil menghapus data jenjang kelas'
        ]);
    }
}
