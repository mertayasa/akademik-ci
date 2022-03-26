<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;
use App\Models\UserModel;
use App\Models\WaliKelasModel;

class HistoryNilai extends BaseController
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

    public function indexOrtu()
    {
        $id_siswa = $_GET['id_siswa'] ?? null;
        $siswa = $this->siswa->where('id_ortu', session()->get('id'))->findAll();

        $anggota_kelas = $this->anggota_kelas->get_anggota_by_id(($id_siswa ?? $siswa[0]['id']));
        $new_nilai = [];
        foreach ($anggota_kelas as $anggota) {
            $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota['id_kelas'], $anggota['id_tahun_ajar'])[0]->nama_guru ?? '-';
            $nilai = $this->nilai->get_nilai_by_anggota($anggota['id']) ?? [];

            array_push($new_nilai, [
                // 'kelas' => convertRoman($anggota['jenjang']) . $anggota['kode'],
                'kelas' => $anggota['jenjang'] . $anggota['kode'],
                'tahun_ajar' => $anggota['tahun_mulai'] . '/' . $anggota['tahun_selesai'],
                'wali_kelas' => $wali_kelas,
                'nilai' => $nilai
            ]);
        }

        $data = [
            'id_siswa' => $id_siswa ?? ($anggota_kelas[0]['id'] ?? null),
            'siswa' => $siswa,
            'history_nilai' => $new_nilai,
        ];

        // dd($data);

        return view('history/ortu/index', $data);
    }

    public function indexGuru()
    {
        # code...
    }

    public function indexSiswa()
    {
        // $anggota_kelas = $this->anggota_kelas->get_anggota_by_id((session()->get('id')));
        // $new_nilai = [];
        // foreach ($anggota_kelas as $anggota) {
        //     $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota['id_kelas'], $anggota['id_tahun_ajar'])[0]->nama_guru ?? '-';
        //     $nilai = $this->nilai->get_nilai_by_anggota($anggota['id']) ?? [];

        //     array_push($new_nilai, [
        //         'kelas' => $anggota['jenjang'] . $anggota['kode'],
        //         'tahun_ajar' => $anggota['tahun_mulai'] . '/' . $anggota['tahun_selesai'],
        //         'wali_kelas' => $wali_kelas,
        //         'nilai' => $nilai
        //     ]);
        // }
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];

        $data = [
            // 'history_nilai' => $new_nilai,
            'anggota_kelas' => $this->anggota_kelas->get_anggota_by_id((session()->get('id')), $id_tahun_ajar)[0],
            'history_nilai' => $this->anggota_kelas->getHistoryNilai(session()->get('id')),
        ];

        // dd($data);

        return view('history/siswa/index', $data);
    }

    public function indexHistory($id)
    {
        // dd($id);
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'];
        
        $data = [
            'anggota_kelas' => $this->anggota_kelas->get_anggota_by_id($id, $id_tahun_ajar)[0],
            'history_nilai' => $this->anggota_kelas->getHistoryNilai($id),
        ];

        return view('history/siswa/index', $data);
    }
}
