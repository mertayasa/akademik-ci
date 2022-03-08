<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PrestasiModel;
use App\Models\TahunAjarModel;

class Prestasi extends BaseController
{
    protected $prestasi;
    protected $tahun_ajar;

    public function __construct()
    {
        $this->prestasi = new PrestasiModel();
        $this->tahun_ajar = new TahunAjarModel();
    }

    public function index()
    {
        $id_tahun_aktif = $this->tahun_ajar->getActiveId();
        $data_tahun = $this->tahun_ajar->getData($id_tahun_aktif);
        $tahun_aktif = $data_tahun['tahun_mulai'] . ' / ' . $data_tahun['tahun_selesai'];
        $prestasi = $this->prestasi->where('id_tahun_ajar', $id_tahun_aktif)->orderBy('created_at desc');

        $data = [
            'id_tahun_aktif' => $id_tahun_aktif,
            'tahun_aktif' => $tahun_aktif,
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
        $id_tahun_aktif = $this->tahun_ajar->getActiveId();
        $kategori = $this->prestasi::$kategori;
        $tingkat = $this->prestasi::$tingkat;

        $data = [
            'id_tahun_aktif' => $id_tahun_aktif,
            'kategori' => $kategori,
            'tingkat' => $tingkat,
        ];

        return view('prestasi/create', $data);
    }

    public function edit($id)
    {
        $id_tahun_aktif = $this->tahun_ajar->getActiveId();
        $prestasi = $this->prestasi->getData($id);
        $kategori = $this->prestasi::$kategori;
        $tingkat = $this->prestasi::$tingkat;

        $data = [
            'kategori' => $kategori,
            'tingkat' => $tingkat,
            'prestasi' => $prestasi,
            'id_tahun_aktif' => $id_tahun_aktif
        ];

        return view('prestasi/edit', $data);
    }

    public function insert()
    {
        try {
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
                'id_tahun_ajar' => $this->request->getPost('id_tahun_ajar')
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
        try {
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
        try {
            $this->prestasi->delete($id);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menghapus data prestasi');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil menghapus data prestasi');
        return redirect()->to(route_to('prestasi_index'));
    }
}
