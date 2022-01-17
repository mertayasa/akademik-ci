<?php

namespace App\Database\Seeds;

use App\Models\AnggotaKelasModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;
use CodeIgniter\Database\Seeder;

class AnggotaKelasSeeder extends Seeder
{
    protected $user;
    protected $anggota_kelas;
    protected $tahun_ajar;
    protected $kelas;
    protected $siswa;

    public function __construct()
    {
        // $this->user = new UserModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->kelas = new KelasModel();
        $this->siswa = new SiswaModel();
    }

    public function run()
    {
        // $kelas = $this->kelas->getData();
        // foreach($kelas as $kel){
        //     $tahun_ajar = $this->tahun_ajar->getData();
        //     foreach($tahun_ajar as $tahun){
        //         for($i=0; $i<=10; $i++){
        //             $data = [
        //                 'id_kelas' => $kel['id'],
        //                 'id_siswa' => $this->user->where('level', 'siswa')->orderBy('id', 'RANDOM')->findAll()[0]['id'],
        //                 'id_tahun_ajar' => $tahun['id'],
        //                 'status' => 'aktif'
        //             ];

        //             $this->anggota_kelas->updateOrInsert(['id_kelas' => $data['id_kelas'], 'id_siswa' => $data['id_siswa'], 'id_tahun_ajar' => $data['id_tahun_ajar']], $data);
        //         }
        //     }
        // }

        // $users = $this->user->where('level', 'siswa')->findAll();
        // $tahun_ajar = $this->tahun_ajar->getData();
        // foreach($tahun_ajar as $th => $tahun){
        //     foreach($users as $key => $user){
        //         $kelas = $this->kelas->where('jenjang', $th+1)->orderBy('id', 'RANDOM')->findAll()[0]['id'] ?? '';
        //         if($kelas){
        //             $data = [
        //                 'id_kelas' => $kelas,
        //                 'id_siswa' => $user['id'],
        //                 'id_tahun_ajar' => $tahun['id'],
        //                 'status' => 'aktif'
        //             ];

        //             $this->anggota_kelas->updateOrInsert(['id_kelas' => $data['id_kelas'], 'id_siswa' => $data['id_siswa'], 'id_tahun_ajar' => $data['id_tahun_ajar']], $data);
        //         }
        //     }
        // }
        // $users = $this->user->where('level', 'siswa')->findAll();
        $siswas = $this->siswa->findAll();
        $tahun_ajar = $this->tahun_ajar->getData();
        foreach ($tahun_ajar as $th => $tahun) {
            foreach ($siswas as $key => $user) {
                if ($th + 1 <= 6) {
                    $kelas = $this->kelas->where('jenjang', $th + 1)->orderBy('id', 'RANDOM')->findAll()[0] ?? '';
                    $data = [
                        'id_kelas' => $kelas['id'],
                        'jenjang' => $kelas['jenjang'],
                        'id_siswa' => $user['id'],
                        'id_tahun_ajar' => $tahun['id'],
                        'status' => 'aktif'
                    ];

                    $this->anggota_kelas->insert($data);
                }
            }
        }
    }
}
