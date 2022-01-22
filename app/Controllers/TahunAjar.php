<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataTables\TahunAjarDataTable;
use App\Models\TahunAjarModel;
use Config\Services;
use Exception;

class TahunAjar extends BaseController
{
    protected $tahun_ajar;

    public function __construct()
    {
        $this->tahun_ajar = new TahunAjarModel();
    }

    public function index()
    {
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
                $row[] = $list->tahun_mulai . '/' . $list->tahun_selesai;
                $row[] = ucfirst(str_replace('_', ' ', $list->status));
                if (session()->get('level') == 'admin') {
                    $row[] = "
                    <button class='btn btn-sm btn-info' onclick='setActive(`" . route_to('tahun_ajar_set_active', $list->id) . "`, `tahunAjarDataTable`, `Apakah anda yakin mengaktifkan tahun ajaran ?, tahun ajaran lain akan otomatis non aktif`)'>Set Aktif</button>
                    <a href='" . route_to('tahun_ajar_edit', $list->id) . "' class='btn btn-sm btn-warning'>Edit</a>
                    <button class='btn btn-sm btn-danger' onclick='deleteModel(`" . route_to('tahun_ajar_destroy', $list->id) . "`, `tahunAjarDataTable`, `Apakah anda yakin menghapus data tahun ajaran ?`)'>Hapus</button>";
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
        return view('tahun_ajar/create');
    }

    public function edit($id)
    {
        $tahun_ajar = $this->tahun_ajar->getData($id);
        $data = [
            'tahun_ajar' => $tahun_ajar
        ];

        return view('tahun_ajar/edit', $data);
    }

    public function insert()
    {
        try {
            $new_data = [
                'tahun_mulai' => $this->request->getPost('tahun_mulai'),
                'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            ];

            $this->tahun_ajar->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menambahkan data tahun ajar');
            return redirect()->to(route_to('tahun_ajar_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan data tahun ajar');
            return redirect()->back()->withInput();
        }
    }

    public function update($id)
    {
        try {
            $update_data = [
                'tahun_mulai' => $this->request->getPost('tahun_mulai'),
                'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            ];

            $this->tahun_ajar->updateData($id, $update_data);
            session()->setFlashdata('success', 'Berhasil mengubah data tahun ajar');
            return redirect()->to(route_to('tahun_ajar_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data tahun ajar');
            return redirect()->back()->withInput();
        }
    }

    public function setActive($id)
    {
        try {
            $this->tahun_ajar->transStart();
            $setnonactive = $this->tahun_ajar->whereNotIn('id', [$id])->findAll();
            foreach ($setnonactive as $setnon) {
                $updatenon = [
                    'status' => 'nonaktif',
                ];

                $this->tahun_ajar->updateData($setnon['id'], $updatenon);
            }

            $update_data = [
                'status' => 'aktif',
            ];

            $this->tahun_ajar->updateData($id, $update_data);
            $this->tahun_ajar->transComplete();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return json_encode([
                'code' => 0,
                'message' => 'Gagal mengaktifkan tahun ajaran',
            ]);
        }

        return json_encode([
            'code' => 1,
            'message' => 'Berhasil mengaktifkan tahun ajaran'
        ]);
    }

    public function destroy($id)
    {
        try {
            $this->tahun_ajar->delete($id);
        } catch (\Exception $e) {
            return json_encode([
                'code' => 0,
                'message' => 'Gagal menghapus data tahun ajar'
            ]);
        }

        return json_encode([
            'code' => 1,
            'message' => 'Berhasil menghapus data tahun ajar'
        ]);
    }
}
