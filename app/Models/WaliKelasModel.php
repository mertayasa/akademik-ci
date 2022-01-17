<?php

namespace App\Models;

use App\Models\Generic\Generic;
use CodeIgniter\Model;

class WaliKelasModel extends Generic
{
    // protected $DBGroup          = 'default';
    protected $table            = 'wali_kelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kelas',
        'id_guru_wali',
        'id_tahun_ajar'
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

    protected $db;
    protected $dt;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        $this->dt = $this->db->table($this->table);
    }
    public function get_wali_kelas_by_id($id_kelas, $id_tahun_ajar)
    {
        $this->dt->select($this->table . '.*, guru_kepsek.nama as nama_guru, guru_kepsek.nip');
        $this->dt->join('guru_kepsek', $this->table . '.id_guru_wali=guru_kepsek.id');
        $this->dt->where('id_kelas', $id_kelas);
        $this->dt->where('id_tahun_ajar', $id_tahun_ajar);
        return $this->dt->get()->getResultObject();
    }
}
