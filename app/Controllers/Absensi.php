<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\AnggotaKelasModel;
use App\Models\GuruKepsekModel;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;

class Absensi extends BaseController
{
    protected $kelas;
    protected $tahun_ajar;
    protected $jadwal;
    protected $user;
    protected $guru;
    protected $absensi;
    protected $anggota_kelas;
    protected $mapel;
    protected $wali_kelas;

    public function __construct()
    {
        $this->kelas = new KelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->jadwal = new JadwalModel();
        $this->guru = new GuruKepsekModel();
        $this->siswa = new SiswaModel();
        $this->absensi = new AbsensiModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->mapel = new MapelModel();
        $this->wali_kelas = new WaliKelasModel();
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
    }

    public function indexSiswa()
    {
        $siswa = $this->siswa->where('id', session()->get('id'))->findAll();
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'] ?? null;

        if (isset($siswa[0]['id'])) {
            $anggota_kelas = $this->anggota_kelas->get_anggota_by_id(($id_siswa ?? $siswa[0]['id']), $id_tahun_ajar)[0] ?? [];
        } else {
            $anggota_kelas = [];
        }

        if (isset($anggota_kelas) && count($anggota_kelas) != 0) {
            $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        } else {
            $wali_kelas = '';
        }

        if(isset($anggota_kelas) && count($anggota_kelas) != 0){
            $count_absen = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->countAllResults();
            $absen_ganjil = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'], 'ganjil')->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->orderBy('absensi.tanggal', 'ASC')->findAll();
            $absen_genap = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'], 'genap')->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->orderBy('absensi.tanggal', 'ASC')->findAll();
        }else{
            $count_absen = [];
            $absen_ganjil = [];
            $absen_genap = [];
        }

        if(isset($anggota_kelas) && count($anggota_kelas) != 0){
            $absen = $this->anggota_kelas
                ->select('anggota_kelas.id as anggota_kelas_id,anggota_kelas.id_kelas as kelas_id,anggota_kelas.id_tahun_ajar as tahun_ajar_id,anggota_kelas.id_siswa as siswa_id, siswa.nama as siswa_nama, ')
                ->join('siswa', 'anggota_kelas.id_siswa=siswa.id')
                ->where([
                    'id_kelas' => $anggota_kelas['id_kelas'],
                    'id_tahun_ajar' => $anggota_kelas['id_tahun_ajar'],
                    'anggota_kelas.id' => $anggota_kelas['id'],
                ])->findAll();
        }else{
            $absen = [];
        }

        $data = [
            'id_siswa' => $id_siswa ?? ($anggota_kelas[0]['id'] ?? null),
            'siswa' => $siswa,
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'id_kelas' => $anggota_kelas['id_kelas'] ?? null,
            'count_absen' => $count_absen,
            'absen_ganjil' => $absen_ganjil,
            'absen_genap' => $absen_genap,
            'absen' => $absen,
        ];

        return view('absensi/siswa/index', $data);
    }

    private function indexOrtu()
    {
        $id_siswa = $_GET['id_siswa'] ?? null;

        $siswa = $this->siswa->where('id_ortu', session()->get('id'))->findAll();
        $id_tahun_ajar = $this->tahun_ajar->where('status', 'aktif')->findAll()[0]['id'] ?? null;

        if (isset($siswa[0]['id'])) {
            $anggota_kelas = $this->anggota_kelas->get_anggota_by_id(($id_siswa ?? $siswa[0]['id']), $id_tahun_ajar)[0] ?? [];
        } else {
            $anggota_kelas = [];
        }

        if (isset($anggota_kelas) && count($anggota_kelas) != 0) {
            $wali_kelas = $this->wali_kelas->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        } else {
            $wali_kelas = '';
        }

        if(isset($anggota_kelas) && count($anggota_kelas) != 0){
            $count_absen = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->countAllResults();
            $absen_ganjil = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'], 'ganjil')->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->orderBy('absensi.tanggal', 'ASC')->findAll();
            $absen_genap = $this->absensi->queryAbsensi($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'], 'genap')->where('absensi.id_anggota_kelas', $anggota_kelas['id'])->orderBy('absensi.tanggal', 'ASC')->findAll();
        }else{
            $count_absen = [];
            $absen_ganjil = [];
            $absen_genap = [];
        }

        if(isset($anggota_kelas) && count($anggota_kelas) != 0){
            $absen = $this->anggota_kelas
                ->select('anggota_kelas.id as anggota_kelas_id,anggota_kelas.id_kelas as kelas_id,anggota_kelas.id_tahun_ajar as tahun_ajar_id,anggota_kelas.id_siswa as siswa_id, siswa.nama as siswa_nama, ')
                ->join('siswa', 'anggota_kelas.id_siswa=siswa.id')
                ->where([
                    'id_kelas' => $anggota_kelas['id_kelas'],
                    'id_tahun_ajar' => $anggota_kelas['id_tahun_ajar'],
                    'anggota_kelas.id' => $anggota_kelas['id'],
                ])->findAll();
        }else{
            $absen = [];
        }

        $data = [
            'id_siswa' => $id_siswa ?? ($anggota_kelas[0]['id'] ?? null),
            'siswa' => $siswa,
            'anggota_kelas' => $anggota_kelas,
            'wali_kelas' => $wali_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'id_kelas' => $anggota_kelas['id_kelas'] ?? null,
            'count_absen' => $count_absen,
            'absen_ganjil' => $absen_ganjil,
            'absen_genap' => $absen_genap,
            'absen' => $absen,
        ];

        // dd($data);

        return view('absensi/ortu/index', $data);
    }

    public function getAbsensi()
    {
        $tanggal_input = $this->request->getVar('tanggal');
        $data['tanggal'] = date('Y-m-d', strtotime($tanggal_input));
        $data['absensi'] = $this->absensi->where('tanggal', $data['tanggal'])->findAll();
        return json_encode(['code' => 1, 'data' => $data]);
    }

    public function getAbsensiByKelas($id_kelas, $id_tahun_ajar)
    {
        $kelas = $this->kelas->find($id_kelas);
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun_ajar);
        $absen = $this->anggota_kelas
                ->select('anggota_kelas.id as anggota_kelas_id,anggota_kelas.id_kelas as kelas_id,anggota_kelas.id_tahun_ajar as tahun_ajar_id,anggota_kelas.id_siswa as siswa_id, siswa.nama as siswa_nama, ')
                ->join('siswa', 'anggota_kelas.id_siswa=siswa.id')
                ->where([
                    'id_kelas' => $id_kelas,
                    'id_tahun_ajar' => $id_tahun_ajar
                ])->findAll();

        $count_absen = $this->absensi->queryAbsensi($id_kelas, $id_tahun_ajar)->countAllResults();
        $absen_ganjil = $this->absensi->queryAbsensi($id_kelas, $id_tahun_ajar, 'ganjil')->orderBy('absensi.tanggal', 'ASC')->findAll();
        $absen_genap = $this->absensi->queryAbsensi($id_kelas, $id_tahun_ajar, 'genap')->orderBy('absensi.tanggal', 'ASC')->findAll();

        $data = [
            'absen' => $absen,
            'count_absen' => $count_absen,
            'absen_ganjil' => $absen_ganjil,
            'absen_genap' => $absen_genap,
            'breadcrumb'   => 'Absensi',
            'kelas_raw' => $kelas,
            'tahun_ajar' => $tahun_ajar,
            'kelas' => $kelas['jenjang'] . '' . $kelas['kode']
        ];

        return $data;
    }
    
