<?php

namespace App\Models;

use App\Models\Generic\Generic;
use Carbon\Carbon;
use CodeIgniter\Model;

class TahunAjarModel extends Generic
{
    // protected $DBGroup          = 'default';
    protected $table            = 'tahun_ajar';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tahun_mulai',
        'tahun_selesai',
        'status',
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

    public function getActiveId()
    {
        $active_tahun_ajar = $this->where('status', 'aktif')->findAll();
        if(!$active_tahun_ajar){
            $set_active = $this->where('tahun_mulai', Carbon::now()->year)->findAll();
            $this->updateData($set_active[0]['id'], ['status' => 'aktif']);
            return $set_active[0]['id'];
        }

        return $active_tahun_ajar[0]['id'];
    }
}
