<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\KelasModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;
use App\Models\JadwalModel;
use Carbon\Carbon;

class Akademik extends BaseController
{
    protected $kelas;
    protected $anggota_kelas;
    protected $wali_kelas;
    protected $tahun_ajar;
    protected $jadwal;
    protected $db;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->db = db_connect();
    }

    public function index()
    {
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
            'tahun_ajar_selected' => $selected_tahun,
        ];

        return view('akademik/index', $data);
    }

    private function getJenjang($id_tahun)
    {
        $jenjang   = array();
        $data   = $this->kelas->getData();

        foreach ($data as $each) {
            $jenjang[$each['jenjang']]['kelas'] = $this->assignTeacherAndCountStudent($this->kelas->where('jenjang', $each['jenjang'])->findAll(), $id_tahun, $each['jenjang']);
        }
        return $jenjang;
    }

    public function assignTeacherAndCountStudent($array, $id_tahun)
    {
        $new_class = [];
        foreach ($array as $data) {
            $data['nama_guru'] = $this->wali_kelas
                ->select('users.nama as nama_guru, wali_kelas.id_kelas, wali_kelas.id_tahun_ajar')
                ->join('users', 'wali_kelas.id_guru_wali = users.id')
                ->where(['id_kelas' => $data['id'], 'id_tahun_ajar' => $id_tahun])
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

    public function showSchedule($id_kelas, $id_tahun_ajar)
    {
        $this->jadwal = new JadwalModel;
        $jadwal_kelas = $this->jadwal->get_jadwal_by_id($id_kelas, $id_tahun_ajar);
        $jadwal_hari = $this->jadwal->get_hari($id_kelas, $id_tahun_ajar);
        $kelas = $this->kelas->getData($id_kelas);
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun_ajar);
        $include = 'akademik/student/jadwal';

        $data = [
            'jadwal'       => $jadwal_kelas,
            'hari'         => $jadwal_hari,
            'kelas'        => $kelas,
            'tahun_ajar'   => $tahun_ajar,
            'breadcrumb'   => 'Daftar Jadwal',
            'include_view' => $include
        ];

        // dd($jadwal_kelas);
        return view('akademik/student/index', $data);
    }
}
