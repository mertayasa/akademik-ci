<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendaModel;
use App\Models\DataTables\AgendaDataTable;
use Config\Services;

class Agenda extends BaseController
{

    protected $agenda;

    public function __construct()
    {
        $this->agenda = new AgendaModel();
    }

    public function index()
    {
        if (session()->get('level') == 'admin') {
            $agenda = [];
        } else {
            $agenda = $this->agenda->where('status', $this->agenda::$aktif)->findAll()[0] ?? [];
        }

        $data = [
            'agenda' => $agenda
        ];

        return view('agenda/index', $data);
    }

    public function datatables()
    {
        $request = Services::request();
        $datatable = new AgendaDataTable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->updated_at;
                $row[] = $list->judul ?? '-';
                // $row[] = '<object data="'. base_url($list->file) .'" width="350px" height="100px"></object>';
                $row[] = $list->status;
                if ($list->status == 'nonaktif') {
                    $row[] = "
                    <a href='" . base_url($list->file) . "' class='btn btn-sm btn-info' target='_blank'>Tampil</a>
                    <button class='btn btn-sm btn-primary' onclick='setActive(`" . route_to('agenda_set_active', $list->id) . "`, `agendaDataTable`, `Apakah anda yakin mengaktifkan data agenda ?, data agenda lain akan otomatis non aktif`)'>Set Aktif</button>
                    <a href='" . route_to('agenda_edit', $list->id) . "' class='btn btn-sm btn-warning'>Edit</a>";
                } else {
                    $row[] = "
                    <a href='" . base_url($list->file) . "' class='btn btn-sm btn-info' target='_blank'>Tampil</a>
                    <a href='" . route_to('agenda_edit', $list->id) . "' class='btn btn-sm btn-warning'>Edit</a>";
                }
                // <button class='btn btn-sm btn-danger' onclick='deleteModel(`". route_to('agenda_destroy', $list->id) ."`, `agendaDataTable`, `Apakah anda yang menghapus data agenda ?`)'>Hapus</button>";
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
        return view('agenda/create');
    }

    public function insert()
    {
        try {
            $base_64_foto = json_decode($this->request->getPost('file'), true);
            $upload_image = uploadFile($base_64_foto, 'agenda');

            if ($upload_image === 0) {
                session()->setFlashdata('error', 'Gagal mengupload berkas agenda');
                return redirect()->back()->withInput();
            }

            $new_data = [
                'judul' => $this->request->getPost('judul'),
                'status' => $this->agenda::$nonaktif,
                'file' => $upload_image,
            ];

            $this->agenda->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menyimpan data agenda');
            return redirect()->to(route_to('agenda_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menyimpan data agenda');
            return redirect()->back()->withInput();
        }
    }

    public function setActive($id)
    {
        try {
            $this->agenda->transStart();
            $setnonactive = $this->agenda->whereNotIn('id', [$id])->findAll();
            foreach ($setnonactive as $setnon) {
                $updatenon = [
                    'status' => $this->agenda::$nonaktif,
                ];

                $this->agenda->updateData($setnon['id'], $updatenon);
            }

            $update_data = [
                'status' => $this->agenda::$aktif,
            ];

            $this->agenda->updateData($id, $update_data);
            $this->agenda->transComplete();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return json_encode([
                'code' => 0,
                'message' => 'Gagal mengaktifkan data agenda',
            ]);
        }

        return json_encode([
            'code' => 1,
            'message' => 'Berhasil mengaktifkan data agenda'
        ]);
    }

    public function edit($id)
    {
        $agenda = $this->agenda->getData($id);
        $data = [
            'agenda' => $agenda
        ];

        return view('agenda/edit', $data);
    }

    public function update($id)
    {
        try {
            $base_64_foto = json_decode($this->request->getPost('file'), true);
            $upload_image = uploadFile($base_64_foto, 'agenda');

            if ($upload_image === 0) {
                session()->setFlashdata('error', 'Gagal mengupload berkas agenda');
                return redirect()->back()->withInput();
            }

            $new_data = [
                'judul' => $this->request->getPost('judul'),
                'file' => $upload_image,
            ];

            $this->agenda->updateData($id, $new_data);
            session()->setFlashdata('success', 'Berhasil mengubah data agenda');
            return redirect()->to(route_to('agenda_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data agenda');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->agenda->delete($id);
        } catch (\Exception $e) {
            return json_encode([
                'code' => 0,
                'message' => 'Gagal menghapus data agenda'
            ]);
        }

        return json_encode([
            'code' => 1,
            'message' => 'Berhasil menghapus data agenda'
        ]);
    }
}
