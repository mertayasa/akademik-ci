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

    public function insert()
    {
        try{
            $base_64_foto = json_decode($this->request->getPost('thumbnail'), true);
            $upload_image = uploadFile($base_64_foto, 'prestasi');

            if ($upload_image === 0) {
                session()->setFlashdata('error', 'Gagal mengupload gambar');
                return redirect()->back()->withInput();
            }

            $new_data = [
                'nama' => $this->request->getPost('nama'),
                'konten' => $this->request->getPost('konten'),
                'tingkat' => $this->request->getPost('tingkat'),
                'kategori' => $this->request->getPost('kategori'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'thumbnail' => $upload_image,
            ];

            $this->prestasi->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menyimpan data prestasi');
            return redirect()->to(route_to('prestasi_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menyimpan data prestasi');
            return redirect()->back()->withInput();
        }
    }

    public function update($id)
    {
        try{
            $base_64_foto = json_decode($this->request->getPost('thumbnail'), true);
            $upload_image = uploadFile($base_64_foto, 'prestasi');

            if ($upload_image === 0) {
                session()->setFlashdata('error', 'Gagal mengupload gambar');
                return redirect()->back()->withInput();
            }

            $new_data = [
                'nama' => $this->request->getPost('nama'),
                'konten' => $this->request->getPost('konten'),
                'tingkat' => $this->request->getPost('tingkat'),
                'kategori' => $this->request->getPost('kategori'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'thumbnail' => $upload_image,
            ];

            $this->prestasi->updateData($id, $new_data);
            session()->setFlashdata('success', 'Berhasil mengubah data prestasi');
            return redirect()->to(route_to('prestasi_index'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data prestasi');
            return redirect()->back()->withInput();
        }
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
