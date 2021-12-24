<?php

namespace App\Database\Seeds;

use App\Models\AnggotaKelasModel;
use App\Models\JadwalModel;
use App\Models\NilaiModel;
use CodeIgniter\Database\Seeder;

class NilaiSeeder extends Seeder
{

    protected $anggota_kelas;
    protected $jadwal;
    protected $nilai;

    public function __construct()
    {
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->jadwal = new JadwalModel();
        $this->nilai = new NilaiModel();
    }


    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $anggota_kelas = $this->anggota_kelas->findAll();
        foreach($anggota_kelas as $anggota){
            $jadwal = $this->jadwal->select('DISTINCT(id_mapel)')->where('id_kelas', $anggota['id_kelas'])->where('id_tahun_ajar', $anggota['id_tahun_ajar'])->findAll();
            foreach($jadwal as $jad){
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

    }
}
