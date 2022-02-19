<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\Absensi;
use App\Models\AnggotaKelasModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;
use App\Models\JadwalModel;
use App\Models\AbsensiModel;
use App\Models\GuruKepsekModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use PHPUnit\Util\Json;
use Sabberworm\CSS\Value\Value;

class PanelWali extends BaseController
{

    protected $user;
    protected $guru;
    protected $siswa;
    protected $wali_kelas;
    protected $anggota_kelas;
    protected $tahun_ajar;
    protected $jadwal;
    protected $request;
    protected $absensi;
    protected $kelas;

    public function __construct()
    {
        // $this->user = new UserModel();
        $this->guru = new GuruKepsekModel();
        $this->siswa = new SiswaModel();
        $this->kelas = new KelasModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->jadwal = new JadwalModel;
        $this->absensi = new AbsensiModel;
        $this->request = \Config\Services::request();
    }

    public function index()
    {
        $user = $this->guru->getData(session()->get('id'));
        $id_tahun_ajar = $this->tahun_ajar->getActiveId();
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun_ajar);
        $tanggal_absensi = $this->request->getVar('tanggal');
        $kelas = $this->wali_kelas
            ->join('kelas', 'wali_kelas.id_kelas = kelas.id')
            ->join('guru_kepsek', 'wali_kelas.id_guru_wali = guru_kepsek.id')
            ->join('tahun_ajar', 'wali_kelas.id_tahun_ajar = tahun_ajar.id')
            ->where([
                'id_guru_wali' => $user['id'],
                'id_tahun_ajar' => $id_tahun_ajar
            ])->findAll();
            
        foreach ($kelas as $key => $each) {
            $kelas[$key]['jumlah_siswa'] = $this->assignStudentCount($each, $id_tahun_ajar);
            $kelas[$key]['hari'] = $this->jadwal->get_hari($each['id_kelas'], $each['id_tahun_ajar']);
            $kelas[$key]['jadwal'] = $this->jadwal->get_jadwal_by_id($each['id_kelas'], $each['id_tahun_ajar']);
            $kelas[$key]['kelas'] = $this->kelas->getData($each['id_kelas']);

            $data_absen = $this->absensi->getAbsensiByKelas($each['id_kelas'], $id_tahun_ajar);
            $kelas[$key]['absen'] = $data_absen['absen'];
            $kelas[$key]['count_absen'] = $data_absen['count_absen'];
            $kelas[$key]['absen_ganjil'] = $data_absen['absen_ganjil'];
            $kelas[$key]['absen_genap'] = $data_absen['absen_genap'];
            $kelas[$key]['group_bulan_ganjil'] = $data_absen['group_bulan_ganjil'];
            $kelas[$key]['group_bulan_genap'] = $data_absen['group_bulan_genap'];
        }

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'kelas' => $kelas,
            'tanggal_absensi' => $tanggal_absensi,
        ];

        // dd($data);

        return view('panel_wali/index', $data);
    }

    private function assignStudentCount($array, $id_tahun)
    {
        return $this->anggota_kelas
            ->where(['id_kelas' => $array['id_kelas'], 'id_tahun_ajar' => $id_tahun])
            ->countAllResults() ?? null;
    }
}
