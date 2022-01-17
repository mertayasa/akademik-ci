<?php

namespace App\Models;

use App\Models\Generic\Generic;
use CodeIgniter\Model;

class JadwalModel extends Generic
{
    // protected $DBGroup          = 'default';
    protected $table            = 'jadwal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kelas',
        'id_guru',
        'id_mapel',
        'jam_mulai',
        'jam_selesai',
        'hari',
        'kode_hari',
        'status',
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

    public function get_jadwal_by_id($id_kelas, $id_tahun_ajar)
    {
        $this->dt->select($this->table . '.*, kelas.jenjang as jengjang_kelas, kelas.kode as kode_kelas, mapel.nama as nama_mapel, guru_kepsek.nama as nama_guru, guru_kepsek.level');
        $this->dt->join('kelas', 'kelas.id=jadwal.id_kelas');
        $this->dt->join('mapel', 'mapel.id=jadwal.id_mapel');
        $this->dt->join('guru_kepsek', 'guru_kepsek.id=jadwal.id_guru');
        $this->dt->where('id_kelas', $id_kelas);
        $this->dt->where('id_tahun_ajar', $id_tahun_ajar);
        $this->dt->where($this->table . '.status', 'aktif');
        $this->dt->orderBy('hari', 'desc');
        $query = $this->dt->get()->getResultObject();
        return $query;
    }

    public function get_hari($id_kelas, $id_tahun_ajar)
    {
        $this->dt->select('hari');
        $this->dt->where('id_kelas', $id_kelas);
        $this->dt->where('id_tahun_ajar', $id_tahun_ajar);
        $this->dt->groupBy('hari');
        $this->dt->orderBy('kode_hari', 'ASC');
        $query = $this->dt->get()->getResultObject();
        return $query;
    }

    public function get_jadwal_guru($id_guru, $id_tahun_ajar)
    {
        $this->dt->select($this->table . '.*, kelas.jenjang as jenjang_kelas, kelas.kode as kode_kelas, mapel.nama as nama_mapel, guru_kepsek.nama as nama_guru, guru_kepsek.level');
        $this->dt->join('kelas', 'kelas.id=jadwal.id_kelas');
        $this->dt->join('mapel', 'mapel.id=jadwal.id_mapel');
        $this->dt->join('guru_kepsek', 'guru_kepsek.id=jadwal.id_guru');
        $this->dt->where('id_guru', $id_guru);
        $this->dt->where('id_tahun_ajar', $id_tahun_ajar);
        $this->dt->where($this->table . '.status', 'aktif');
        $this->dt->orderBy('hari', 'desc');
        $query = $this->dt->get()->getResultObject();
        return $query;
    }
    public function get_hari_jadwal_guru($id_guru, $id_tahun_ajar)
    {
        $this->dt->select('hari');
        $this->dt->where('id_guru', $id_guru);
        $this->dt->where('id_tahun_ajar', $id_tahun_ajar);
        $this->dt->groupBy('hari');
        $this->dt->orderBy('kode_hari', 'ASC');
        $query = $this->dt->get()->getResultObject();
        return $query;
    }
}
