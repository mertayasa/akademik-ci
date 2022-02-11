<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\KelasPerTahunModel;
use App\Models\TahunAjarModel;

class KelasPerTahun extends BaseController
{
    protected $kelas;
    protected $tahun_ajar;
    protected $kelas_per_tahun;

    public function __construct()
    {
        $this->kelas = new KelasModel;
        $this->tahun_ajar = new TahunAjarModel;
        $this->kelas_per_tahun = new KelasPerTahunModel;
    }

    public function index()
    {
        $tahun_ajar_id = $this->tahun_ajar->getActiveId();
        $tahun_ajar = $this->tahun_ajar->find($tahun_ajar_id);
        $jenjang_kelas = $this->kelas->groupBy('jenjang')->findAll();
        $groupped_kelas = [];

        foreach($jenjang_kelas as $jenjang){
            $groupped_kelas[$jenjang['jenjang']] = $this->kelas->where('jenjang', $jenjang['jenjang'])->findAll();
        }

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'all_kelas' => $groupped_kelas,
        ];

        return view('kelas_per_tahun/index', $data);
    }

    public function update($id_kelas)
    {
        $id_tahun_ajar = $this->request->getPost('id_tahun_ajar');
        $check_kelas = $this->kelas_per_tahun->where([
            'id_kelas' => $id_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
        ])->findAll();
        
        try{
            if(!isset($check_kelas[0])){
                $this->kelas_per_tahun->insertData([
                    'id_tahun_ajar' => $id_tahun_ajar,
                    'id_kelas' => $id_kelas,
                ]);
            }else{
                $this->kelas_per_tahun->delete($check_kelas[0]['id']);
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return json_encode([
                'code' => 0,
                'message' => 'Gagal mengubah status kelas'
            ]);
        }

        return json_encode([
            'code' => 1,
            'message' => 'Berhasil mengubah status kelas'
        ]);
    }
}
