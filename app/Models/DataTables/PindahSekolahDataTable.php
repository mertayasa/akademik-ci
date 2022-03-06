<?php

namespace App\Models\DataTables;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class PindahSekolahDataTable extends Model
{
    protected $table = 'pindah_sekolah';
    protected $column_order = ['id', 'id_siswa', 'id_tahun_ajar', 'asal', 'tujuan', 'tanggal', 'alasan'];
    protected $column_search = ['id_siswa', 'id_tahun_ajar', 'asal', 'tujuan', 'tanggal', 'alasan'];
    protected $order = ['id' => 'DESC'];
    protected $request;
    protected $tipe;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request, $tipe)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->tipe = $tipe;
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

        if ($this->request->getPost('id_tahun') != null) {
            if ($this->request->getPost('order')) {
                $this->dt->where('tipe', $this->tipe)->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
                $this->dt->where('id_tahun_ajar', $this->request->getPost('id_tahun'));
            } else if (isset($this->order)) {
                $order = $this->order;
                $this->dt->where('tipe', $this->tipe)->orderBy(key($order), $order[key($order)]);
                $this->dt->where('id_tahun_ajar', $this->request->getPost('id_tahun'));
            }
        } else {
            if ($this->request->getPost('order')) {
                $this->dt->where('tipe', $this->tipe)->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
            } else if (isset($this->order)) {
                $order = $this->order;
                $this->dt->where('tipe', $this->tipe)->orderBy(key($order), $order[key($order)]);
            }
        }
    }

    public function getDatatables()
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
