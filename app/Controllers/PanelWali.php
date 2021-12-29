<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\TahunAjarModel;
use App\Models\UserModel;
use App\Models\WaliKelasModel;

class PanelWali extends BaseController
{

    protected $user;
    protected $wali_kelas;
    protected $anggota_kelas;
    protected $tahun_ajar;
    
    public function __construct()
    {
        $this->user = new UserModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
    }

    public function index()
    {
        $user = $this->user->getData(session()->get('id'));
        $id_tahun_ajar = $this->tahun_ajar->getActiveId();
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun_ajar);
        $kelas = $this->wali_kelas
        ->join('kelas', 'wali_kelas.id_kelas = kelas.id')
        ->join('users', 'wali_kelas.id_guru_wali = users.id')
        ->join('tahun_ajar', 'wali_kelas.id_tahun_ajar = tahun_ajar.id')
        ->where([
            'id_guru_wali' => $user['id'],
            'id_tahun_ajar' => $id_tahun_ajar
        ])->findAll();

        foreach ($kelas as $key => $each) {
            $kelas[$key]['jumlah_siswa'] = $this->assignStudentCount($each, $id_tahun_ajar);
        }

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'kelas' => $kelas,
        ];

        // dd($data);

        return view('panel_wali/index', $data);
    }

    private function assignStudentCount($array, $id_tahun)
    {
        return $this->anggota_kelas
                ->where(['id_kelas' => $array['id_kelas'], 'id_tahun_ajar' => $id_tahun])
                ->countAllResults() ?? null;
    }

}
