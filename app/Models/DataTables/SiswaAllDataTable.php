<?php

namespace App\Models\DataTables;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SiswaAllDataTable extends Model
{
    protected $table = 'siswa';
    protected $column_order = ['id', '', 'nama', '', 'nis']; //string kosong biar sorting sesuai indeks data
    protected $column_search = ['s.nama', 's.nis'];
    protected $column_filter = [];
    protected $order = ['nama' => 'asd'];
    protected $request;
    protected $level;
    protected $db;
    protected $dt;
    protected $status;
    protected $data_filter;

    public function __construct(RequestInterface $request, $level, $data_filter = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        // $this->status = $status;
        $this->level = $level ?? ['admin', 'siswa', 'ortu', 'guru', 'kepsek'];
        array_push($this->column_filter, ['id_tahun_ajar', 'id_kelas', 'status']);
        $this->dt = $this->db->table($this->table);
        $this->data_filter = $data_filter ?? null;
    }

    // Datatables
    private function getDatatablesQuery()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if (isset($this->request->getPost('search')['value'])) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value'], 'after');
                    if (isset($this->data_filter['id_tahun_ajar'])) {
                        $this->dt->where('ak.id_tahun_ajar', $this->data_filter['id_tahun_ajar']);
                    }
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value'], 'after');
                    if (isset($this->data_filter['id_tahun_ajar'])) {
                        $this->dt->where('ak.id_tahun_ajar', $this->data_filter['id_tahun_ajar']);
                    }
                }

                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
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

        if (isOrtu()) {
            $this->dt->where('id_ortu', session()->get('id'));
        }
    }

    public function getDatatables()
    {
        $this->dt->select('s.*, ak.id, ak.id_siswa, ak.id_kelas, ak.id_tahun_ajar, concat(k.jenjang,"",k.kode) as kelas, concat(ta.tahun_mulai,"-",ta.tahun_selesai) as tahun_ajar');
        $this->dt->from($this->table . ' s');
        $this->dt->join('anggota_kelas ak', 'ak.id_siswa = s.id');
        $this->dt->join('kelas k', 'k.id = ak.id_kelas');
        $this->dt->join('tahun_ajar ta', 'ta.id = ak.id_tahun_ajar');
        $this->dt->groupBy(['ak.id_kelas', 'ak.id_siswa']);

        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        // $this->dt->where('siswa.status', 'aktif');
        if (isset($this->data_filter['id_tahun_ajar'])) {
            $this->dt->where('siswa.status', $this->data_filter['status']);
        }

        $query = $this->dt->get();
        return $query->getResult();
        // if (isset($this->data_filter['id_tahun_ajar'])) {
        //     return $this->data_filter['id_tahun_ajar'];
        // } else {
        //     return 'gak ada';
        // }
    }

    public function countFiltered()
    {
        $this->dt->select('s.*, ak.id_siswa, ak.id_kelas, ak.id_tahun_ajar, concat(k.jenjang,"",k.kode) as kelas, concat(ta.tahun_mulai,"-",ta.tahun_selesai) as tahun_ajar');
        $this->dt->from($this->table . ' s');
        $this->dt->join('anggota_kelas ak', 'ak.id_siswa = s.id', 'left');
        $this->dt->join('kelas k', 'k.id = ak.id_kelas');
        $this->dt->join('tahun_ajar ta', 'ta.id = ak.id_tahun_ajar');
        $this->dt->groupBy(['ak.id_kelas', 'ak.id_siswa']);
        $this->getDatatablesQuery();
        if (isset($this->data_filter['id_tahun_ajar'])) {
            $this->dt->where('ak.id_tahun_ajar', $this->data_filter['id_tahun_ajar']);
        }
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
