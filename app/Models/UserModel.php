<?php

namespace App\Models;

use App\Models\Generic\Generic;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserModel extends Generic
{
    // protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'email',
        'password',
        'level',
        'nip',
        'nis',
        'no_telp',
        'tempat_lahir',
        'tanggal_lahir',
        'status_guru',
        'level',
        'status',
        'pekerjaan',
        'alamat',
        'foto',
        'bio',
        'id_ortu'
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

    public function getFoto($id)
    {
        $user = $this->getData($id);
        if($user){
            if(file_exists($user['foto'])){
                return $user['foto'];
            }else{
                return 'default/avatar.png';
            }
        }
    }
}
