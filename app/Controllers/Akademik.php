<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\KelasModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;
use Carbon\Carbon;

class Akademik extends BaseController
{
    protected $kelas;
    protected $anggota_kelas;
    protected $wali_kelas;
    protected $tahun_ajar;
    protected $db;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->db = db_connect();
    }

    public function index()
    {
        if(!$this->tahun_ajar->getData()){
            return route_to('dashboard_index');
        }

        $tahun_ajar_raw = $this->tahun_ajar->getData();
        $tahun_ajar = [];

        $param_tahun = $this->request->getPost('tahun_ajar');
        $selected_tahun = $param_tahun;

        if(!$param_tahun){
            $selected_tahun = $this->tahun_ajar->getActiveId();
        }

        
        $kelas = $this->getJenjang($selected_tahun);
        
        foreach($tahun_ajar_raw as $raw){
            $tahun_ajar[$raw['id']] = $raw['tahun_mulai'].'/'.$raw['tahun_selesai'];
        }

        // echo '<pre>';
        // print_r($kelas);
        // dd($kelas);

        $data = [
            'kelas' => $kelas,
            'tahun_ajar' => $tahun_ajar,
            'tahun_ajar_selected' => $selected_tahun,
        ];

        return view('akademik/index', $data);
    }

    private function getJenjang($id_tahun){
        $jenjang   = array();
        $data   = $this->kelas->getData();

        foreach( $data as $each ){
            $jenjang[$each['jenjang']]['kelas'] = $this->assignTeacherAndCountStudent($this->kelas->where('jenjang', $each['jenjang'])->findAll(), $id_tahun, $each['jenjang']); 
        }
        return $jenjang;
    }
    
    public function assignTeacherAndCountStudent($array, $id_tahun)
    {
        $new_class = [];
        foreach($array as $data){
            $data['nama_guru'] = $this->wali_kelas
                                    ->select('users.nama as nama_guru, wali_kelas.id_kelas, wali_kelas.id_tahun_ajar')
                                    ->join('users', 'wali_kelas.id_guru_wali = users.id')
                                    ->where(['id_kelas' => $data['id'], 'id_tahun_ajar' => $id_tahun])
                                    ->findAll()[0]['nama_guru'] ?? null;

            $data['jumlah_siswa'] = $this->anggota_kelas
                                    ->where(['id_kelas' => $data['id'], 'id_tahun_ajar' => $id_tahun])
                                    ->countAllResults() ?? null;

            array_push($new_class, $data);
        }

        return $new_class;
    }
}
