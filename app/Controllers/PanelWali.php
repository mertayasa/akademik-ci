<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\TahunAjarModel;
use App\Models\UserModel;
use App\Models\WaliKelasModel;
use App\Models\JadwalModel;

class PanelWali extends BaseController
{

    protected $user;
    protected $wali_kelas;
    protected $anggota_kelas;
    protected $tahun_ajar;
    protected $jadwal;
    protected $request;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->jadwal = new JadwalModel;
        $this->request = \Config\Services::request();
    }

    public function index()
    {
        $user = $this->user->getData(session()->get('id'));
        $id_tahun_ajar = $this->tahun_ajar->getActiveId();
        $id_kelas = $this->request->getVar('id_kelas');
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun_ajar);
        $absensi =
            $kelas = $this->wali_kelas
            ->join('kelas', 'wali_kelas.id_kelas = kelas.id')
            ->join('users', 'wali_kelas.id_guru_wali = users.id')
            ->join('tahun_ajar', 'wali_kelas.id_tahun_ajar = tahun_ajar.id')
            ->where([
                'id_guru_wali' => $user['id'],
                'id_tahun_ajar' => $id_tahun_ajar
            ])->findAll();

        foreach ($kelas as $key => $each) {
            $kelas[$key]['jumlah_siswa'] = $this->assignStudentCount($each, $id_tahun_ajar);
            $kelas[$key]['hari'] = $this->jadwal->get_hari($each['id_kelas'], $each['id_tahun_ajar']);
            $kelas[$key]['jadwal'] = $this->jadwal->get_jadwal_by_id($each['id_kelas'], $each['id_tahun_ajar']);
            $kelas[$key]['absen'] = $this->anggota_kelas
                ->select('anggota_kelas.id as anggota_kelas_id,anggota_kelas.id_kelas as kelas_id,anggota_kelas.id_tahun_ajar as tahun_ajar_id,anggota_kelas.id_siswa as siswa_id, users.nama as siswa_nama, ')
                ->join('users', 'anggota_kelas.id_siswa=users.id')
                ->where([
                    'id_kelas' => $each['id_kelas'],
                    'id_tahun_ajar' => $each['id_tahun_ajar']
                ])->findAll();
        }
        // dd($kelas[$key]['jadwal']);

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'kelas' => $kelas,
        ];


        return view('panel_wali/index', $data);
    }

    private function assignStudentCount($array, $id_tahun)
    {
        return $this->anggota_kelas
            ->where(['id_kelas' => $array['id_kelas'], 'id_tahun_ajar' => $id_tahun])
            ->countAllResults() ?? null;
    }
    public function absensi($id_kelas, $id_tahun_ajar, $id_jadwal)
    {
        $absensi = $this->anggota_kelas
            ->select('anggota_kelas.id as anggota_kelas_id,anggota_kelas.id_kelas as kelas_id,anggota_kelas.id_tahun_ajar as tahun_ajar_id,anggota_kelas.id_siswa as siswa_id, users.nama as siswa_nama, ')
            ->join('users', 'anggota_kelas.id_siswa=users.id')
            ->where([
                'id_kelas' => $id_kelas,
                'id_tahun_ajar' => $id_tahun_ajar
            ])->findAll();
        $data = [
            'absensi' => $absensi,
            'id_jadwal' => $id_jadwal
        ];

        return view('panel_wali/index_absensi', $data);
    }
}
