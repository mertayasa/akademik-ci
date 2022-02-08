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
use App\Models\JadwalModel;
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
        $jadwalModel = new JadwalModel();
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];
        $anggota_kelas = $this->anggota_kelas->get_anggota_by_id((session()->get('id')), $id_tahun_ajar)[0] ?? [];
        $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        $nilai['genap'] = $this->nilai->get_nilai_by_semester($anggota_kelas['id'], 'genap') ?? [];
        $nilai['ganjil'] = $this->nilai->get_nilai_by_semester($anggota_kelas['id'], 'ganjil') ?? [];
        $mapel = $jadwalModel->get_mapel_jadwal($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar']);

        $data = [
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'nilai' => $nilai,
            'mapel'    => $mapel
        ];

        return view('nilai/siswa/index', $data);
    }

    public function indexOrtu()
    {
        $jadwalModel = new JadwalModel();
        $id_siswa = $_GET['id_siswa'] ?? null;
        $siswa = $this->siswa->where('id_ortu', session()->get('id'))->findAll();
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];

        if (isset($siswa[0]['id'])) {
            $anggota_kelas = $this->anggota_kelas->get_anggota_by_id($siswa[0]['id'], $id_tahun_ajar)[0] ?? [];
        } elseif ($id_siswa != null) {
            echo $id_siswa;
            $anggota_kelas = $this->anggota_kelas->get_anggota_by_id($id_siswa, $id_tahun_ajar)[0] ?? [];
        } else {
            $anggota_kelas = [];
        }

        if (isset($anggota_kelas) and $anggota_kelas != null) {
            $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        } else {
            $wali_kelas =  null;
        }

        if (isset($anggota_kelas) and $anggota_kelas != null) {
            $nilai['genap'] = $this->nilai->get_nilai_by_semester($anggota_kelas['id'], 'genap') ?? [];
            $nilai['ganjil'] = $this->nilai->get_nilai_by_semester($anggota_kelas['id'], 'ganjil') ?? [];
        } else {
            $nilai = [
                'ganjil' => null,
                'genap' => null
            ];
        }
        $mapel = $jadwalModel->get_mapel_jadwal($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar']);

        $data = [
            'id_siswa' => $id_siswa ?? ($anggota_kelas[0]['id'] ?? null),
            'siswa' => $siswa,
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'nilai' => $nilai,
            'mapel'    => $mapel
        ];

        return view('nilai/ortu/index', $data);
    }
    public function edit($id, $semester)
    {
        $jadwalModel = new JadwalModel();

        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];
        $anggota_kelas = $this->anggota_kelas->get_anggota_by_id($id, $id_tahun_ajar)[0] ?? [];
        $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        $nilai = $this->nilai->get_nilai_by_semester($anggota_kelas['id'], $semester) ?? [];
        $id_siswa = $this->request->uri->getSegment(2);
        $mapel = $jadwalModel->get_mapel_jadwal($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar']);

        $data = [
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'nilai' => $nilai,
            'semester' => $semester,
            'id_siswa' => $id_siswa,
            'mapel'    => $mapel
        ];
        // dd($mapel);
        return view('nilai/siswa/index', $data);
    }
    public function update()
    {
        $id = $this->request->getPost('id_nilai');
        $tugas = $this->request->getPost('tugas');
        $uts = $this->request->getPost('uts');
        $uas = $this->request->getPost('uas');
        $harian = $this->request->getPost('harian');
        $semester = $this->request->getPost('semester');
        $id_siswa = $this->request->getPost('id_siswa');
        $id_kelas = $this->request->getPost('id_kelas');
        $id_anggota = $this->request->getPost('id_anggota_kelas');
        $id_mapel = $this->request->getPost('id_mapel');

        $data = [
            'id_kelas' => $id_kelas,
            'id_mapel' => $id_mapel,
            'id_anggota_kelas' => $id_anggota,
            'tugas' => $tugas,
            'uts'   => $uts,
            'uas'   => $uas,
            'harian'   => $harian
        ];
        try {
            $this->nilai->updateOrInsert(['id' => $id], $data);
            session()->setFlashdata('success', 'Data nilai berhasil diupdate');
            return redirect()->to(route_to("nilai_edit_$semester", $id_siswa, $semester));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Update gagal');
            return redirect()->back()->withInput();
        }
    }
    public function create()
    {
        $id_kelas = $this->request->getPost('id_kelas');
        $id_mapel = $this->request->getPost('id_mapel');
        $id_anggota_kelas = $this->request->getPost('id_anggota_kelas');
        $tugas = $this->request->getPost('tugas');
        $uts = $this->request->getPost('uts');
        $uas = $this->request->getPost('uas');
        $harian = $this->request->getPost('harian');
        $semester = $this->request->getPost('semester');
        $data = [];

        foreach ($tugas as $key => $val) {
            array_push($data, [
                'id_kelas' => $id_kelas[$key],
                'id_mapel' => $id_mapel[$key],
                'id_anggota_kelas' => $id_anggota_kelas[$key],
                'tugas' => $val,
                'uts' => $uts[$key],
                'uas' => $uas[$key],
                'semester' => $semester,
                'harian' => $harian[$key]
            ]);
        }
        // dd($data);
        try {
            $this->nilai->dt->insertBatch($data);
            session()->setFlashdata('success', 'Berhasil melakuan input nilai');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('errot', 'Gagal melakuan input nilai');
        }
        return redirect()->back()->withInput();
    }
}
