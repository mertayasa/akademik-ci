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
        $anggota_kelas = $this->anggota_kelas->getData();
        foreach($anggota_kelas as $anggota){
            $jadwal = $this->jadwal->where('id_kelas', $anggota['id_kelas'])->findAll();
            foreach($jadwal as $jad){
                $nilai = [
                    'id_kelas' => $jad['id_kelas'],
                    'id_jadwal' => $jad['id'], 
                    'id_anggota_kelas' => $anggota['id'], 
                    'tugas' => rand(50, 99), 
                    'uts' => rand(50, 99), 
                    'uas' => rand(50, 99)
                ];

                $this->nilai->updateOrInsert(['id_kelas' => $nilai['id_kelas'], 'id_jadwal' => $nilai['id_jadwal'], 'id_anggota_kelas' => $nilai['id_anggota_kelas']], $nilai);
            }
        }
    }
}
