<?php

namespace App\Models;

use App\Models\Generic\Generic;
use CodeIgniter\Model;

class AnggotaKelasModel extends Generic
{
    // protected $DBGroup          = 'default';
    protected $table            = 'anggota_kelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kelas',
        'id_siswa',
        'id_tahun_ajar',
        'status'
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

    public function get_anggota_by_id($id_siswa, $id_tahun_ajar = null)
    {
        if (isset($id_tahun_ajar)) {
            $filter = [
                'id_siswa' => $id_siswa,
                'id_tahun_ajar' => $id_tahun_ajar,
            ];
        } else {
            $filter = [
                'id_siswa' => $id_siswa,
            ];
        }

        return $this->select($this->table . '.*, tahun_ajar.tahun_mulai as tahun_mulai, tahun_ajar.tahun_selesai as tahun_selesai, kelas.kode as kode, kelas.jenjang as jenjang, siswa.nama as nama_anggota_kelas')
            ->join('kelas', 'anggota_kelas.id_kelas = kelas.id')
            ->join('tahun_ajar', 'anggota_kelas.id_tahun_ajar = tahun_ajar.id')
            ->join('siswa', 'anggota_kelas.id_siswa = siswa.id')
            ->where($filter)
            ->orderBy('anggota_kelas.id', 'DESC')
            ->findAll();
    }
}
