<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;

class Aseg extends BaseController
{
    protected $user;
    protected $anggota_kelas;
    protected $tahun_ajar;
    protected $kelas;
    protected $jadwal;
    protected $nilai;
    protected $siswa;

    public function __construct()
    {
        // $this->user = new UserModel();
        $this->siswa = new SiswaModel();
        $this->nilai = new NilaiModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->kelas = new KelasModel();
        $this->jadwal = new JadwalModel();
    }

    public function index()
    {
        $asd = [];
        $users = $this->siswa->findAll();
        $tahun_ajar = $this->tahun_ajar->getData();
        foreach ($tahun_ajar as $th => $tahun) {
            foreach ($users as $key => $user) {
                if ($th + 1 <= 6) {
                    $kelas = $this->kelas->where('jenjang', $th + 1)->orderBy('id', 'RANDOM')->findAll()[0] ?? '';
                    $data = [
                        'id_kelas' => $kelas['id'],
                        'jenjang' => $kelas['jenjang'],
                        'id_siswa' => $user['id'],
                        'id_tahun_ajar' => $tahun['id'],
                        'status' => 'aktif'
                    ];

                    array_push($asd, $data);
                    // $this->anggota_kelas->insert($data);
                }
            }
        }

        dd($asd);
    }

    public function aseg()
    {
        $asd = [];
        $anggota_kelas = $this->anggota_kelas->findAll();
        foreach ($anggota_kelas as $anggota) {
            $jadwal = $this->jadwal->select('DISTINCT(id_mapel)')->where('id_kelas', $anggota['id_kelas'])->where('id_tahun_ajar', $anggota['id_tahun_ajar'])->findAll();
            foreach ($jadwal as $jad) {
                $nilai = [
                    'id_kelas' => $anggota['id_kelas'],
                    'id_mapel' => $jad['id_mapel'],
                    'id_anggota_kelas' => $anggota['id'],
                    'tugas' => rand(50, 99),
                    'uts' => rand(50, 99),
                    'uas' => rand(50, 99)
                ];
                $this->nilai->updateOrInsert(['id_kelas' => $nilai['id_kelas'], 'id_mapel' => $nilai['id_mapel'], 'id_anggota_kelas' => $nilai['id_anggota_kelas']], $nilai);
            }
        }

        dd($asd);
    }
}
