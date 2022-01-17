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

    public function __construct()
    {
        // $this->user = new UserModel();
        $this->guru = new GuruKepsekModel();
        $this->siswa = new SiswaModel();
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
        $id_kelas = $this->request->getVar('id_kelas');
        $tahun_ajar = $this->tahun_ajar->getData($id_tahun_ajar);
        $tanggal_absensi = $this->request->getVar('tanggal');
        // dd($tanggal_absensi);
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
            $kelas[$key]['absen'] = $this->anggota_kelas
                ->select('anggota_kelas.id as anggota_kelas_id,anggota_kelas.id_kelas as kelas_id,anggota_kelas.id_tahun_ajar as tahun_ajar_id,anggota_kelas.id_siswa as siswa_id, siswa.nama as siswa_nama, ')
                ->join('siswa', 'anggota_kelas.id_siswa=siswa.id')
                ->where([
                    'id_kelas' => $each['id_kelas'],
                    'id_tahun_ajar' => $each['id_tahun_ajar']
                ])->findAll();
        }
        // dd($kelas[$key]['absen']);

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'kelas' => $kelas,
            'tanggal_absensi' => $tanggal_absensi,
            'data_absensi' => null
        ];


        return view('panel_wali/index', $data);
    }

    private function assignStudentCount($array, $id_tahun)
    {
        return $this->anggota_kelas
            ->where(['id_kelas' => $array['id_kelas'], 'id_tahun_ajar' => $id_tahun])
            ->countAllResults() ?? null;
    }
    // public function absensi($id_kelas, $id_tahun_ajar, $id_jadwal)
    // {
    //     $absensi = $this->anggota_kelas
    //         ->select('anggota_kelas.id as anggota_kelas_id,anggota_kelas.id_kelas as kelas_id,anggota_kelas.id_tahun_ajar as tahun_ajar_id,anggota_kelas.id_siswa as siswa_id, users.nama as siswa_nama, ')
    //         ->join('users', 'anggota_kelas.id_siswa=users.id')
    //         ->where([
    //             'id_kelas' => $id_kelas,
    //             'id_tahun_ajar' => $id_tahun_ajar
    //         ])->findAll();
    //     $data = [
    //         'absensi' => $absensi,
    //         'id_jadwal' => $id_jadwal
    //     ];

    //     return view('panel_wali/index_absensi', $data);
    // }
    public function getAbsensi()
    {
        $tanggal_input = $this->request->getVar('tanggal');
        $data['tanggal'] = date('Y-m-d', strtotime($tanggal_input));
        $data['absensi'] = $this->absensi->where('tanggal', $data['tanggal'])->findAll();
        return json_encode($data);
    }
    public function insertAbsensi()
    {
        $id_anggota_kelas = $_POST['id_anggota_kelas'];
        $id_absensi = $_POST['id_absensi'];
        $id_kelas = $_POST['id_kelas'];
        $tanggal = $_POST['tanggal_input'];
        $tanggal_input = date('Y-m-d', strtotime($tanggal));
        $data_absensi = $this->absensi->where(['tanggal' => $tanggal_input, 'id_kelas' => $id_kelas[0]])->findAll();
        // dd($data_absensi[0]['id']);
        $kehadiran = $_POST['absensi'];
        $semester = $this->request->getPost('semester');
        $data_update = array();
        $data = array();
        $index = 0;

        try {
            if ($tanggal_input <= date('Y-m-d')) {
                if (count($data_absensi) > 0) {
                    foreach ($data_absensi as $key => $value) {
                        array_push($data_update, array(
                            'id' => $value['id'],
                            'tanggal' => $tanggal_input,
                            'kehadiran' => $kehadiran[$key],
                            'semester' => $semester
                        ));
                    }
                    $this->absensi->dt->updateBatch($data_update, 'id');
                } else {
                    foreach ($id_anggota_kelas as $value) {
                        array_push($data, array(
                            'id_anggota_kelas' => $value,
                            'id_kelas' => $id_kelas[$index],
                            'tanggal' => $tanggal_input,
                            'kehadiran' => $kehadiran[$index],
                            'semester' => $semester
                        ));
                        $index++;
                    }
                    $this->absensi->dt->insertBatch($data);
                }
                session()->setFlashdata('success', 'Berhasil melakukan absensi');
                return redirect()->to(route_to('panel_wali_index'));
            } else {
                session()->setFlashdata('error', 'Tanggal Absen tidak boleh melebihi tanggal sekarang');
                return redirect()->to(route_to('panel_wali_index'));
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'gagal melakukan absensi');
            return redirect()->back()->withInput();
        }
    }
}
