<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PrestasiModel;

class Prestasi extends BaseController
{
    protected $prestasi;

    public function __construct()
    {
        $this->prestasi = new PrestasiModel();    
    }

    public function index()
    {
        $prestasi = $this->prestasi->orderBy('created_at desc');

		$data = [
            'prestasi' => $prestasi->paginate(2),
            'pager' => $prestasi->pager
        ];

        return view('prestasi/index', $data);
    }

    public function detail($id)
    {
        $prestasi = $this->prestasi->getData($id);

        $data = [
            'prestasi' => $prestasi,
        ];

        dd($data);

        return view('prestasi/detail', $data);
    }
}
