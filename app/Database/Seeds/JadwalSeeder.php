<?php

namespace App\Database\Seeds;

use App\Models\GuruKepsekModel;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\TahunAjarModel;
use CodeIgniter\Database\Seeder;

class JadwalSeeder extends Seeder
{
    protected $user;
    protected $tahun_ajar;
    protected $kelas;
    protected $mapel;
    protected $jadwal;
    protected $guru;

    public function __construct()
    {
        // $this->user = new UserModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->mapel = new MapelModel();
        $this->kelas = new KelasModel();
        $this->jadwal = new JadwalModel();
        $this->guru = new GuruKepsekModel();
    }

    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $kelas = $this->kelas->getData();
        foreach ($kelas as $kel) {
            $tahun_ajar = $this->tahun_ajar->getData();
            foreach ($tahun_ajar as $tahun) {
                for ($i = 0; $i < 10; $i++) {
                    $random_hari = rand(0, 6);
                    $data = [
                        'id_kelas' => $kel['id'],
                        'id_guru' => $this->guru->where('level', 'guru')->orderBy('id', 'RANDOM')->findAll()[0]['id'],
                        'id_tahun_ajar' => $tahun['id'],
                        'status' => 'aktif',
                        'id_mapel' => $this->mapel->orderBy('id', 'RANDOM')->findAll()[0]['id'],
                        'jam_mulai' => $faker->time(),
                        'jam_selesai' => $faker->time(),
                        'hari' => $this->getHari()[$random_hari],
                        'kode_hari' => ($random_hari + 1),
                    ];

                    $this->jadwal->insert($data);
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
