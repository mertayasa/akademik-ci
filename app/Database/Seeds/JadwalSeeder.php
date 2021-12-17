<?php

namespace App\Database\Seeds;

use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\TahunAjarModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class JadwalSeeder extends Seeder
{
    protected $user;
    protected $tahun_ajar;
    protected $kelas;
    protected $mapel;
    protected $jadwal;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->mapel = new MapelModel();
        $this->kelas = new KelasModel();
        $this->jadwal = new JadwalModel();
    }

    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $kelas = $this->kelas->getData();
        foreach($kelas as $kel){
            $tahun_ajar = $this->tahun_ajar->getData();
            foreach($tahun_ajar as $tahun){
                for($i=0; $i<=10; $i++){
                    $data = [
                        'id_kelas' => $kel['id'],
                        'id_guru' => $this->user->where('level', 'guru')->orderBy('id', 'RANDOM')->findAll()[0]['id'],
                        'id_tahun_ajar' => $tahun['id'],
                        'status' => 'aktif',
                        'id_mapel' => $this->mapel->orderBy('id', 'RANDOM')->findAll()[0]['id'],
                        'jam_mulai' => $faker->time(),
                        'jam_selesai' => $faker->time(), 
                        'hari' => $this->getHari()[rand(0,6)],
                    ];
        
                    $this->jadwal->updateOrInsert(['id_kelas' => $data['id_kelas'], 'id_tahun_ajar' => $data['id_tahun_ajar']], $data);
                }
            }
        }
    }

    private function getHari()
    {
        return [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu',
        ];
    }
}
