<?php

namespace App\Models;

use App\Models\Generic\Generic;
use CodeIgniter\Model;

class NilaiModel extends Generic
{
    // protected $DBGroup          = 'default';
    protected $table            = 'nilai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kelas',
        'id_mapel',
        'id_anggota_kelas',
        'tugas',
        'uts',
        'uas',
        'harian'
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
    }
    public function get_nilai_by_anggota($id_anggota_kelas)
    {
        return $this->select(
            'mapel.nama as nama_mapel, tugas, uts, uas,harian, nilai.id as id_nilai, nilai.id_kelas as id_kelas, nilai.id_anggota_kelas as id_anggota'
        )->join('kelas', 'nilai.id_kelas = kelas.id')
            ->join('mapel', 'nilai.id_mapel = mapel.id')
            ->join('anggota_kelas', 'nilai.id_anggota_kelas = anggota_kelas.id')
            ->where([
                'nilai.id_anggota_kelas' => $id_anggota_kelas,
            ])
            ->groupBy('id_mapel')
            ->findAll();
    }
    public function get_nilai_by_semester($id_anggota_kelas, $semester)
    {
        return $this->select(
            'mapel.nama as nama_mapel, tugas, uts, uas, harian, nilai.id as id_nilai, nilai.id_kelas as id_kelas, nilai.id_anggota_kelas as id_anggota'
        )->join('kelas', 'nilai.id_kelas = kelas.id')
            ->join('mapel', 'nilai.id_mapel = mapel.id')
            ->join('anggota_kelas', 'nilai.id_anggota_kelas = anggota_kelas.id')
            ->where([
                'nilai.id_anggota_kelas' => $id_anggota_kelas,
                'nilai.semester' => $semester
            ])
            ->findAll();
    }
}
