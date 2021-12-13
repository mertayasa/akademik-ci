<?php

namespace App\Database\Seeds;

use App\Models\KelasModel;
use App\Models\TahunAjarModel;
use App\Models\UserModel;
use App\Models\WaliKelasModel;
use CodeIgniter\Database\Seeder;

class WaliKelasSeeder extends Seeder
{
    protected $user;
    protected $wali_kelas;
    protected $tahun_ajar;
    protected $kelas;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->kelas = new KelasModel();
    }

    public function run()
    {
        $kelas = $this->kelas->getData();
        foreach($kelas as $kel){
            $tahun_ajar = $this->tahun_ajar->orderBy('id', 'RANDOM')->findAll()[0];
            for($i=0; $i<=10; $i++){
                $data = [
                    'id_kelas' => $kel['id'],
                    'id_guru_wali' => $this->user->where('level', 'guru')->orderBy('id', 'RANDOM')->findAll()[0]['id'],
                    'id_tahun_ajar' => $tahun_ajar['id'],
                ];

                $this->wali_kelas->updateOrInsert(['id_kelas' => $data['id_kelas'], 'id_guru_wali' => $data['id_guru_wali'], 'id_tahun_ajar' => $data['id_tahun_ajar']], $data);
            }
        }
    }
}
