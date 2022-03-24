<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\DataTables\KelasDataTable;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use App\Models\TahunAjarModel;
use Config\Services;

class Kelas extends BaseController
{
    protected $kelas;
    protected $anggota_kelas;
    protected $nilai;
    protected $jadwal;
    protected $tahun_ajar;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->nilai = new NilaiModel();
        $this->jadwal = new JadwalModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
    }

    public function index()
    {
        $tahun_ajar_id = $this->tahun_ajar->getActiveId();
        $tahun_ajar = $this->tahun_ajar->find($tahun_ajar_id);
        $data = ['tahun_ajar' => $tahun_ajar];
        return view('kelas/index', $data);
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
                $row[] = 'Kelas ' . $list->jenjang;
                $row[] = $list->kode;
                if (session()->get('level') == 'admin') {
                    $row[] = "
                    <a href='" . route_to('kelas_edit', $list->id) . "' class='btn btn-sm btn-warning'>Edit</a>";
                    // <button class='btn btn-sm btn-danger' onclick='deleteModel(`" . route_to('kelas_destroy', $list->id) . "`, `kelasDataTable`, `Apakah anda yang menghapus data jenjang kelas ?`)'>Hapus</button>";
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
        try {
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
        try {
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
        $anggota_kelas = $this->anggota_kelas->where('id_kelas', $id)->countAllResults();
        $nilai = $this->nilai->where('id_kelas', $id)->countAllResults();
        $jadwal = $this->jadwal->where('id_kelas', $id)->countAllResults();

        if ($anggota_kelas > 0 || $nilai > 0 || $jadwal > 0) {
            return json_encode([
                'code' => 0,
                'swal' => 'Tidak bisa menghapus data kelas karena masih digunakan di tabel lain'
            ]);
        }

        try {
            $this->kelas->delete($id);
        } catch (\Exception $e) {
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
