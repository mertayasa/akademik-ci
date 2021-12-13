<?php

namespace App\Database\Seeds;

use App\Models\AnggotaKelasModel;
use App\Models\KelasModel;
use App\Models\TahunAjarModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class AnggotaKelasSeeder extends Seeder
{
    protected $user;
    protected $anggota_kelas;
    protected $tahun_ajar;
    protected $kelas;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->kelas = new KelasModel();
    }

    public function run()
    {
        $kelas = $this->kelas->getData();
        foreach($kelas as $kel){
            $tahun_ajar = $this->tahun_ajar->getData();
            foreach($tahun_ajar as $tahun){
                for($i=0; $i<=10; $i++){
                    $data = [
                        'id_kelas' => $kel['id'],
                        'id_siswa' => $this->user->where('level', 'siswa')->orderBy('id', 'RANDOM')->findAll()[0]['id'],
                        'id_tahun_ajar' => $tahun['id'],
                        'status' => 'aktif'
                    ];
        
                    $this->anggota_kelas->updateOrInsert(['id_kelas' => $data['id_kelas'], 'id_siswa' => $data['id_siswa'], 'id_tahun_ajar' => $data['id_tahun_ajar']], $data);
                }
            }
        }
    }
}
