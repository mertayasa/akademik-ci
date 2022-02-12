<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataTables\MapelDataTable;
use App\Models\JadwalModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use Config\Services;

class Mapel extends BaseController
{
    protected $mapel;
    protected $nilai;
    protected $jadwal;

    public function __construct()
    {
        $this->mapel = new MapelModel();
        $this->nilai = new NilaiModel();
        $this->jadwal = new JadwalModel();
    }

    public function index()
    {
        return view('mapel/index');
    }

    public function datatables()
    {
        $request = Services::request();
        $datatable = new MapelDataTable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama;
                $row[] = $list->status;
                $row[] = getKelasPerMapel($list->id);
                if (session()->get('level') == 'admin') {
                    $row[] = "
                    <a href='" . route_to('mapel_edit', $list->id) . "' class='btn btn-sm btn-warning'>Edit</a>";
                    // <button class='btn btn-sm btn-danger' onclick='deleteModel(`" . route_to('mapel_destroy', $list->id) . "`, `mapelDataTable`, `Apakah anda yang menghapus data mata pelajaran ?`)'>Hapus</button>";
                } else {
                    $row[] = "";
                }
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
        return view('mapel/create');
    }

    public function edit($id)
    {
        $mapel = $this->mapel->getData($id);
        $data = [
            'mapel' => $mapel
        ];

        return view('mapel/edit', $data);
    }

    public function insert()
    {
        try {
            $new_data = [
                'nama' => $this->request->getPost('nama'),
                'status' => $this->request->getPost('status'),
            ];

            $this->mapel->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menambahkan data mata pelajaran');
            return redirect()->to(route_to('mapel_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan data mata pelajaran');
            return redirect()->back()->withInput();
        }
    }

    public function update($id)
    {
        try {
            $update_data = [
                'nama' => $this->request->getPost('nama'),
                'status' => $this->request->getPost('status'),
            ];

            $this->mapel->updateData($id, $update_data);
            session()->setFlashdata('success', 'Berhasil mengubah data mata pelajaran');
            return redirect()->to(route_to('mapel_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data mata pelajaran');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        $nilai = $this->nilai->where('id_mapel', $id)->countAllResults();
        $jadwal = $this->jadwal->where('id_mapel', $id)->countAllResults();

        if ($nilai > 0 || $jadwal > 0) {
            return json_encode([
                'code' => 0,
                'swal' => 'Tidak bisa menghapus data mata pelajaran karena masih digunakan di tabel lain'
            ]);
        }

        try {
            $this->mapel->delete($id);
        } catch (\Exception $e) {
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
