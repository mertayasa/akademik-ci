<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TahunAjarSeeder extends Seeder
{
    public function run()
    {
        $tahun_start = 2019;
        $tahun_end = 2020;
        for($i=1; $i<=2; $i++){

            $data = [
                'tahun_mulai' => $tahun_start+1,
                'tahun_selesai' => $tahun_end+1,
                'status' => $i == 2 ? 'aktif' : 'nonaktif'
                // 'keterangan' => 'Tahun Ajaran '.($tahun_start+1).' - '.($tahun_end+1),
            ];

            $tahun_start = $tahun_start+1;
            $tahun_end = $tahun_end+1;

            $this->db->table('tahun_ajar')->insert($data);
        }

    }
}
