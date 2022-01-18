<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\DataTables\SiswaDataTable;
use Config\Services;
use Exception;

class AnggotaKelas extends BaseController
{
    protected $kelas;
    protected $anggota_kelas;
    protected $siswa;
    protected $db;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->siswa = new SiswaModel();
        $this->db = db_connect();
    }

    public function datatables($tahun_ajar, $kelas)
    {
        $request = Services::request();
        $datatable = new SiswaDataTable($request, $tahun_ajar, $kelas);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables($tahun_ajar, $kelas);
            log_message('info', json_encode($lists));
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama;
                $row[] = $list->nis;
                $row[] = ucfirst($list->status);
                $row[] = "
                    <a href='" . route_to('nilai_edit', $list->id, $list->id_tahun_ajar) . "' class='btn btn-sm btn-info'>Nilai</a>
                    <button class='btn btn-sm " . ($list->status == 'aktif' ? 'btn-danger' : 'btn-warning') . "'onclick='updateStatus(`" . route_to('anggota_kelas_update_status', $list->id) . "`, `daftarSiswaDatatable`, `Apakah anda yang mengubah status siswa menjadi " . ($list->status == 'aktif' ? 'Non Aktif' : 'Aktif') . " ?`)'>" . ($list->status == 'aktif' ? 'Set Non Aktif' : 'Set Aktif') . "</button>";
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

    public function updateStatus($id)
    {
        try {
            $anggota_kelas = $this->anggota_kelas->find($id);
            $status = ($anggota_kelas['status'] == 'aktif' ? 'nonaktif' : 'aktif');
            $this->siswa->updateData($anggota_kelas['id_siswa'], ['status' => $status]);
            $this->anggota_kelas->updateData($id, ['status' => $status]);
            return json_encode(['code' => 1, 'message' => 'Berhasil mengubah status siswa']);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return json_encode(['code' => 0, 'message' => 'Gagal mengubah status siswa']);
        }
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
        try {
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
        try {
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
        try {
            $this->kelas->delete($id);
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
