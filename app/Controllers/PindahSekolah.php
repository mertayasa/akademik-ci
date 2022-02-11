<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataTables\PindahSekolahDataTable;
use App\Models\PindahSekolahModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;
use Config\Services;

class PindahSekolah extends BaseController
{
    protected $tahun_ajar;
    protected $siswa;
    protected $pindah_sekolah;
    protected $db;

    public function __construct()
    {
        $this->tahun_ajar = new TahunAjarModel;   
        $this->siswa = new SiswaModel;   
        $this->pindah_sekolah = new PindahSekolahModel(); 
        $this->db = db_connect();
    }

    public function index($tipe)
    {
        $data = [
            'tipe' => $tipe,
        ];

        return view('pindah_sekolah/index', $data);
    }

    public function datatables($tipe)
    {
        $request = Services::request();
        $datatable = new PindahSekolahDataTable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->id_siswa;
                if($tipe == 'masuk'){
                    $row[] = $list->asal;
                }
                if($tipe == 'keluar'){
                    $row[] = $list->tujuan;
                }
                $row[] = $list->id_tahun_ajar;
                $row[] = $list->alasan;
                if (session()->get('level') == 'admin') {
                    $row[] = "
                    <a href='" . route_to('pindah_sekolah_edit', $list->id) . "' class='btn btn-sm btn-warning'>Edit</a>";
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

    public function create($tipe)
    {
        $tahun_ajar = $this->tahun_ajar->getData();
        $siswa = $this->siswa->getData();

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'siswa' => $siswa,
            'tipe' => $tipe,
        ];

        return view('pindah_sekolah/create', $data);
    }

    public function insert($tipe)
    {
        // dd($tipe);
        $this->db->transBegin();
        try{
            $data = $this->request->getPost();
            
            if($tipe == 'masuk'){
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                $siswa = $this->siswa->insertData($data);
                $data['id_siswa'] = $siswa;
                $data['tujuan'] = getNamaSekolah();
                $data['tipe'] = $tipe;
            }else{
                $data['asal'] = getNamaSekolah();
            }

            // dd($data);
            
            $this->pindah_sekolah->insertData($data);
            $this->db->transCommit();
            session()->setFlashdata('success', 'Berhasil menambahkan data pindah sekolah');
        }catch(\Exception $e){
            $this->db->transRollback();
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan data pindah sekolah');
            return redirect()->back()->withInput();
        }

        return redirect()->to(route_to('pindah_sekolah_index', $tipe));
    }

    public function edit($id_pindah)
    {
        $pindah_sekolah = $this->pindah_sekolah->getData($id_pindah);

        $data = [
            'pindah_sekolah' => $pindah_sekolah,
        ];

        return view('pindah_sekolah/edit', $data);
    }
}
