<?php

namespace App\Models\DataTables;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SiswaAllDataTable extends Model
{
    protected $table = 'siswa';
    protected $column_order = ['id', '', 'nama', '', 'nis']; //string kosong biar sorting sesuai indeks data
    protected $column_search = ['as.nama', 'as.nis'];
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
        $this->level = $level ?? ['admin', 'siswa', 'ortu', 'guru', 'kepsek'];
        array_push($this->column_filter, ['id_tahun_ajar', 'id_kelas', 'status']);
        $this->dt = $this->db->table($this->table);
        $this->data_filter = $data_filter ?? [];
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
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value'], 'after');
                }

                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if(isset($this->data_filter['id_tahun_ajar']) && $this->data_filter['id_tahun_ajar'] != ''){
            $this->dt->where('ta.id', $this->data_filter['id_tahun_ajar']);
        }
        
        if(isset($this->data_filter['id_kelas']) && $this->data_filter['id_kelas'] != ''){
            $this->dt->where('k.id', $this->data_filter['id_kelas']);
        }
            
        if(isset($this->data_filter['status']) && $this->data_filter['status'] != ''){
            $this->dt->where('as.status', $this->data_filter['status']);
        }

        if ($this->status != null) {
            $this->dt->where('status', $this->status);
        }

        // $this->dt->where('as.nama', 'Jatmiko Tarihoran');

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
        $this->dt->select('as.*, ak.id, ak.id_siswa, ak.id_kelas, ak.id_tahun_ajar, concat(k.jenjang,"",k.kode) as kelas, concat(ta.tahun_mulai,"-",ta.tahun_selesai) as tahun_ajar');
        $this->dt->from($this->table . ' as');
        $this->dt->join('anggota_kelas ak', 'ak.id_siswa = as.id');
        $this->dt->join('kelas k', 'k.id = ak.id_kelas');
        $this->dt->join('tahun_ajar ta', 'ta.id = ak.id_tahun_ajar');
        $this->dt->groupBy(['ak.id_kelas', 'ak.id_siswa']);

        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
            

        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->dt->select('as.*, ak.id_siswa, ak.id_kelas, ak.id_tahun_ajar, concat(k.jenjang,"",k.kode) as kelas, concat(ta.tahun_mulai,"-",ta.tahun_selesai) as tahun_ajar');
        $this->dt->from($this->table . ' as');
        $this->dt->join('anggota_kelas ak', 'ak.id_siswa = as.id', 'left');
        $this->dt->join('kelas k', 'k.id = ak.id_kelas');
        $this->dt->join('tahun_ajar ta', 'ta.id = ak.id_tahun_ajar');
        $this->dt->groupBy(['ak.id_kelas', 'ak.id_siswa']);
        $this->getDatatablesQuery();

        // if (isset($this->data_filter['id_tahun_ajar'])) {
        //     $this->dt->where('ak.id_tahun_ajar', $this->data_filter['id_tahun_ajar']);
        // }
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
