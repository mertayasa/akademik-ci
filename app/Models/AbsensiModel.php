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
}
