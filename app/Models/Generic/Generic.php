<?php

namespace App\Models\Generic;

use CodeIgniter\Model;

class Generic extends Model
{
    function __construct()
    {
        parent::__construct();
        $db = db_connect();
        $db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }

    public function getData($id = null)
    {
        if(!$id){
            return $this->findAll();
        }

        return $this->find($id);
    }

    public function insertData($new_data)
    {
        return $this->insert($new_data);
    }

    public function updateData($id, $update_data)
    {
        return $this->update($id, $update_data);
    }

    public function updateOrInsert($check_array, $data)
    {
        $data_exists = $this->where($check_array[0], $check_array[1])->findAll();
        if($data_exists){
            return $this->update($data_exists[0]['id'], $data);
        }

        return $this->insert($data);

    }
}
