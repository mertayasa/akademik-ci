<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Generic\Generic;

class AbsensiModel extends Generic
{
    // protected $DBGroup          = 'default';
    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_anggota_kelas',
        'id_kelas',
        'tanggal',
        'kehadiran',
        'semester',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        $this->dt = $this->db->table($this->table);
        $this->kelas = new KelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->anggota_kelas = new AnggotaKelasModel();
    }

    public function queryAbsensi($id_kelas, $id_tahun_ajar, $semester = null)
    {
        $query = $this->select('absensi.tanggal')
            ->distinct('absensi.tanggal')
            ->join('anggota_kelas', 'absensi.id_anggota_kelas = anggota_kelas.id')
            ->where([
                'absensi.id_kelas' => $id_kelas,
                'id_tahun_ajar' => $id_tahun_ajar
            ]);
        if($semester != null){
            return $query->where('absensi.semester', $semester);
        }

        return $query;
    }

    public function getAbsensiByKelas($id_kelas, $id_tahun_ajar, $id_anggota_kelas = null)
    {
        $kelas = $this->kelas->find($id_kelas);
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun_ajar);
        $where_absen = [
            'id_kelas' => $id_kelas,
            'id_tahun_ajar' => $id_tahun_ajar
        ];

        if($id_anggota_kelas != null){
            $where_absen += ['anggota_kelas.id' => $id_anggota_kelas];
        }

        $absen = $this->anggota_kelas
                ->select(
                    'anggota_kelas.id as anggota_kelas_id,
                    anggota_kelas.id_kelas as kelas_id,
                    anggota_kelas.id_tahun_ajar as tahun_ajar_id,
                    anggota_kelas.id_siswa as siswa_id, 
                    anggota_kelas.status as status,
                    siswa.nama as siswa_nama, 
                    siswa.nis as siswa_nis,')
                ->join('siswa', 'anggota_kelas.id_siswa=siswa.id')
                ->where($where_absen)->findAll();

        if($id_anggota_kelas != null){
            $count_absen = $this->queryAbsensi($id_kelas, $id_tahun_ajar)->where('absensi.id_anggota_kelas', $id_anggota_kelas)->countAllResults();
            $absen_ganjil = $this->queryAbsensi($id_kelas, $id_tahun_ajar, 'ganjil')->where('absensi.id_anggota_kelas', $id_anggota_kelas)->orderBy('absensi.tanggal', 'ASC')->findAll();
            $absen_genap = $this->queryAbsensi($id_kelas, $id_tahun_ajar, 'genap')->where('absensi.id_anggota_kelas', $id_anggota_kelas)->orderBy('absensi.tanggal', 'ASC')->findAll();
        }else{
            $count_absen = $this->queryAbsensi($id_kelas, $id_tahun_ajar)->countAllResults();
            $absen_ganjil = $this->queryAbsensi($id_kelas, $id_tahun_ajar, 'ganjil')->orderBy('absensi.tanggal', 'ASC')->findAll();
            $absen_genap = $this->queryAbsensi($id_kelas, $id_tahun_ajar, 'genap')->orderBy('absensi.tanggal', 'ASC')->findAll();
        }

        $group_bulan_ganjil = [];
        $group_bulan_genap = [];

        if(count($absen_ganjil) > 0){
            $period_ganjil = \Carbon\CarbonPeriod::create($absen_ganjil[0]['tanggal'], end($absen_ganjil)['tanggal']);
            foreach ($period_ganjil as $dt) {
                $group_bulan_ganjil[$dt->format("Y-m")]['month_name'] = getIndonesianMonth($dt->format("Y-m"));
                
                if($id_anggota_kelas != null){
                    $query_absensi = $this->queryAbsensi($id_kelas, $id_tahun_ajar, 'ganjil')->where('month(tanggal)', $dt->format("m"))->where('absensi.id_anggota_kelas', $id_anggota_kelas)->countAllResults();
                }else{
                    $query_absensi = $this->queryAbsensi($id_kelas, $id_tahun_ajar, 'ganjil')->where('month(tanggal)', $dt->format("m"))->countAllResults();
                }

                $group_bulan_ganjil[$dt->format("Y-m")]['count_absen'] = $query_absensi;
            }
        }

        if(count($absen_genap) > 0){
            $period_genap = \Carbon\CarbonPeriod::create($absen_genap[0]['tanggal'], end($absen_genap)['tanggal']);
            foreach ($period_genap as $dt) {
                $group_bulan_genap[$dt->format("Y-m")]['month_name'] = getIndonesianMonth($dt->format("Y-m"));
                
                if($id_anggota_kelas != null){
                    $query_absensi = $this->queryAbsensi($id_kelas, $id_tahun_ajar, 'genap')->where('month(tanggal)', $dt->format("m"))->where('absensi.id_anggota_kelas', $id_anggota_kelas)->countAllResults();
                }else{
                    $query_absensi = $this->queryAbsensi($id_kelas, $id_tahun_ajar, 'genap')->where('month(tanggal)', $dt->format("m"))->countAllResults();
                }

                $group_bulan_genap[$dt->format("Y-m")]['count_absen'] = $query_absensi;
            }
        }

        $data = [
            'group_bulan_ganjil' => $group_bulan_ganjil,
            'group_bulan_genap' => $group_bulan_genap,
            'absen' => $absen,
            'count_absen' => $count_absen,
            'absen_ganjil' => $absen_ganjil,
            'absen_genap' => $absen_genap,
            'breadcrumb'   => 'Absensi',
            'kelas_raw' => $kelas,
            'tahun_ajar' => $tahun_ajar,
            'kelas' => $kelas['jenjang'] . '' . $kelas['kode']
        ];

        return $data;
    }
}
