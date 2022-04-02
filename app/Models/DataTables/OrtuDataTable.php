<?php

namespace App\Models\DataTables;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class OrtuDataTable extends Model
{
    protected $table = 'ortu';
    protected $column_order = ['id', 'nama'];
    protected $column_search = ['nama', 'email', 'status'];
    protected $order = ['nama' => 'asd'];
    protected $request;
    protected $level;
    protected $db;
    protected $dt;
    protected $status;
    protected $data_filter;

    public function __construct(RequestInterface $request, $level, $status = null, $data_filter = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->status = $status;
        $this->level = $level ?? ['admin', 'siswa', 'ortu', 'guru', 'kepsek'];
        $this->data_filter = $data_filter ?? null;
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

        if (isset($this->data_filter['nis']) && $this->data_filter['nis'] != '') {
            $this->dt->select('ortu.*, siswa.id_ortu, siswa.nis');
            $this->dt->join('siswa', 'siswa.id_ortu = ortu.id');
            $this->dt->where('nis', $this->data_filter['nis']);
        }
        if ($this->status != null) {
            $this->dt->where('status', $this->status);
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        // $this->dt->where('status', 'aktif');
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
    public function getDatatablesHistory()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $this->dt->where('status', 'nonaktif');
        $query = $this->dt->get();
        return $query->getResult();
    }
}
