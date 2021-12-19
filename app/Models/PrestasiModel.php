<?php

namespace App\Models;

use App\Models\Generic\Generic;
use CodeIgniter\Model;

class PrestasiModel extends Generic
{
    // protected $DBGroup          = 'default';
    protected $table            = 'prestasi_akademik';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'kategori',
        'tingkat',
        'thumbnail',
        'deskripsi',
        'konten',
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = true;
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

    static $kategori = [
        'guru' => 'Guru',
        'siswa' => 'Siswa',
        'pegawai' => 'Pegawai',
    ];

    static $tingkat = [
        'kec' => 'Kecamatan',
        'kab' => 'Kabupaten',
        'prov' => 'Provinsi',
        'nas' => 'Nasional',
        'kota' => 'Kota',
        'inter' => 'Internasional',
        'antar_sekolah' => 'Antar Sekolah',
    ];
}
