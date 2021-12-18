<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use App\Models\TahunAjarModel;
use App\Models\UserModel;
use App\Models\WaliKelasModel;

class Nilai extends BaseController
{
    protected $kelas;
    protected $tahun_ajar;
    protected $jadwal;
    protected $user;
    protected $anggota_kelas;
    protected $mapel;
    protected $wali_kelas;
    protected $nilai;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->jadwal = new JadwalModel();
        $this->user = new UserModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->mapel = new MapelModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->nilai = new NilaiModel();
    }

    public function index()
    {
        $level = session()->get('level');
        if($level == 'siswa'){
            return $this->indexSiswa();
        }
    }

    private function indexGuru()
    {
        
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
                                'id_kelas' => $anggota_kelas['id_kelas'] ?? '-',
                                'id_tahun_ajar' => $anggota_kelas['id_tahun_ajar'] ?? '-',
                            ])
                            ->findAll()[0]['nama'] ?? '-';

        $nilai = $this->nilai
                            ->select(
                                'mapel.nama as nama_mapel, tugas, uts, uas'
                            )->join('kelas', 'nilai.id_kelas = kelas.id')
                            ->join('jadwal', 'nilai.id_jadwal = jadwal.id')
                            ->join('mapel', 'jadwal.id_mapel = mapel.id')
                            ->join('anggota_kelas', 'nilai.id_anggota_kelas = anggota_kelas.id')
                            ->where([
                                'nilai.id_kelas' => $anggota_kelas['id_kelas'] ?? '-',
                                'nilai.id_anggota_kelas' => $anggota_kelas['id'] ?? '-',
                                'jadwal.id_tahun_ajar' => $anggota_kelas['id_tahun_ajar'] ?? '-',
                            ])
                            ->findAll() ?? [];

        $data = [
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'nilai' => $nilai,
        ];

        return view('nilai/siswa/index', $data);
    }

    private function indexAdmin()
    {
        
    }

    private function indexOrtu()
    {
        
    }

    public function history()
    {
        $anggota_kelas = $this->anggota_kelas
                                ->join('kelas', 'anggota_kelas.id_kelas = kelas.id')
                                ->join('tahun_ajar', 'anggota_kelas.id_tahun_ajar = tahun_ajar.id')
                                ->where([
                                    'id_siswa' => session()->get('id'),
                                ])
                                ->orderBy('id_kelas', 'ASC')
                                ->findAll() ?? [];
        
        // dd($anggota_kelas);
                           
        $new_nilai = [];
        foreach($anggota_kelas as $anggota){
            $wali_kelas = $this->wali_kelas
                    ->select('users.nama')
                    ->join('users', 'wali_kelas.id_guru_wali = users.id')
                    ->where([
                        'id_kelas' => $anggota['id_kelas'] ?? '-',
                        'id_tahun_ajar' => $anggota['id_tahun_ajar'] ?? '-',
                    ])
                    ->findAll()[0]['nama'] ?? '-';

            $nilai = $this->nilai
                                ->select(
                                    'mapel.nama as nama_mapel, tugas, uts, uas'
                                )->join('kelas', 'nilai.id_kelas = kelas.id')
                                ->join('jadwal', 'nilai.id_jadwal = jadwal.id')
                                ->join('mapel', 'jadwal.id_mapel = mapel.id')
                                ->join('anggota_kelas', 'nilai.id_anggota_kelas = anggota_kelas.id')
                                ->where([
                                    'nilai.id_kelas' => $anggota['id_kelas'] ?? '-',
                                    'nilai.id_anggota_kelas' => $anggota['id'] ?? '-',
                                    'jadwal.id_tahun_ajar' => $anggota['id_tahun_ajar'] ?? '-',
                                ])
                                ->findAll();

            array_push($new_nilai, [
                'kelas' => convertRoman($anggota['jenjang']).$anggota['kode'],
                'tahun_ajar' => $anggota['tahun_mulai'].'/'.$anggota['tahun_selesai'],
                'wali_kelas' => $wali_kelas,
                'nilai' => $nilai
            ]);
        }

        // dd($new_nilai);

        $data = [
            // 'anggota_kelas' => $anggota_kelas,
            'history_nilai' => $new_nilai,
        ];

        // dd($data);

        return view('nilai/history/index', $data);
    }
}
