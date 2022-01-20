<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\AnggotaKelasModel;
use App\Models\GuruKepsekModel;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;

class Absensi extends BaseController
{
    protected $kelas;
    protected $tahun_ajar;
    protected $jadwal;
    protected $user;
    protected $guru;
    protected $absensi;
    protected $anggota_kelas;
    protected $mapel;
    protected $wali_kelas;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->jadwal = new JadwalModel();
        $this->guru = new GuruKepsekModel();
        $this->siswa = new SiswaModel();
        $this->absensi = new AbsensiModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->mapel = new MapelModel();
        $this->wali_kelas = new WaliKelasModel();
    }

    public function index()
    {
        $level = session()->get('level');
        if ($level == 'siswa') {
            return $this->indexSiswa();
        }

        if ($level == 'ortu') {
            return $this->indexOrtu();
        }
    }

    public function indexSiswa()
    {
        $siswa = $this->siswa->where('id', session()->get('id'))->findAll();
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'] ?? null;

        if (isset($siswa[0]['id'])) {
            $anggota_kelas = $this->anggota_kelas->get_anggota_by_id(($id_siswa ?? $siswa[0]['id']), $id_tahun_ajar)[0] ?? [];
        } else {
            $anggota_kelas = [];
        }

        if (isset($anggota_kelas) && count($anggota_kelas) != 0) {
            $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        } else {
            $wali_kelas = '';
        }

        if(isset($anggota_kelas) && count($anggota_kelas) != 0){
            $count_absen = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->countAllResults();
            $absen_ganjil = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'], 'ganjil')->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->orderBy('absensi.tanggal', 'ASC')->findAll();
            $absen_genap = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'], 'genap')->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->orderBy('absensi.tanggal', 'ASC')->findAll();
        }else{
            $count_absen = [];
            $absen_ganjil = [];
            $absen_genap = [];
        }

        if(isset($anggota_kelas) && count($anggota_kelas) != 0){
            $absen = $this->anggota_kelas
                ->select('anggota_kelas.id as anggota_kelas_id,anggota_kelas.id_kelas as kelas_id,anggota_kelas.id_tahun_ajar as tahun_ajar_id,anggota_kelas.id_siswa as siswa_id, siswa.nama as siswa_nama, ')
                ->join('siswa', 'anggota_kelas.id_siswa=siswa.id')
                ->where([
                    'id_kelas' => $anggota_kelas['id_kelas'],
                    'id_tahun_ajar' => $anggota_kelas['id_tahun_ajar'],
                    'anggota_kelas.id' => $anggota_kelas['id'],
                ])->findAll();
        }else{
            $absen = [];
        }

        $data = [
            'id_siswa' => $id_siswa ?? ($anggota_kelas[0]['id'] ?? null),
            'siswa' => $siswa,
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'id_kelas' => $anggota_kelas['id_kelas'] ?? null,
            'count_absen' => $count_absen,
            'absen_ganjil' => $absen_ganjil,
            'absen_genap' => $absen_genap,
            'absen' => $absen,
        ];

        // dd($data);

        return view('absensi/siswa/index', $data);
    }

    private function indexOrtu()
    {
        $id_siswa = $_GET['id_siswa'] ?? null;

        $siswa = $this->siswa->where('id_ortu', session()->get('id'))->findAll();
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'] ?? null;

        if (isset($siswa[0]['id'])) {
            $anggota_kelas = $this->anggota_kelas->get_anggota_by_id(($id_siswa ?? $siswa[0]['id']), $id_tahun_ajar)[0] ?? [];
        } else {
            $anggota_kelas = [];
        }

        if (isset($anggota_kelas) && count($anggota_kelas) != 0) {
            $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        } else {
            $wali_kelas = '';
        }

        if(isset($anggota_kelas) && count($anggota_kelas) != 0){
            $count_absen = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->countAllResults();
            $absen_ganjil = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'], 'ganjil')->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->orderBy('absensi.tanggal', 'ASC')->findAll();
            $absen_genap = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'], 'genap')->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->orderBy('absensi.tanggal', 'ASC')->findAll();
        }else{
            $count_absen = [];
            $absen_ganjil = [];
            $absen_genap = [];
        }

        if(isset($anggota_kelas) && count($anggota_kelas) != 0){
            $absen = $this->anggota_kelas
                ->select('anggota_kelas.id as anggota_kelas_id,anggota_kelas.id_kelas as kelas_id,anggota_kelas.id_tahun_ajar as tahun_ajar_id,anggota_kelas.id_siswa as siswa_id, siswa.nama as siswa_nama, ')
                ->join('siswa', 'anggota_kelas.id_siswa=siswa.id')
                ->where([
                    'id_kelas' => $anggota_kelas['id_kelas'],
                    'id_tahun_ajar' => $anggota_kelas['id_tahun_ajar'],
                    'anggota_kelas.id' => $anggota_kelas['id'],
                ])->findAll();
        }else{
            $absen = [];
        }

        $data = [
            'id_siswa' => $id_siswa ?? ($anggota_kelas[0]['id'] ?? null),
            'siswa' => $siswa,
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'id_kelas' => $anggota_kelas['id_kelas'] ?? null,
            'count_absen' => $count_absen,
            'absen_ganjil' => $absen_ganjil,
            'absen_genap' => $absen_genap,
            'absen' => $absen,
        ];

        // dd($data);

        return view('absensi/ortu/index', $data);
    }
}