    public function insertAbsensi()
    {
        $id_kelas = $_POST['id_kelas'];
        $tanggal = $_POST['tanggal_input'];
        $id_tahun_ajar = $_POST['id_tahun_ajar'];
        $tanggal_input = date('Y-m-d', strtotime($tanggal));
        $semester = $this->request->getPost('semester');

        try {
            if ($tanggal_input <= date('Y-m-d')) {
                $raw_absensi = $this->request->getPost('absensi');
                $absensi_update = [];
                $absensi_insert = [];
                foreach($raw_absensi as $key => $absen){
                    $data_exists = $this->absensi->where([
                        'id_anggota_kelas' => $key,
                        'tanggal' => $tanggal_input,
                    ])->findAll();

                    if (isset($data_exists[0])) {
                        array_push($absensi_update, [
                            'id' => $data_exists[0]['id'],
                            'id_anggota_kelas' => $key,
                            'tanggal' => $tanggal_input,
                            'kehadiran' => $absen ,
                            'semester' => $semester
                        ]);
                    }else{
                        array_push($absensi_insert, [
                            'id_anggota_kelas' => $key,
                            'id_kelas' => $id_kelas,
                            'tanggal' => $tanggal_input,
                            'kehadiran' => $absen ,
                            'semester' => $semester
                        ]);
                    }
                }
                if(count($absensi_update) > 0){
                    $this->absensi->dt->updateBatch($absensi_update, 'id');
                }

                if(count($absensi_insert) > 0){
                    $this->absensi->dt->insertBatch($absensi_insert);
                }
            } else {
                return json_encode(['code' => 0, 'message' => 'Tanggal Absen tidak boleh melebihi tanggal sekarang']);
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return json_encode(['code' => 0, 'message' => 'Terjadi kesalahan pada sistem, gagal melakukan absensi']);
        }

        $data = $this->getAbsensiByKelas($id_kelas, $id_tahun_ajar);
        $view_absensi_ganjil = view('includes/table_absensi_ganjil', $data);
        $view_absensi_genap = view('includes/table_absensi_genap', $data);

        return json_encode(['code' => 1, 'id_kelas' => $id_kelas, 'tanggal' => $tanggal_input, 'message' => 'Berhasil melakukan absensi', 'view_absensi_ganjil' => $view_absensi_ganjil, 'view_absensi_genap' => $view_absensi_genap]);
    }

    public function destroy($tanggal, $id_kelas)
    {
        $absensi = $this->absensi
        ->select('anggota_kelas.id_tahun_ajar as id_tahun_ajar, absensi.id as id, anggota_kelas.id_kelas as id_kelas')
        ->join('anggota_kelas', 'absensi.id_anggota_kelas = anggota_kelas.id')
        ->where([
            'absensi.tanggal' => $tanggal,
            'absensi.id_kelas' => $id_kelas,
        ])->findAll();

        if(count($absensi) > 0){
            $id_kelas = $absensi[0]['id_kelas'];
            $id_tahun_ajar = $absensi[0]['id_tahun_ajar'];
            
            foreach($absensi as $absen){
                $this->absensi->delete($absen['id']);
            }

            $data = $this->getAbsensiByKelas($id_kelas, $id_tahun_ajar);
            $view_absensi_ganjil = view('includes/table_absensi_ganjil', $data);
            $view_absensi_genap = view('includes/table_absensi_genap', $data);
    
            return json_encode(['code' => 1, 'message' => 'Berhasil melakukan absensi', 'view_absensi_ganjil' => $view_absensi_ganjil, 'view_absensi_genap' => $view_absensi_genap]);
        }else{
            return json_encode(['code' => 1, 'data' => $absensi]);
        }


    }
}