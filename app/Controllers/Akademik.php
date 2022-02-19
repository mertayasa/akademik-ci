<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\AnggotaKelasModel;
use App\Models\KelasModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;
use App\Models\JadwalModel;
use App\Models\MapelModel;
use App\Models\GuruKepsekModel;
use App\Models\SiswaModel;
use PhpParser\Node\Stmt\Catch_;

// use Carbon\Carbon;
// use phpDocumentor\Reflection\Types\This;

class Akademik extends BaseController
{
    protected $kelas;
    protected $anggota_kelas;
    protected $wali_kelas;
    protected $tahun_ajar;
    protected $jadwal;
    protected $absensi;
    protected $mapel;
    protected $guru;
    protected $db;
    protected $request;
    protected $session;

    public function __construct()
    {
        $this->tahun_ajar = new TahunAjarModel();
        $this->kelas = new KelasModel();
        $this->guru = new GuruKepsekModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->absensi = new AbsensiModel();
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
        $this->db = db_connect();
    }

    public function index()
    {
        // $this->generateWali();
        $this->kelas = new KelasModel();
        if (!$this->tahun_ajar->getData()) {
            return route_to('dashboard_index');
        }

        $tahun_ajar_raw = $this->tahun_ajar->getData();
        $tahun_ajar = [];

        $param_tahun = $this->request->getPost('tahun_ajar');
        $selected_tahun = $param_tahun;

        if (!$param_tahun) {
            $selected_tahun = $this->tahun_ajar->getActiveId();
        }

        $kelas = $this->getJenjang($selected_tahun);

        foreach ($tahun_ajar_raw as $raw) {
            $tahun_ajar[$raw['id']] = $raw['tahun_mulai'] . '/' . $raw['tahun_selesai'];
        }

        $data = [
            'kelas' => $kelas,
            'tahun_ajar' => $tahun_ajar,
            'tahun_ajar_active' => $this->tahun_ajar->find($this->tahun_ajar->getActiveId()),
            'tahun_ajar_selected' => $selected_tahun,
        ];

        // dd($data);

        return view('akademik/index', $data);
    }

    // public function generateWali()
    // {
    //     $asd = [];
    //     $kelas = $this->kelas->getData();
    //     foreach ($kelas as $kel) {
    //         $tahun_ajar = $this->tahun_ajar->getData();
    //         foreach ($tahun_ajar as $tahun) {
    //             $wali_kelas = $this->wali_kelas
    //             ->select('id_guru_wali')
    //             ->where([
    //                 'id_tahun_ajar' => $tahun['id'],
    //             ])
    //             ->findAll();

    //             if(count($wali_kelas) < 1){
    //                 $data = [
    //                     'id_kelas' => $kel['id'],
    //                     'id_guru_wali' => $this->guru->where('level', 'guru')->orderBy('id', 'RANDOM')->findAll()[0]['id'],
    //                     'id_tahun_ajar' => $tahun['id'],
    //                 ];
    //                 $this->wali_kelas->updateOrInsert(['id_kelas' => $data['id_kelas'], 'id_guru_wali' => $data['id_guru_wali'], 'id_tahun_ajar' => $data['id_tahun_ajar']], $data);
    //             }else{
    //                 $id_wali = [];

    //                 foreach($wali_kelas as $wali){
    //                     array_push($id_wali, $wali['id_guru_wali']);
    //                 }

    //                 // dd($id_wali);

    //                 $wali = $this->guru->whereNotIn('id', $id_wali)->where('level', 'guru')->orderBy('id', 'RANDOM')->findAll();
    //                 if(count($wali) > 0){
    //                     $data = [
    //                         'id_kelas' => $kel['id'],
    //                         'id_guru_wali' => $wali[0]['id'],
    //                         'id_tahun_ajar' => $tahun['id'],
    //                     ];
    //                     $this->wali_kelas->updateOrInsert(['id_kelas' => $data['id_kelas'], 'id_guru_wali' => $data['id_guru_wali'], 'id_tahun_ajar' => $data['id_tahun_ajar']], $data);
    //                 }
    //             }


    //         }
    //     }

    //     dd($asd);
    // }

    // function array_flatten($array) {
    //     $return = array();
    //     foreach ($array as $key => $value) {
    //         if (is_array($value)){
    //             $return = array_merge($return, $this->array_flatten($value));
    //         } else {
    //             $return[$key] = $value;
    //         }
    //     }

    //     return $return;
    // }    

    private function getJenjang($id_tahun)
    {
        $this->kelas = new KelasModel();
        $jenjang   = array();
        $data   = $this->kelas->getData();

        foreach ($data as $each) {
            $jenjang[$each['jenjang']]['kelas'] = $this->assignTeacherAndCountStudent($this->kelas->where('jenjang', $each['jenjang'])->findAll(), $id_tahun, $each['jenjang']);
        }
        return $jenjang;
    }

