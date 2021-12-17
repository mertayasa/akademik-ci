<?php

namespace App\Database\Seeds;

use App\Models\MapelModel;
use CodeIgniter\Database\Seeder;

class MapelSeeder extends Seeder
{

    protected $mapel;
    public function __construct()
    {
        $this->mapel = new MapelModel();
    }

    public function run()
    {
        $mapel = [
            [
                'nama' => 'Ipa',
                'status' => 'aktif'
            ],
            [
                'nama' => 'Ips',
                'status' => 'aktif'
            ],
            [
                'nama' => 'Matematika',
                'status' => 'aktif'
            ],
            [
                'nama' => 'Agama',
                'status' => 'aktif'
            ],
            [
                'nama' => 'Olahraga',
                'status' => 'aktif'
            ],
            [
                'nama' => 'Olahraga',
                'status' => 'aktif'
            ],
        ];

        foreach ($mapel as $key => $data) {
            $this->mapel->updateOrInsert(['nama' => $data['nama']], $data);
        }
    }
}
