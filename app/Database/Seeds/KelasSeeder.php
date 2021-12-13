<?php

namespace App\Database\Seeds;

use App\Models\KelasModel;
use CodeIgniter\Database\Seeder;

class KelasSeeder extends Seeder
{
    protected $kelas;

    public function __construct()
    {
        $this->kelas = new KelasModel();
    }

    public function run()
    {
        for($i=1; $i<=6; $i++){
            $kelas = [
                [
                    'jenjang' => $i,
                    'kode' => 'A'
                ],
                [
                    'jenjang' => $i,
                    'kode' => 'B'
                ],
                [
                    'jenjang' => $i,
                    'kode' => 'C'
                ],
                [
                    'jenjang' => $i,
                    'kode' => 'D'
                ],
            ];

            $this->kelas->insertBatch($kelas);
        }
    }
}
