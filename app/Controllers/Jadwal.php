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
        if($level == 'siswa'){
            return $this->indexSiswa();
        }

        if($level == 'guru'){
            return $this->indexGuru();
        }

        if($level == 'ortu'){
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
        $anggota_kelas = $this->anggota_kelas
                                ->join('kelas', 'anggota_kelas.id_kelas = kelas.id')
                                ->join('tahun_ajar', 'anggota_kelas.id_tahun_ajar = tahun_ajar.id')
                                ->where([
                                    'id_siswa' => session()->get('id'),
                                    'id_tahun_ajar' => $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'],
                                ])
                                ->orderBy('id_kelas', 'DESC')
                                ->findAll()[0] ?? [];
   
        $wali_kelas = $this->wali_kelas
                            ->select('users.nama')
                            ->join('users', 'wali_kelas.id_guru_wali = users.id')
                            ->where([
                                'id_kelas' => $anggota_kelas['id_kelas'],
                                'id_tahun_ajar' => $anggota_kelas['id_tahun_ajar'],
                            ])
                            ->findAll()[0]['nama'] ?? '-';

        $jadwal = $this->jadwal
                            ->select('
                                kelas.id as id_kelas, kelas.jenjang as jenjang_kelas, 
                                users.nama as nama_guru, jadwal.id as id_jadwal, 
                                mapel.id as id_mapel, mapel.nama as nama_mapel,
                                jadwal.jam_mulai, jadwal.jam_selesai, jadwal.hari'
                            )->join('kelas', 'jadwal.id_kelas = kelas.id')
                            ->join('mapel', 'jadwal.id_mapel = mapel.id')
                            ->join('users', 'jadwal.id_guru = users.id')
                            ->where([
                                'id_kelas' => $anggota_kelas['id_kelas'],
                                'id_tahun_ajar' => $anggota_kelas['id_tahun_ajar'],
                            ])
                            ->findAll() ?? [];

        $data = [
            'jadwal' => $jadwal,
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
        $anak = $this->user->where('id_ortu', session()->get('id'))->findAll();
        $jadwal = [];
        $wali_kelas = [];

        $data = [
            'anak' => $anak,
            'jadwal' => $jadwal,
            'wali_kelas' => $wali_kelas,
        ];

        dd($data);

        return view('jadwal/ortu/index', $data);
    }
}
