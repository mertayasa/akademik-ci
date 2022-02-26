<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\DataTables\PindahSekolahDataTable;
use App\Models\OrtuModel;
use App\Models\PindahSekolahModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;
use Config\Services;

class PindahSekolah extends BaseController
{
    protected $tahun_ajar;
    protected $siswa;
    protected $pindah_sekolah;
    protected $anggota_kelas;
    protected $db;

    public function __construct()
    {
        $this->tahun_ajar = new TahunAjarModel;   
        $this->siswa = new SiswaModel;   
        $this->ortu = new OrtuModel;   
        $this->pindah_sekolah = new PindahSekolahModel(); 
        $this->anggota_kelas = new AnggotaKelasModel(); 
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
        $datatable = new PindahSekolahDataTable($request, $tipe);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $tahun_ajar = $this->tahun_ajar->getData($list->id_tahun_ajar);
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $this->siswa->getData($list->id_siswa)['nama'] ?? '-';
                if($tipe == 'masuk'){
                    $row[] = $list->asal;
                }
                if($tipe == 'keluar'){
                    $row[] = $list->tujuan;
                }
                $row[] = isset($tahun_ajar) ? $tahun_ajar['tahun_mulai'].'/'.$tahun_ajar['tahun_selesai'] : '-';
                $row[] = $list->alasan;
                if (session()->get('level') == 'admin') {
                    $row[] = "
                    <a href='" . route_to('pindah_sekolah_show', $tipe, $list->id) . "' class='btn btn-sm btn-info'>Lihat</a>
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
        $siswa = $this->siswa->where('status', 'aktif')->getData();

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'siswa' => $siswa,
            'tipe' => $tipe,
        ];

        return view('pindah_sekolah/create', $data);
    }

    public function show($tipe, $id)
    {
        $pindah_sekolah = $this->pindah_sekolah->getData($id);
        $tahun_ajar = $this->tahun_ajar->getData($pindah_sekolah['id_tahun_ajar']);
        $user = $this->siswa->getData($pindah_sekolah['id_siswa']);
        $user['foto'] = $this->siswa->getFoto($user['id']);
        $pindah_sekolah['tahun_ajar'] = count($tahun_ajar) > 0 ? $tahun_ajar['tahun_mulai'].'/'.$tahun_ajar['tahun_selesai'] : '-';
        
        $data = [
            'pindah_sekolah' => $pindah_sekolah,
            'tipe' => $tipe,
            'user' => $user,
            'ortu' => $this->ortu->getData($user['id_ortu'])
        ];

        // dd($data);

        return view('pindah_sekolah/show', $data);
    }

    public function insert($tipe)
    {
        $this->db->transBegin();
        try{
            $data = $this->request->getPost();
            $data['tipe'] = $tipe;
            
            if($tipe == 'masuk'){
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                $siswa = $this->siswa->insertData($data);
                $data['id_siswa'] = $siswa;
                $data['tujuan'] = getNamaSekolah();
            }else{
                $siswa = $this->siswa->getData($data['id_siswa']);
                
                $this->siswa->updateData($siswa['id'], [
                    'status' => 'nonaktif',
                ]);

                $anggota_kelas = $this->anggota_kelas->where('id_siswa', $data['id_siswa'])->getData();
                foreach($anggota_kelas as $ak){
                    $this->anggota_kelas->updateData($ak['id'], [
                        'status' => 'nonaktif',
                    ]);
                }

                $data['asal'] = getNamaSekolah();
            }
            
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
        $siswa = $this->siswa->getData($pindah_sekolah['id_siswa']);
        $tahun_ajar = $this->tahun_ajar->getData();
        $data = [
            'tipe' => $pindah_sekolah['tipe'],
            'siswa' => $siswa,
            'tahun_ajar' => $tahun_ajar,
            'pindah_sekolah' => $pindah_sekolah,
        ];

        return view('pindah_sekolah/edit', $data);
    }

    public function update($tipe, $id_pindah)
    {
        $pindah_sekolah = $this->pindah_sekolah->getData($id_pindah);
        if(count($pindah_sekolah) == 0){
            session()->setFlashdata('error', 'Data pindah sekolah tidak ditemukan');
            return redirect()->back()->withInput();
        }

        try{
            $data = $this->request->getPost();
            
            if($tipe == 'keluar'){
                $data['asal'] = getNamaSekolah();
            }

            $this->pindah_sekolah->updateData($id_pindah, $data);
            session()->setFlashdata('success', 'Berhasil mengubah data pindah sekolah');
        }catch(\Exception $e){
            $this->db->transRollback();
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data pindah sekolah');
            return redirect()->back()->withInput();
        }

        return redirect()->to(route_to('pindah_sekolah_index', $tipe));
    }
}
