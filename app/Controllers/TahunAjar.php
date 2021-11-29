<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataTables\TahunAjarDataTable;
use App\Models\TahunAjarModel;
use Config\Services;

class TahunAjar extends BaseController
{
    protected $user;
    
    public function __construct()
    {
        $this->user = new TahunAjarModel();
    }

    public function index()
    {
        // dd('asdsda');
        return view('tahun_ajar/index');
    }

    public function datatables()
    {
        $request = Services::request();
        $datatable = new TahunAjarDataTable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->tahun_mulai;
                $row[] = $list->tahun_selesai;
                $row[] = $list->keterangan;
                $row[] = "
                <a href='". route_to('tahun_ajar_edit', $list->id) ."' class='btn btn-sm btn-warning'>Edit</a>
                <button class='btn btn-sm btn-danger' onclick='deleteModel(`". route_to('tahun_ajar_destroy', $list->id) ."`, `tahunAjaranDataTable`, `Apakah anda yang menghapus data tahun ajaran ?`)'>Hapus</button>";
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
        dd('asdds');
    }

    public function edit($id)
    {
        
    }

    public function store()
    {
        
    }

    public function udpate($id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
