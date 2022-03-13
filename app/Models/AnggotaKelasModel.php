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
    
    public function search_anggota($id_siswa)
    {
        return $this->select($this->table . '.*,siswa.id, siswa.nama, siswa.nis')
            ->join('siswa', 'anggota_kelas.id_siswa=siswa.id')
            ->where($this->table . '.id_siswa', $id_siswa)
            ->orderBy('id_tahun_ajar', 'ASC')
            ->findAll();
    }

    public function getHistoryNilai($id)
    {
        $wali_kelas_model = new WaliKelasModel;
        $nilai_model = new NilaiModel;

        $anggota_kelas = $this->get_anggota_by_id($id);
        // dd($anggota_kelas);
        $new_nilai = [];
        foreach ($anggota_kelas as $anggota) {
            $wali_kelas = $wali_kelas_model->get_wali_kelas_by_id($anggota['id_kelas'], $anggota['id_tahun_ajar'])[0]->nama_guru ?? '-';
            $nilai = $nilai_model->get_nilai_by_anggota($anggota['id']) ?? [];

            array_push($new_nilai, [
                'kelas' => $anggota['jenjang'] . $anggota['kode'],
                'tahun_ajar' => $anggota['tahun_mulai'] . '/' . $anggota['tahun_selesai'],
                'wali_kelas' => $wali_kelas,
                'nilai' => $nilai
            ]);
        }

        return $new_nilai;
    }
}
