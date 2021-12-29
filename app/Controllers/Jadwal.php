<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\TahunAjarModel;
use App\Models\UserModel;
use App\Models\WaliKelasModel;

class Jadwal extends BaseController
{
    protected $kelas;
    protected $tahun_ajar;
    protected $jadwal;
    protected $user;
    protected $anggota_kelas;
    protected $mapel;
    protected $wali_kelas;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->jadwal = new JadwalModel();
        $this->user = new UserModel();
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

        if ($level == 'guru') {
            return $this->indexGuru();
        }

        if ($level == 'ortu') {
            return $this->indexOrtu();
        }
    }

    private function indexGuru()
    {
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];
        $guru = $this->user->getData(session()->get('id'));
        $jadwal = $this->jadwal->where([
            'id_guru', session()->get('id'),
            'id_tahun_ajar', $id_tahun_ajar,
        ])->findAll();

        $data = [
            'jadwal' => $jadwal,
            'guru' => $guru,
        ];

        dd($data);

        return view('jadwal/siswa/index', $data);
    }

    private function indexSiswa()
    {
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'] ?? null;
        $anggota_kelas = $this->anggota_kelas->get_anggota_by_id((session()->get('id')), $id_tahun_ajar)[0] ?? [];
        $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        $jadwal = $this->jadwal->get_jadwal_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar']) ?? [];
        $hari = $this->jadwal->get_hari($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar']) ?? [];

        $data = [
            'jadwal' => $jadwal,
            'hari' => $hari,
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
        ];

        return view('jadwal/siswa/index', $data);
    }

    private function indexAdmin()
    {
    }

    private function indexOrtu()
    {
        $id_siswa = $_GET['id_siswa'] ?? null;

        $siswa = $this->user->where('id_ortu', session()->get('id'))->findAll();
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'] ?? null;

        if (isset($siswa[0]['id'])) {
            $anggota_kelas = $this->anggota_kelas->get_anggota_by_id(($id_siswa ?? $siswa[0]['id']), $id_tahun_ajar)[0] ?? [];
        } else {
            $anggota_kelas = [];
        }

        if (isset($anggota_kelas)) {
            $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        } else {
            $wali_kelas = [];
        }

        if (isset($anggota_kelas)) {
            $jadwal = $this->jadwal->get_jadwal_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar']) ?? [];
        } else {
            $jadwal = [];
        }

        $hari = $this->jadwal->get_hari($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar']) ?? [];

        $data = [
            'id_siswa' => $id_siswa ?? ($anggota_kelas[0]['id'] ?? null),
            'siswa' => $siswa,
            'anggota_kelas' => $anggota_kelas,
            'jadwal' => $jadwal,
            'hari' => $hari,
            'wali_kelas' => $wali_kelas,
        ];

        return view('jadwal/ortu/index', $data);
    }
    public function ShowJadwalGuru()
    {
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];
        $jadwal = $this->jadwal->get_jadwal_guru(session()->get('id'), $id_tahun_ajar);
        $hari = $this->jadwal->get_hari_jadwal_guru(session()->get('id'), $id_tahun_ajar);
        // dd($hari);
        $data = [
            'jadwal'    => $jadwal,
            'hari'      => $hari
        ];
        return view('jadwal/guru/index', $data);
    }
}