    public function assignTeacherAndCountStudent($array, $id_tahun)
    {
        $this->kelas = new KelasModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->guru = new GuruKepsekModel();
        $new_class = [];
        foreach ($array as $data) {
            $data['nama_guru'] = $this->wali_kelas
                ->select('guru_kepsek.nama as nama_guru, wali_kelas.id_kelas, wali_kelas.id_tahun_ajar')
                ->join('guru_kepsek', 'wali_kelas.id_guru_wali = guru_kepsek.id')
                ->where(['id_kelas' => $data['id'], 'id_tahun_ajar' => $id_tahun, 'wali_kelas.status' => 'aktif'])
                ->findAll()[0]['nama_guru'] ?? null;

            $data['jumlah_siswa'] = $this->anggota_kelas
                ->where(['id_kelas' => $data['id'], 'id_tahun_ajar' => $id_tahun])
                ->countAllResults() ?? null;

            array_push($new_class, $data);
        }

        return $new_class;
    }

    public function showStudent($id_tahun, $id_kelas)
    {
        $this->kelas = new KelasModel();
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun);
        $kelas = $this->kelas->getData($id_kelas);
        $include = 'akademik/student/datatable';

        $data = [
            'tahun_ajar'   => $tahun_ajar,
            'kelas'        => $kelas,
            'breadcrumb'   => 'Daftar Siswa',
            'include_view' => $include
        ];

