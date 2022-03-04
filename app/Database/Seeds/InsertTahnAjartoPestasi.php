<?php

namespace App\Database\Seeds;

use App\Models\PrestasiModel;
use App\Models\TahunAjarModel;
use CodeIgniter\Database\Seeder;

class InsertTahnAjartoPestasi extends Seeder
{
    protected $prestasi_m;
    protected $tahun_ajar_m;
    public function run()
    {
        $this->prestasi_m = new PrestasiModel;
        $this->tahun_ajar_m = new TahunAjarModel;
        $data_prestasi = $this->prestasi_m->getData();
        $id_tahun_aktif = $this->tahun_ajar_m->where('status', 'aktif')->find();
        foreach ($data_prestasi as $prestasi) {
            $this->prestasi_m->updateData($prestasi['id'], ['id_tahun_ajar' => $id_tahun_aktif[0]['id']]);
        }
    }
}
