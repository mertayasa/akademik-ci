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

        dd($kelas);

        $data = [
            'kelas' => $kelas,
            'tahun_ajar' => $tahun_ajar,
            'tahun_ajar_selected' => $selected_tahun,
        ];

        return view('akademik/index', $data);
    }

    private function getJenjang($id_tahun){
        // dd($id_tahun);
        $jenjang   = array();
        $data   = $this->kelas->getData();

        foreach( $data as $key => $each ){
            $query = $this->kelas->query("SELECT
                kelas.id,
                kelas.jenjang,
                kelas.kode,
                wali_kelas.id_tahun_ajar,
                users.nama as nama_guru,
                COUNT(anggota_kelas.id) AS jumlah_siswa
            FROM kelas
                LEFT JOIN anggota_kelas ON anggota_kelas.id_kelas = kelas.id
                LEFT JOIN wali_kelas ON wali_kelas.id_kelas = kelas.id
                LEFT JOIN users ON wali_kelas.id_guru_wali = users.id
                WHERE kelas.jenjang = ".$each['jenjang']." OR wali_kelas.id_tahun_ajar = ".$id_tahun."
                GROUP BY kelas.id"
            );

            $jenjang[$each['jenjang']]['kelas'] = $this->removeDuplicateClass($each['jenjang'], $query->getResultArray()); 
        }
        return $jenjang;
    }

    private function removeDuplicateClass($jenjang, $array)
    {
        $new_class = [];
        foreach($array as $key => $data){
            if($data['jenjang'] == $jenjang){
                array_push($new_class, $data);
            }
        }

        return $new_class;
    }
}