        return view('akademik/student/index', $data);
    }

    public function showAbsensi($id_kelas, $id_tahun_ajar)
    {
        $data = $this->absensi->getAbsensiByKelas($id_kelas, $id_tahun_ajar);
        // dd($data);
        return view('akademik/absensi/index', $data);
    }

    public function showSchedule($id_kelas, $id_tahun_ajar)
    {
        $this->jadwal = new JadwalModel;
        $this->guru = new GuruKepsekModel;
        $this->mapel = new MapelModel;
        $jadwal_kelas = $this->jadwal->get_jadwal_by_id($id_kelas, $id_tahun_ajar);
        $jadwal_hari = $this->jadwal->get_hari($id_kelas, $id_tahun_ajar);
        $guru = $this->guru->where('level', 'guru')->get()->getResultObject();
        $mapel = $this->mapel->findAll();
        $kelas = $this->kelas->getData($id_kelas);
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun_ajar);
        $include = 'akademik/student/jadwal';

        $data = [
            'jadwal'       => $jadwal_kelas,
            'hari'         => $jadwal_hari,
            'hari_all'     => getHari(),
            'kelas'        => $kelas,
            'mapel'        => $mapel,
            'tahun_ajar'   => $tahun_ajar,
            'breadcrumb'   => 'Daftar Jadwal',
            'guru'         => $guru,
            'include_view' => $include,
            'uri'          => service('uri')
        ];

        return view('akademik/student/index', $data);
    }
    public function update()
    {
        $this->jadwal = new JadwalModel;
        $id = $this->request->getVar('id_jadwal');
        $id_kelas = $this->request->getPost('id_kelas_post');
        $id_tahun_ajar = $this->request->getPost('id_tahun_ajar_post');
        $data = [
            'id_mapel'  => $this->request->getPost('nama_mapel'),
            'id_guru'   => $this->request->getPost('nama_guru'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai')
        ];

        try {
            $this->jadwal->updateData($id, $data);
            $this->session->setFlashdata('success', 'Update Successful');
            return redirect()->to(route_to('akademik_show_schedule', $id_kelas, $id_tahun_ajar));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            $this->session->setFlashdata('error', 'Update Failed');
            return redirect()->back()->withInput();
        }
    }
    public function set_status($id, $id_kelas, $id_tahun_ajar)
    {
        $this->jadwal = new JadwalModel;

        $data = ['status' => 'nonaktif'];
        try {
            $this->jadwal->updateData($id, $data);
            $this->session->setFlashdata('success', 'delete Successful');
            return redirect()->to(route_to('akademik_show_schedule', $id_kelas, $id_tahun_ajar));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            $this->session->setFlashdata('error', 'delete Failed');
            return redirect()->back()->withInput();
        }
    }

    public function waliPerkelas($id_kelas, $id_tahun_ajar)
    {
        $this->kelas = new KelasModel();
        $this->guru = new GuruKepsekModel;
        $this->wali_kelas = new WaliKelasModel;
        $guru_list = $this->guru->where('level', 'guru')->orderBy('nama', 'asd')->findAll();
        $wali = $this->wali_kelas->get_wali_kelas_by_id($id_kelas, $id_tahun_ajar);
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun_ajar);
        $kelas = $this->kelas->getData($id_kelas);
        $iinclude = 'akademik/wali_kelas';

        $data = [
            'wali_kelas'    => $wali,
            'guru'          => $guru_list,
            'kelas'         => $kelas,
            'tahun_ajar'    => $tahun_ajar,
            'id_kelas'      => $id_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'include_view'  => $iinclude,
            'breadcrumb'    => 'Wali Kelas',
            'no'            => 1
        ];

        return view('akademik/student/index', $data);
    }
    public function insertWaliPerkelas($id_kelas, $id_tahun_ajar)
    {
        $this->wali_kelas = new WaliKelasModel();
        $wali = $this->request->getPost('nama_guru');
        $wali_sebelumnya = $this->wali_kelas->get_wali_kelas_by_status($id_kelas, $id_tahun_ajar);
        $data = [
            'id_guru_wali'  => $wali,
            'id_kelas'      => $id_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'status'        => 'aktif'
        ];

        try {
            if ($wali_sebelumnya != null) {
                if ($this->wali_kelas->updateData($wali_sebelumnya->id, ['status' => 'nonaktif'])) {
                    $this->wali_kelas->save($data);
                }
            } else {
                $this->wali_kelas->save($data);
            }
            $this->session->setFlashdata('success', 'Wali Kelas Berhasil Ditambahkan');
            return redirect()->to(route_to('show_wali', $id_kelas, $id_tahun_ajar));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            $this->session->setFlashdata('error', 'Gagal Menambahkan Wali');
            return redirect()->back()->withInput();
        }
    }
    public function updateWali($id_wali)
    {
        $this->wali_kelas = new WaliKelasModel();
        // $id = $this->request->getPost('id');
        // $id_guru = $this->request->getPost('nama_guru');
        $id_kelas = $this->request->getPost('id_kelas');
        $id_tahun_ajar = $this->request->getPost('id_tahun_ajar');
        $wali_aktif = $this->wali_kelas->get_wali_kelas_by_status($id_kelas, $id_tahun_ajar);
        $status = $this->request->getPost('status');
        // $data = [
        //     'id'           => $id,
        //     'id_guru_wali' => $id_guru
        // ];
        $data = [
            'status' => $status
        ];
        try {
            // $this->wali_kelas->updateData($id, $data);
            if ($status == 'aktif') {
                if ($wali_aktif != null) {
                    if ($this->wali_kelas->updateData($wali_aktif->id, ['status' => 'nonaktif'])) {
                        $this->wali_kelas->updateData($id_wali, $data);
                    }
                } else {
                    $this->wali_kelas->updateData($id_wali, $data);
                }
            }
            // $this->session->setFlashdata('success', 'Wali Kelas Berhasil Diedit');
            // return redirect()->to(route_to('show_wali', $id_kelas, $id_tahun_ajar));
            return json_encode(['code' => 1, 'message' => 'Update status wali berhasil']);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            // $this->session->setFlashdata('error', 'Gagal Menedit Wali');
            // return redirect()->back();
            return json_encode(['code' => 0, 'message' => 'Update status wali gagal']);
        }
    }
    public function destroyWali($id_wali, $id_kelas, $id_tahun_ajar)
    {
        $this->wali_kelas = new WaliKelasModel();
        try {
            $this->wali_kelas->delete($id_wali);
            $this->session->setFlashdata('success', 'Wali Kelas Berhasil Dihapus');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            $this->session->setFlashdata('error', 'Gagal Menghapus Wali');
        }
        return redirect()->back();
    }
    public function searchAnggota()
    {
        $siswaModel = new SiswaModel();
        $nis = $_GET['nis'];
        $data = $siswaModel->select('id, nis, nama, status')
            ->where('nis', $nis)
            ->findAll();
        if (count($data) > 0) {
            foreach ($data as $value) {
                $result[] = [
                    'nama' => $value['nama'],
                    'id_siswa' => $value['id'],
                    'nis' => $value['nis'],
                    'status' => $value['status']
                ];
            }
        } else {
            $result = null;
        }
        echo json_encode($result);
    }
    public function insertAnggota()
    {
        $id_kelas = $this->request->getPost('id_kelas');
        $id_siswa = $this->request->getPost('id_siswa');
        $id_tahun_ajar = $this->request->getPost('id_tahun_ajar');
        $data = $this->anggota_kelas->search_anggota($id_siswa);
        try {
            if ($data != null) {
                foreach ($data as $value) {
                    if ($value['id_kelas'] != $id_kelas && $value['id_tahun_ajar'] == $id_tahun_ajar) {
                        if ($value['id_kelas'] != $id_kelas && $value['id_tahun_ajar'] <= $id_tahun_ajar) {
                            return json_encode($result = ['code' => 1, 'message' => 'Siswa sudah berada di kelas lainnya']);
                        }
                    }
                    if ($value['id_kelas'] == $id_kelas && $value['id_tahun_ajar'] == $id_tahun_ajar) {
                        return json_encode($result = ['code' => 1, 'message' => 'Siswa sudah berada di kelas ini']);
                    }
                }
            }
            $insert_data = [
                'id_kelas' => $id_kelas,
                'id_siswa' => $id_siswa,
                'id_tahun_ajar' => $id_tahun_ajar
            ];
            $result = ['code' => 2, 'message' => 'Siswa sberhasil ditambahakan'];
            $this->anggota_kelas->insertData($insert_data);
            return json_encode($result);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            $result = ['code' => 1, 'message' => 'Siswa gagal ditambahkan'];
            return json_encode($result);
        }
    }
}
