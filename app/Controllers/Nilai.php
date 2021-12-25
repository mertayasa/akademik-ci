<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
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
    protected $user;
    protected $anggota_kelas;
    protected $mapel;
    protected $wali_kelas;
    protected $nilai;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->tahun_ajar = new TahunAjarModel();
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

        if($level == 'ortu'){
            return $this->indexOrtu();
        }
    }

    private function indexGuru()
    {
        
    }

    private function indexSiswa()
    {
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];
        $anggota_kelas = $this->anggota_kelas->get_anggota_by_id((session()->get('id')), $id_tahun_ajar)[0] ?? [];
        $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        $nilai = $this->nilai->get_nilai_by_anggota($anggota_kelas['id']) ?? [];

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
        $id_siswa = $_GET['id_siswa'] ?? null;
        $siswa = $this->user->where('id_ortu', session()->get('id'))->findAll();
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];
        
        if(isset($siswa[0]['id'])){
            $anggota_kelas = $this->anggota_kelas->get_anggota_by_id($id_siswa ?? $siswa[0]['id'], $id_tahun_ajar)[0] ?? [];
        }else{
            $anggota_kelas = [];
        }

        if(isset($anggota_kelas)){
            $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        }else{
            $wali_kelas = [];
        }

        if(isset($anggota_kelas)){
            $nilai = $this->nilai->get_nilai_by_anggota($anggota_kelas['id']) ?? [];
        }else{
            $nilai = [];
        }

        $data = [
            'id_siswa' => $id_siswa ?? ($anggota_kelas[0]['id'] ?? null),
            'siswa' => $siswa,
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'nilai' => $nilai,
        ];

        return view('nilai/ortu/index', $data);
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
                                ->join('mapel', 'nilai.id_mapel = mapel.id')
                                ->join('anggota_kelas', 'nilai.id_anggota_kelas = anggota_kelas.id')
                                ->where([
                                    // 'nilai.id_kelas' => $anggota['id_kelas'] ?? '-',
                                    'nilai.id_anggota_kelas' => $anggota['id'] ?? '-',
                                    // 'anggota_kelas.id_tahun_ajar' => $anggota['id_tahun_ajar'] ?? '-',
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
