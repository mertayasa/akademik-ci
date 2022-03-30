<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\TahunAjarModel;
use App\Controllers\Akademik;
use App\Models\AbsensiModel;
use App\Models\AdminModel;
use App\Models\AnggotaKelasModel;
use App\Models\DataTables\AdminDataTable;
use App\Models\DataTables\GuruKepsekDataTable;
use App\Models\DataTables\OrtuDataTable;
use App\Models\DataTables\PindahSekolahDataTable;
use App\Models\DataTables\SiswaAllDataTable;
use App\Models\GuruKepsekModel;
use App\Models\JadwalModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use App\Models\OrtuModel;
use App\Models\PrestasiModel;
use App\Models\SiswaModel;
use App\Models\WaliKelasModel;
use CodeIgniter\Config\Services;

class History extends BaseController
{
    protected $siswa_m;
    protected $absen_m;
    protected $anggota_kelas_m;
    protected $guru_m;
    protected $ortu_m;
    protected $admin_m;
    protected $jadwal_m;
    protected $kelas_m;
    protected $mapel_m;
    protected $nilai_m;
    protected $prestasi_m;
    protected $tahun_ajar_m;
    protected $wali_kelas_m;
    protected $request;
    public function __construct()
    {
        $this->tahun_ajar_m = new TahunAjarModel();
        $this->mapel_m = new MapelModel;
        $this->request = service('request');
    }
    
    public function index($menu)
    {
        switch ($menu) {
            case 'akademik':
                return $this->akademikIndex();
                break;
                // case 'admin':
                //     return $this->adminIndex();
                //     break;
                // case 'kepsek':
                //     return $this->kepsekIndex();
                //     break;
                // case 'guru':
                //     return $this->guruIndex();
                //     break;
                // case 'siswa':
                //     return $this->siswaIndex();
                //     break;
                // case 'ortu':
                //     return $this->ortuIndex();
                //     break;
            case 'prestasi':
                return $this->prestasiIndex();
                break;
                // case 'agenda':
                //     return $this->agendaIndex();
                //     break;
        }
    }

    public function akademikIndex()
    {
        $this->kelas_m = new KelasModel();
        $tahun_ajar_aktif = $this->tahun_ajar_m->find($this->tahun_ajar_m->getActiveId());
        $tahun_ajar_raw = $this->tahun_ajar_m->where('id <', $tahun_ajar_aktif['id'])->orderBy('tahun_mulai', 'ASC')->findAll();

        if ($this->request->getGet('id_tahun') != null) {
            $id_tahun = $this->request->getGet('id_tahun');
            $tahun_ajar = [];

            $param_tahun = $this->request->getPost('tahun_ajar');
            $selected_tahun = $this->tahun_ajar_m->find($id_tahun);


            // if (!$param_tahun) {
            //     $selected_tahun = $this->tahun_ajar_m->getActiveId();
            // }

            $kelas = $this->getJenjang($id_tahun);
            // dd($kelas);

            foreach ($tahun_ajar_raw as $raw) {
                $tahun_ajar[$raw['id']] = $raw['tahun_mulai'] . '/' . $raw['tahun_selesai'];
            }

            $data = [
                'kelas' => $kelas,
                'tahun_ajar' => $tahun_ajar,
                'tahun_ajar_active' => $tahun_ajar_aktif,
                'tahun_ajar_selected' => $selected_tahun,
                'id_tahun_selected' => $id_tahun,
            ];

            return view('menu_history/akademik/index', $data);
        } else {
            $tahun_ajar = [];
            foreach ($tahun_ajar_raw as $raw) {
                $tahun_ajar[$raw['id']] = $raw['tahun_mulai'] . '/' . $raw['tahun_selesai'];
            }
            $data = [
                'tahun_ajar' => $tahun_ajar,
                'no_tahun_selected' => '',
            ];

            return view('menu_history/akademik/index', $data);
        }
    }

    private function getJenjang($id_tahun)
    {
        $this->kelas_m = new KelasModel();

        $akademik = new Akademik();

        $jenjang   = array();
        $data   = $this->kelas_m->getData();
        // dd($data);
        foreach ($data as $each) {
            $jenjang[$each['jenjang']]['kelas'] = $akademik->assignTeacherAndCountStudent($this->kelas_m->where('jenjang', $each['jenjang'])->findAll(), $id_tahun, $each['jenjang']);
        }
        // dd($jenjang);
        return $jenjang;
    }

    public function showStudent($id_tahun, $id_kelas)
    {
        $this->kelas_m = new KelasModel();
        $tahun_ajar = $this->tahun_ajar_m->getData($id_tahun);
        $kelas = $this->kelas_m->getData($id_kelas);
        $include = 'menu_history/akademik/student_datatable';

        $data = [
            'tahun_ajar'   => $tahun_ajar,
            'kelas'        => $kelas,
            'breadcrumb'   => 'Daftar Siswa',
            'include_view' => $include
        ];

        return view('menu_history/akademik/student_index', $data);
    }

