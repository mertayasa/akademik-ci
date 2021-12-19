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
            'prestasi' => $prestasi->paginate(10),
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

        return view('prestasi/detail', $data);
    }

    public function create()
    {
        $kategori = $this->prestasi::$kategori;
        $tingkat = $this->prestasi::$tingkat;

        $data = [
            'kategori' => $kategori,
            'tingkat' => $tingkat,
        ];

        return view('prestasi/create', $data);
    }

    public function edit($id)
    {
        $prestasi = $this->prestasi->getData($id);
        $kategori = $this->prestasi::$kategori;
        $tingkat = $this->prestasi::$tingkat;

        $data = [
            'kategori' => $kategori,
            'tingkat' => $tingkat,
            'prestasi' => $prestasi
        ];  

        return view('prestasi/edit', $data);
    }


    public function destroy($id)
    {
        try{
            $this->prestasi->delete($id);
        }catch(\Exception $e){
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menghapus data prestasi');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil menghapus data prestasi');
        return redirect()->to(route_to('prestasi_index'));
    }
}
