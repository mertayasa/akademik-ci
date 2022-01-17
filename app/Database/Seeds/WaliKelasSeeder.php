<?php

namespace App\Database\Seeds;

use App\Models\GuruKepsekModel;
use App\Models\KelasModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;
use CodeIgniter\Database\Seeder;

class WaliKelasSeeder extends Seeder
{
    protected $user;
    protected $wali_kelas;
    protected $tahun_ajar;
    protected $kelas;
    protected $guru;

    public function __construct()
    {
        // $this->user = new UserModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->kelas = new KelasModel();
        $this->guru = new GuruKepsekModel();
    }

    public function run()
    {
        $kelas = $this->kelas->getData();
        foreach ($kelas as $kel) {
            $tahun_ajar = $this->tahun_ajar->getData();
            foreach ($tahun_ajar as $tahun) {
                $data = [
                    'id_kelas' => $kel['id'],
                    'id_guru_wali' => $this->guru->where('level', 'guru')->orderBy('id', 'RANDOM')->findAll()[0]['id'],
                    'id_tahun_ajar' => $tahun['id'],
                ];

                $this->wali_kelas->updateOrInsert(['id_kelas' => $data['id_kelas'], 'id_guru_wali' => $data['id_guru_wali'], 'id_tahun_ajar' => $data['id_tahun_ajar']], $data);
            }
        }
    }
}
