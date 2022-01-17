<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;
use Exception;

use function PHPUnit\Framework\returnSelf;

class Nilai extends BaseController
{
    protected $kelas;
    protected $tahun_ajar;
    protected $user;
    protected $siswa;
    protected $anggota_kelas;
    protected $mapel;
    protected $wali_kelas;
    protected $nilai;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        // $this->user = new UserModel();
        $this->siswa = new SiswaModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->mapel = new MapelModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->nilai = new NilaiModel();
    }

    public function index()
    {
        $level = session()->get('level');
        if ($level == 'siswa') {
            return $this->indexSiswa();
        }

        if ($level == 'ortu') {
            return $this->indexOrtu();
        }

        if ($level == 'guru') {
            return $this->indexGuru();
        }
    }

    private function indexGuru()
    {
    }

    private function indexSiswa()
    {
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];
        $anggota_kelas = $this->anggota_kelas->get_anggota_by_id((session()->get('id')), $id_tahun_ajar)[0] ?? [];
        $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        $nilai = $this->nilai->get_nilai_by_anggota($anggota_kelas['id']) ?? [];

        $data = [
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'nilai' => $nilai,
        ];

        return view('nilai/siswa/index', $data);
    }

    private function indexOrtu()
    {
        $id_siswa = $_GET['id_siswa'] ?? null;
        $siswa = $this->siswa->where('id_ortu', session()->get('id'))->findAll();
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];

        if (isset($siswa[0]['id'])) {
            $anggota_kelas = $this->anggota_kelas->get_anggota_by_id($id_siswa ?? $siswa[0]['id'], $id_tahun_ajar)[0] ?? [];
        } else {
            $anggota_kelas = [];
        }

        if (isset($anggota_kelas)) {
            $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        } else {
            $wali_kelas = [];
        }

        if (isset($anggota_kelas)) {
            $nilai = $this->nilai->get_nilai_by_anggota($anggota_kelas['id']) ?? [];
        } else {
            $nilai = [];
        }

        $data = [
            'id_siswa' => $id_siswa ?? ($anggota_kelas[0]['id'] ?? null),
            'siswa' => $siswa,
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'nilai' => $nilai,
        ];

        return view('nilai/ortu/index', $data);
    }
    public function edit($id)
    {
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];
        $anggota_kelas = $this->anggota_kelas->get_anggota_by_id($id, $id_tahun_ajar)[0] ?? [];
        $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        $nilai = $this->nilai->get_nilai_by_anggota($anggota_kelas['id']) ?? [];
        $id_siswa = $this->request->uri->getSegment(2);
        $data = [
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'nilai' => $nilai,
            'id_siswa' => $id_siswa
        ];

        return view('nilai/siswa/index', $data);
    }
    public function update()
    {
        $id = $this->request->getPost('id_nilai');
        $tugas = $this->request->getPost('tugas');
        $uts = $this->request->getPost('uts');
        $uas = $this->request->getPost('uas');
        $id_siswa = $this->request->getPost('id_siswa');

        $data = [
            'tugas' => $tugas,
            'uts'   => $uts,
            'uas'   => $uas
        ];
        try {
            $this->nilai->updateData($id, $data);
            session()->setFlashdata('success', 'Data nilai berhasil diupdate');
            return redirect()->to(route_to('nilai_edit', $id_siswa));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Update gagal');
            return redirect()->back()->withInput();
        }
    }
}
