<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\KelasModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;

class Akademik extends BaseController
{
    protected $kelas;
    protected $anggota_kelas;
    protected $wali_kelas;
    protected $tahun_ajar;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
    }

    public function index()
    {
        $kelas = $this->getJenjang();
        $tahun_ajar_raw = $this->tahun_ajar->getData();
        $tahun_ajar = [];

        $asd = $this->request->getPost('tahun_ajar');

        foreach($tahun_ajar_raw as $raw){
            $tahun_ajar[$raw['id']] = $raw['tahun_mulai'].'/'.$raw['tahun_selesai'];
        }

        $data = [
            'kelas' => $kelas,
            'tahun_ajar' => $tahun_ajar,
            'tahun_ajar_selected' => 1,
        ];

        return view('akademik/index', $data);
    }

    private function getJenjang(){
        $jenjang   = array();
        $data   = $this->kelas->getData();

        foreach( $data as $key => $each ){
            $jenjang[$each['jenjang']]['kelas'] = $this->kelas->where('jenjang', $each['jenjang'])->findAll();
        }
        return $jenjang;
    }
}
