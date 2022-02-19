<?php

namespace App\Models\DataTables;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SiswaDataTable extends Model
{
    protected $table = 'anggota_kelas';
    protected $column_order = ['id', 'id_kelas', 'id_siswa', 'id_tahun_ajar', 'status'];
    protected $column_search = ['kode', 'jenjang'];
    // protected $order = ['nama' => 'ASC'];
    protected $request;
    protected $kelas;
    protected $tahun_ajar;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request, $tahun_ajar, $kelas)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->kelas = $kelas ?? $kelas;
        $this->tahun_ajar = $tahun_ajar ?? $tahun_ajar;
        $this->dt = $this->db->table($this->table);
    }

    // Datatables
    private function getDatatablesQuery()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->where('id_kelas', $this->kelas);
            $this->dt->where('id_tahun_ajar', $this->tahun_ajar);
            $this->dt->join('siswa', 'siswa.id=' . $this->table . '.id_siswa');
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->where('id_kelas', $this->kelas);
            $this->dt->where('id_tahun_ajar', $this->tahun_ajar);
            $this->dt->join('siswa', 'siswa.id=' . $this->table . '.id_siswa');
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables($kelas, $tahun_ajar)
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}