    public function nilai($id, $semester)
    {
        $jadwalModel = new JadwalModel;
        $this->anggota_kelas_m = new AnggotaKelasModel();
        $this->nilai_m = new NilaiModel();
        $this->wali_kelas_m = new WaliKelasModel();

        $id_tahun_ajar = $this->tahun_ajar_m->where('status', 'aktif')->findAll()[0]['id'];
        $anggota_kelas = $this->anggota_kelas_m->get_anggota_by_id($id, $id_tahun_ajar)[0] ?? [];
        $wali_kelas = $this->wali_kelas_m->get_wali_kelas_by_id($anggota_kelas['id_kelas'], $anggota_kelas['id_tahun_ajar'])[0]->nama_guru ?? '-';
        $nilai = $this->nilai_m->get_nilai_by_semester($anggota_kelas['id'], $semester) ?? [];
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

    public function jadwal($id_kelas, $id_tahun_ajar)
    {
        $this->jadwal_m = new JadwalModel;
        $this->guru_m = new GuruKepsekModel;
        $this->mapel_m = new MapelModel;
        $this->kelas_m = new KelasModel();

        $jadwal_kelas = $this->jadwal_m->get_jadwal_by_id($id_kelas, $id_tahun_ajar);
        $jadwal_hari = $this->jadwal_m->get_hari($id_kelas, $id_tahun_ajar);
        $guru = $this->guru_m->where('level', 'guru')->get()->getResultObject();
        $mapel = $this->mapel_m->findAll();
        $kelas = $this->kelas_m->getData($id_kelas);
        $tahun_ajar = $this->tahun_ajar_m->getData($id_tahun_ajar);
        $include = 'menu_history/akademik/student_jadwal';

        $data = [
            'jadwal'       => $jadwal_kelas,
            'hari'         => $jadwal_hari,
            'hari_all'     => getHari(),
            'kelas'        => $kelas,
            'mapel'        => $mapel,
            'tahun_ajar'   => $tahun_ajar,
            'breadcrumb'   => 'Daftar Jadwal',
            'guru'         => $guru,
            'include_view' => $include,
            'uri'          => service('uri')
        ];

        return view('menu_history/akademik/student_index', $data);
    }

    public function wali($id_kelas, $id_tahun_ajar)
    {
        $this->kelas_m = new KelasModel();
        $this->guru_m = new GuruKepsekModel;
        $this->wali_kelas_m = new WaliKelasModel;
        $guru_list = $this->guru_m->where('level', 'guru')->orderBy('nama', 'asd')->findAll();
        $wali = $this->wali_kelas_m->get_wali_kelas_by_id($id_kelas, $id_tahun_ajar);
        $tahun_ajar = $this->tahun_ajar_m->getData($id_tahun_ajar);
        $kelas = $this->kelas_m->getData($id_kelas);
        $iinclude = 'menu_history/akademik/wali_kelas';

        $data = [
            'wali_kelas'    => $wali,
            'guru'          => $guru_list,
            'kelas'         => $kelas,
            'tahun_ajar'    => $tahun_ajar,
            'id_kelas'      => $id_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'include_view'  => $iinclude,
            'breadcrumb'    => 'Wali Kelas',
            'no'            => 1
        ];

        return view('menu_history/akademik/student_index', $data);
    }

    public function absensi($id_kelas, $id_tahun_ajar)
    {
        $this->absen_m = new AbsensiModel;
        $data = $this->absen_m->getAbsensiByKelas($id_kelas, $id_tahun_ajar);

        return view('menu_history/akademik/absensi', $data);
    }

    //-----USER-----
    public function user($level)
    {
        $this->guru_m = new GuruKepsekModel;
        if ($level == 'kepsek') {
            $kepsek = $this->guru_m->where('level', 'kepsek')->findAll()[0] ?? [];
            if ($kepsek) {
                $kepsek['foto'] = $this->guru_m->getFoto($kepsek['id']);
            }
        } else {
            $kepsek = [];
        }

        $data = [
            'kepsek' => $kepsek,
            'level' => $level
        ];

        return view('menu_history/user/index', $data);
    }

    public function datatables($level)
    {
        $this->siswa_m = new SiswaModel;
        $this->guru_m = new GuruKepsekModel;
        $this->ortu_m = new OrtuModel;
        $this->admin_m = new AdminModel;

        $request = Services::request();
        switch ($level) {
            case 'kepsek':
                $datatable = new GuruKepsekDataTable($request, $level);
                break;
            case 'ortu':
                $datatable = new OrtuDataTable($request, $level, 'nonaktif');
                break;
            case 'guru':
                $datatable = new GuruKepsekDataTable($request, $level, 'nonaktif');
                break;
            case 'siswa':
                $datatable = new SiswaAllDataTable($request, $level, ['lulus', 'nonaktif']);
                break;
            default:
                $datatable = new AdminDataTable($request, $level, 'nonaktif');
                break;
        }
        // $datatable = new OrtuDataTable($request, $level);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatablesHistory();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                // if ($level == 'siswa') {
                //     $row[] = "
                //     <a target='_blank' href='" . base_url($this->siswa_m->getFoto($list->id)) . "'>
                //         <img src='" . base_url($this->siswa_m->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                //     </a>";
                // } elseif ($level == 'guru' || $level == 'kepsek') {
                //     $row[] = "
                //     <a target='_blank' href='" . base_url($this->guru_m->getFoto($list->id)) . "'>
                //         <img src='" . base_url($this->guru_m->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                //     </a>";
                // } elseif ($level == 'ortu') {
                //     $row[] = "
                //     <a target='_blank' href='" . base_url($this->ortu_m->getFoto($list->id)) . "'>
                //         <img src='" . base_url($this->ortu_m->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                //     </a>";
                // } else {
                //     $row[] = "
                //     <a target='_blank' href='" . base_url($this->admin_m->getFoto($list->id)) . "'>
                //         <img src='" . base_url($this->admin_m->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                //     </a>";
                // }

                if ($level == 'siswa') {
                    $row[] = $list->nis;
                    $row[] = $list->nama;
                    $kelas = getKelasBySiswa($list->id);
                    $row[] = isset($kelas[0]) ? $kelas[0]['jenjang'] . ' ' . $kelas[0]['kode'] : 'Tanpa Kelas';
                    $row[] = isset($kelas[0]) ? $kelas[0]['tahun_mulai'] . '-' . $kelas[0]['tahun_selesai'] : '-';
                    $row[] = ucfirst($list->status);
                }

                if ($level == 'ortu') {
                    $row[] = $list->nama;
                    $row[] = $list->email;
                    $row[] = $list->no_telp ?? '-';
                    $row[] = ucfirst($list->status);
                }

                if ($level == 'guru') {
                    $row[] = $list->nip ?? '-';
                    $row[] = $list->nama;
                    $row[] = $list->email;
                    $row[] = $list->no_telp ?? '-';
                    $row[] = ucfirst($list->status);
                }
                if ($level == 'kepsek') {
                    $row[] = $list->nip ?? '-';
                    $row[] = $list->nama;
                    $row[] = $list->email;
                    $row[] = $list->no_telp ?? '-';
                    $row[] = ucfirst($list->status);
                    $row[] = $list->masa_jabatan_kepsek ?? '-';
                }

                if ($level == 'admin') {
                    $row[] = $list->nip ?? '-';
                    $row[] = $list->nama;
                    $row[] = $list->email;
                    $row[] = $list->no_telp ?? '-';
                    $row[] = $list->alamat ?? '-';
                    $row[] = ucfirst($list->status);
                }

                if (isAdmin()) {
                    $action = "<a href='" . route_to('history_user_profil', $level, $list->id) . "' class='btn btn-sm btn-primary mb-2'>Profil</a>";
                    
                    if($level == 'siswa'){
                        $action .= "<a href='" . route_to('nilai_history_by_id', $list->id) . "' class='btn btn-sm btn-success ml-2 mb-2'>Riwayat Nilai</a>";
                    }

                    $row[] = $action;
                    // <a href='" . route_to('user_edit', $level, $list->id) . "' class='btn btn-sm btn-warning mb-2'>Edit</a>";
                    // <button class='btn btn-sm btn-danger' onclick='deleteModel(`" . route_to('user_destroy', $list->id, $level) . "`, `userDataTable`, `Aseg`)'>Hapus</button>";
                } else {
                    $row[] = "<a href='" . route_to('profile_show', $level, $list->id) . "' class='btn btn-sm btn-primary mb-2'>Profil</a>";
                }

                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data,
            ];

            return json_encode($output);
        }
    }

    public function userProfil($level, $id)
    {
        $this->admin_m = new AdminModel;
        $this->guru_m = new GuruKepsekModel;
        $this->siswa_m = new SiswaModel;
        $this->ortu_m = new OrtuModel;
        if ($level != null) {
            if ($level == 'siswa') {
                $user = $this->siswa_m->getData($id);
                $user['foto'] = $this->siswa_m->getFoto($user['id']);
                $ortu = $this->ortu_m->getData($user['id_ortu']);
            } elseif ($level == 'admin') {
                $user = $this->admin_m->getData($id);
                $user['foto'] = $this->admin_m->getFoto($user['id']);
                $ortu = [];
            } elseif ($level == 'ortu') {
                $user = $this->ortu_m->getData($id);
                $user['foto'] = $this->ortu_m->getFoto($user['id']);
                $ortu = [];
            } else {
                $user = $this->guru_m->getData($id);
                $user['foto'] = $this->guru_m->getFoto($user['id']);
                $ortu = [];
            }

            if (($level == 'ortu' or $level == 'admin')) {
                $siswa = $this->siswa_m->where('id_ortu', $user['id'])->findAll();
                $nama_siswa = array_map(function ($siswa) {
                    return $siswa['nama'];
                }, $siswa);
            } else {
                $nama_siswa = [];
            }


            $data = [
                'user' => $user,
                'ortu' => $ortu,
                'nama_siswa' => implode(', ', $nama_siswa),
                'level' => $level,
                'id' => $id
            ];
            return view('menu_history/user/show', $data);
        }

        session()->setFlashdata('error', 'Akun pengguna tidak ditemukan');
        return redirect()->back();
    }

    //-----PRESTASI-----
    public function prestasiIndex()
    {
        $this->prestasi_m = new PrestasiModel;
        $tahun_ajar_aktif = $this->tahun_ajar_m->find($this->tahun_ajar_m->getActiveId());
        $tahun_ajar_raw = $this->tahun_ajar_m->where('id <', $tahun_ajar_aktif['id'])->findAll();
        $tahun_ajar = [];

        if ($this->request->getGet('id_tahun')) {
            $id_tahun = $this->request->getGet('id_tahun');
            $selected_tahun = $this->tahun_ajar_m->find($id_tahun);
            foreach ($tahun_ajar_raw as $raw) {
                $tahun_ajar[$raw['id']] = $raw['tahun_mulai'] . '/' . $raw['tahun_selesai'];
            }
            $prestasi = $this->prestasi_m->where('id_tahun_ajar', $id_tahun)->orderBy('created_at desc');

            $data = [
                'prestasi' => $prestasi->paginate(10),
                'pager' => $prestasi->pager,
                'tahun_ajar' => $tahun_ajar,
                'tahun_ajar_selected' => $selected_tahun,
                'id_tahun_selected' => $id_tahun
            ];
            return view('menu_history/prestasi/index', $data);
        } else {
            foreach ($tahun_ajar_raw as $raw) {
                $tahun_ajar[$raw['id']] = $raw['tahun_mulai'] . '/' . $raw['tahun_selesai'];
            }
            $data = [
                'tahun_ajar' => $tahun_ajar,
                'no_tahun_selected' => '',
            ];
            return view('menu_history/prestasi/index', $data);
        }
    }

    public function prestasiDetail($id)
    {
        $this->prestasi_m = new PrestasiModel;
        $prestasi = $this->prestasi_m->getData($id);

        $data = [
            'prestasi' => $prestasi,
        ];

        return view('menu_history/prestasi/detail', $data);
    }

    //-----PINDAHAN-----
    public function pindahMasuk()
    {
        $data = [
            'tipe' => 'masuk',
        ];

        return view('menu_history/pindah_sekolah/index', $data);
    }

    public function pindahKeluar()
    {
        $data = [
            'tipe' => 'keluar',
        ];

        return view('menu_history/pindah_sekolah/index', $data);
    }

    public function pindahDatatables($tipe)
    {
        $request = Services::request();
        $datatable = new PindahSekolahDataTable($request, $tipe);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $tahun_ajar = $this->tahun_ajar->getData($list->id_tahun_ajar);
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $this->siswa->getData($list->id_siswa)['nama'] ?? '-';
                if ($tipe == 'masuk') {
                    $row[] = $list->asal;
                }
                if ($tipe == 'keluar') {
                    $row[] = $list->tujuan;
                }
                $row[] = isset($tahun_ajar) ? $tahun_ajar['tahun_mulai'] . '/' . $tahun_ajar['tahun_selesai'] : '-';
                $row[] = $list->alasan;
                if (session()->get('level') == 'admin') {
                    $row[] = "
                    <a href='" . route_to('pindah_sekolah_show', $tipe, $list->id) . "' class='btn btn-sm btn-info'>Lihat</a>
                    <a href='" . route_to('pindah_sekolah_edit', $list->id) . "' class='btn btn-sm btn-warning'>Edit</a>";
                    // <button class='btn btn-sm btn-danger' onclick='deleteModel(`" . route_to('kelas_destroy', $list->id) . "`, `kelasDataTable`, `Apakah anda yang menghapus data jenjang kelas ?`)'>Hapus</button>";
                } else {
                    $row[] = "";
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data,
            ];

            return json_encode($output);
        }
    }
}
