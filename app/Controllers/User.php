<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\AnggotaKelasModel;
use App\Models\DataTables\AdminDataTable;
use App\Models\DataTables\GuruKepsekDataTable;
use App\Models\DataTables\SiswaDataTable;
use App\Models\DataTables\OrtuDataTable;
use App\Models\DataTables\SiswaAllDataTable;
// use App\Models\DataTables\UserDataTable;
use App\Models\GuruKepsekModel;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\KelasPerTahunModel;
use App\Models\OrtuModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;
use Config\Services;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Expr\Isset_;
use PHPUnit\Framework\Constraint\IsEmpty;

class User extends BaseController
{
    protected $user;
    protected $siswa;
    protected $ortu;
    protected $guru;
    protected $level;
    protected $admin;
    protected $anggota_kelas;
    protected $jadwal;
    protected $kelas_per_tahun;
    protected $wali_kelas;
    protected $tahun_ajar;
    protected $kelas;

    public function __construct()
    {
        // $this->user = new UserModel();
        $this->siswa = new SiswaModel();
        $this->ortu = new OrtuModel();
        $this->guru = new GuruKepsekModel();
        $this->admin = new AdminModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->jadwal = new JadwalModel();
        $this->wali_kelas = new WaliKelasModel();
        $this->kelas_per_tahun = new KelasPerTahunModel();
        $this->tahun_ajar = new TahunAjarModel();
        $this->kelas = new KelasModel();
        $this->level = session()->get('level');
    }

    public function index($level)
    {
        $tahun_ajar = $this->tahun_ajar->findAll();
        $kelas = $this->kelas->findAll();
        if (isOrtu() and $level == 'siswa') {
            return $this->studentByOrtu();
        }

        if ($level == 'kepsek') {
            $kepsek = $this->guru->where(['level' => 'kepsek', 'status' => 'aktif'])->findAll()[0] ?? [];
            if ($kepsek) {
                $kepsek['foto'] = $this->guru->getFoto($kepsek['id']);
            }
        } else {
            $kepsek = [];
        }

        $data = [
            'kepsek' => $kepsek,
            'level' => $level,
            'tahun_ajar' => $tahun_ajar,
            'kelas' => $kelas
        ];

        return view('user/index', $data);
    }

    public function studentByOrtu()
    {
        $id_ortu = session()->get('id');
        $ortu = $this->ortu->getData($id_ortu);
        $siswa = $this->siswa->where('id_ortu', $id_ortu)->findAll();
        foreach ($siswa as $key => $sis) {
            $siswa[$key]['foto'] = $this->siswa->getFoto($sis['id']);

            $kelas = getKelasBySiswa($sis['id']);
            if (isset($kelas[0])) {
                $kelas_per_tahun = $this->kelas_per_tahun->where([
                    'id_kelas' => $kelas[0]['id'],
                    'id_tahun_ajar' => $kelas[0]['id_tahun_ajar']
                ])
                    ->findAll();

                if (isset($kelas_per_tahun[0])) {
                    $siswa[$key]['wali_kelas'] = $this->wali_kelas->where([
                        'id_kelas' => $kelas[0]['id'],
                        'id_tahun_ajar' => $kelas[0]['id_tahun_ajar']
                    ])
                        ->join('guru_kepsek', 'wali_kelas.id_guru_wali = guru_kepsek.id')
                        ->findAll();
                }
            } else {
                $siswa[$key]['wali_kelas'] = [];
            }

            $siswa[$key]['kelas'] = $kelas ?? [];
        }

        $data = [
            'level' => 'siswa',
            'siswa' => $siswa,
            'ortu' => $ortu,
        ];

        return view('profile/list-siswa', $data);
    }

    public function datatables($level)
    {
        $request = Services::request();
        $data_filter = [
            'id_tahun_ajar' => '',
            'id_kelas' => '',
            'status' => ''
        ];
        
        if($request->getGet()){
            $data_filter = [
                'id_tahun_ajar' => $request->getGet('id_tahun_ajar'),
                'id_kelas' => $request->getGet('kelas'),
                'status' => $request->getGet('status')
            ];
        }

        switch ($level) {
            case 'kepsek':
                $datatable = new GuruKepsekDataTable($request, $level);
                break;
            case 'ortu':
                $datatable = new OrtuDataTable($request, $level);
                break;
            case 'guru':
                $datatable = new GuruKepsekDataTable($request, $level);
                break;
            case 'siswa':
                $datatable = new SiswaAllDataTable($request, $level, $status = null, $data_filter);
                break;
            default:
                $datatable = new AdminDataTable($request, $level);
                break;
        }

        
        // if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start') ?? $request->getGet('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                // if ($level == 'siswa') {
                //     $row[] = "
                //     <a target='_blank' href='" . base_url($this->siswa->getFoto($list->id)) . "'>
                //         <img src='" . base_url($this->siswa->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                //     </a>";
                // } elseif ($level == 'guru' || $level == 'kepsek') {
                //     $row[] = "
                //     <a target='_blank' href='" . base_url($this->guru->getFoto($list->id)) . "'>
                //         <img src='" . base_url($this->guru->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                //     </a>";
                // } elseif ($level == 'ortu') {
                //     $row[] = "
                //     <a target='_blank' href='" . base_url($this->ortu->getFoto($list->id)) . "'>
                //         <img src='" . base_url($this->ortu->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                //     </a>";
                // } else {
                //     $row[] = "
                //     <a target='_blank' href='" . base_url($this->admin->getFoto($list->id)) . "'>
                //         <img src='" . base_url($this->admin->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                //     </a>";
                // }

                // $row[] = $list->nama;
                // if ($level != 'siswa') {
                //     $row[] = $list->email;
                // }

                if ($level == 'siswa') {
                    $row[] = $list->nis;
                    $row[] = $list->nama;
                    $kelas = getKelasBySiswa($list->id);
                    $row[] = $list->kelas ?? (isset($kelas[0]) ? $kelas[0]['jenjang'] . ' ' . $kelas[0]['kode'] : 'Tanpa Kelas');
                    $row[] = $list->tahun_ajar ?? (isset($kelas[0]) ? $kelas[0]['tahun_mulai'] . '-' . $kelas[0]['tahun_selesai'] : '-');
                }

                if ($level == 'ortu') {
                    $row[] = $list->nama;
                    $row[] = $list->email;
                    $row[] = $list->no_telp ?? '-';
                }

                if ($level == 'guru') {
                    if (isAdmin() or isGuru()) {
                        $row[] = $list->nip ?? '-';
                    } else {
                        $row[] = '';
                    }
                    $row[] = $list->nama;
                    $row[] = $list->email;
                    $row[] = $list->no_telp ?? '-';
                }
                if ($level == 'kepsek') {
                    $row[] = $list->nip ?? '-';
                    $row[] = $list->nama;
                    $row[] = $list->email;
                    $row[] = $list->no_telp ?? '-';
                    $row[] = $list->masa_jabatan_kepsek ?? '-';
                }

                if ($level == 'admin') {
                    $row[] = $list->nip ?? '-';
                    $row[] = $list->nama;
                    $row[] = $list->email;
                    $row[] = $list->no_telp ?? '-';
                    $row[] = $list->alamat ?? '-';
                }

                if (isAdmin()) {
                    $button_action = "
                        <a href='" . route_to('profile_show', $level, $list->id) . "' class='btn btn-sm btn-primary mb-2'>Profil</a>
                        <a href='" . route_to('user_edit', $level, $list->id) . "' class='btn btn-sm btn-warning mb-2'>Edit</a>";

                    if($list->status == 'aktif' && $list->status != 'lulus'){
                        $button_action.="<button class='btn btn-sm btn-danger mb-2 ml-2' onclick='setNonaktif(`" . route_to('user_set_nonaktif', $list->id, $level) . "`, `userDataTable`, `$level`)'>Nonaktif</button>";
                    }

                    $row[] = $button_action;
                } else {
                    $row[] = "<a href='" . route_to('profile_show', $level, $list->id) . "' class='btn btn-sm btn-primary mb-2'>Profil</a>";
                }

                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw') ?? $request->getGet('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data,
            ];

            return json_encode($output);
        // }
    }

    public function create($level)
    {
        if ($level == 'siswa') {
            $ortu = $this->ortu->select('id, nama')->where('status', 'aktif')->orderBy('nama', 'asd')->findAll();
        } else {
            $ortu = [];
        }

        if ($level == 'kepsek' && kepsekNotNull()) {
            session()->setFlashdata('error', 'Sekolah masih memiliki kepala sekolah aktif, mohon nonaktifkan kepala sekolah yang lama terlebih dahulu');
            return redirect()->back();
        }

        $data = [
            'level' => $level,
            'ortu' => $ortu
        ];

        return view('user/create', $data);
    }

    public function insert($level)
    {
        try {
            $allowed_level = ['guru', 'kepsek'];
            $new_data = $this->request->getPost();
            if ($level == 'guru' or $level == 'kepsek') {
                $new_data['level'] = $level == 'guru-kepsek' && in_array($new_data['level'], $allowed_level) ? $new_data['level'] : $level;
            }
            if (!$new_data['password']) {
                session()->setFlashdata('error', 'Password belum diisi');
                return redirect()->back()->withInput();
            }
            $new_data['password'] = password_hash($new_data['password'], PASSWORD_BCRYPT);

            if ($this->request->getPost('foto')) {
                $base_64_foto = json_decode($this->request->getPost('foto'), true);
                $upload_image = uploadFile($base_64_foto, 'avatar');

                if ($upload_image === 0) {
                    session()->setFlashdata('error', 'Gagal mengupload gambar');
                    return redirect()->back()->withInput();
                }

                $new_data['foto'] = $upload_image;
            }
            switch ($level) {
                case "admin":
                    $this->admin->insertData($new_data);
                    break;
                case "siswa":
                    $this->siswa->insertData($new_data);
                    break;
                case "ortu":
                    $this->ortu->insertData($new_data);
                    break;
                case "guru":
                    $this->guru->insertData($new_data);
                    break;
                case "kepsek":
                    $new_data['level'] = 'kepsek';
                    $this->guru->insertData($new_data);
                    break;
            }
            session()->setFlashdata('success', 'Berhasil menambahkan data user');
            return redirect()->to(route_to('user_index', $level));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan data user');
            return redirect()->back()->withInput();
        }
    }

    public function edit($level, $id)
    {
        if ($level == 'siswa') {
            $ortu = $this->ortu->select('id, nama')->orderBy('nama', 'asd')->findAll();
            $user = $this->siswa->getData($id);
            $user['foto'] = $this->siswa->getFoto($id);
            $user['is_pindah_keluar'] = checkPindahKeluar($id);
        } elseif ($level == "ortu") {
            $ortu = [];
            $user = $this->ortu->getData($id);
            $user['foto'] = $this->ortu->getFoto($id);
        } elseif ($level == "guru") {
            $ortu = [];
            $user = $this->guru->getData($id);
            $user['foto'] = $this->guru->getFoto($id);
        } elseif ($level == "kepsek") {
            $ortu = [];
            $user = $this->guru->getData($id);
            $user['foto'] = $this->guru->getFoto($id);
        } else {
            $ortu = [];
            $user = $this->admin->getData($id);
            $user['foto'] = $this->admin->getFoto($id);
        }

        $data = [
            'level' => $level,
            'user' => $user,
            'ortu' => $ortu
        ];

        return view('user/edit', $data);
    }

    public function update($level, $id)
    {
        try {
            $update_data = $this->request->getPost();
            if ($update_data['password'] != '') {
                $update_data['password'] = password_hash($update_data['password'], PASSWORD_BCRYPT);
            } else {
                unset($update_data['password']);
                unset($update_data['password_confirmation']);
            }

            if ($this->request->getPost('foto')) {
                $base_64_foto = json_decode($this->request->getPost('foto'), true);
                $upload_image = uploadFile($base_64_foto, 'avatar');

                if ($upload_image === 0) {
                    session()->setFlashdata('error', 'Gagal mengupload gambar');
                    return redirect()->back()->withInput();
                }

                $update_data['foto'] = $upload_image;
            }
            if ($level == "siswa") {
                $this->siswa->updateData($id, $update_data);
            } elseif ($level == "admin") {
                $this->admin->updateData($id, $update_data);
            } elseif ($level == "ortu") {
                $this->ortu->updateData($id, $update_data);
            } elseif ($level == "kepsek") {
                $this->guru->updateData($id, $update_data);
            } else {
                $this->guru->updateData($id, $update_data);
            }
            session()->setFlashdata('success', 'Berhasil mengubah data ' . $level);
            return redirect()->to(route_to('user_index', $level));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data user');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id, $level)
    {
        try {
            switch ($level) {
                case "admin":
                    $this->admin->delete($id);
                    break;

                case "siswa":
                    $anggota_kelas = $this->anggota_kelas->where('id_siswa', $id)->countAllResults();

                    if ($anggota_kelas > 0) {
                        return json_encode([
                            'code' => 0,
                            'swal' => 'Tidak bisa menghapus data siswa karena masih digunakan di tabel lain'
                        ]);
                    }

                    $this->siswa->delete($id);
                    break;

                case "guru":
                    $jadwal = $this->jadwal->where('id_guru', $id)->countAllResults();
                    $wali_kelas = $this->wali_kelas->where('id_guru_wali', $id)->countAllResults();

                    if ($jadwal > 0 || $wali_kelas > 0) {
                        return json_encode([
                            'code' => 0,
                            'swal' => 'Tidak bisa menghapus data guru karena masih digunakan di tabel lain'
                        ]);
                    }

                    $this->guru->delete($id);
                    break;

                case "ortu":
                    $siswa = $this->siswa->where('id_ortu', $id)->countAllResults();

                    if ($siswa > 0) {
                        return json_encode([
                            'code' => 0,
                            'swal' => 'Tidak bisa menghapus data orang tua karena masih digunakan di tabel lain'
                        ]);
                    }
                    $this->ortu->delete($id);
                    break;

                case "kepsek":
                    $this->guru->delete($id);
                    break;
            }
        } catch (\Exception $e) {
            return json_encode([
                'code' => 0,
                'message' => 'Gagal menghapus data pengguna'
            ]);
        }

        return json_encode([
            'code' => 1,
            'message' => 'Berhasil menghapus data pengguna'
        ]);
    }

    public function kepsekCreate()
    {
        $data = [
            'level' => 'kepsek'
        ];
        return view('user/kepsek/create', $data);
    }

    public function kepsekInsert()
    {
        try {
            // $check_kepsek = $this->guru->where('level', 'kepsek')->findAll();
            $kepsek_aktif = $this->guru->where(['level' =>  'kepsek', 'status' => 'aktif'])->find();
            // if (count($check_kepsek) > 0) {
            //     session()->setFlashdata('error', 'Akun Kepala Sekolah Sudah Ada');
            //     return redirect()->back()->withInput();
            // }

            $new_data = $this->request->getPost();

            if ($this->request->getPost('foto')) {
                $base_64_foto = json_decode($this->request->getPost('foto'), true);
                $upload_image = uploadFile($base_64_foto, 'avatar');

                if ($upload_image === 0) {
                    session()->setFlashdata('error', 'Gagal mengupload gambar');
                    return redirect()->back()->withInput();
                }

                $new_data['foto'] = $upload_image;
            }

            if (!$new_data['password']) {
                session()->setFlashdata('error', 'Password belum diisi');
                return redirect()->back()->withInput();
            }
            //set kepsek lama jadi nonaktif
            $update_kepsek_lama = $this->guru->updateData($kepsek_aktif[0]['id'], ['status' => 'nonaktif']);
            $new_data['level'] = 'kepsek';
            $new_data['password'] = password_hash($new_data['password'], PASSWORD_BCRYPT);
            if ($update_kepsek_lama) {
                $this->guru->insertData($new_data);
                session()->setFlashdata('success', 'Berhasil mengupdate kepala sekolah baru');
                return redirect()->to(route_to('user_index', 'kepsek'));
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan  kepala sekolah baru');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan  kepala sekolah');
            return redirect()->back()->withInput();
        }
    }

    public function kepsekEdit($id)
    {
        $kepsek = $this->guru->getData($id);
        if ($kepsek) {
            $kepsek['foto'] = $this->guru->getFoto($kepsek['id']);
        } else {
            $kepsek = [];
        }

        $data = [
            'kepsek' => $kepsek
        ];

        return view('user/kepsek/edit', $data);
    }

    public function kepsekUpdate($id)
    {
        try {
            $update_data = $this->request->getPost();

            if ($this->request->getPost('foto')) {
                $base_64_foto = json_decode($this->request->getPost('foto'), true);
                $upload_image = uploadFile($base_64_foto, 'avatar');

                if ($upload_image === 0) {
                    session()->setFlashdata('error', 'Gagal mengupload gambar');
                    return redirect()->back()->withInput();
                }

                $update_data['foto'] = $upload_image;
            }

            if ($update_data['password'] != '') {
                $update_data['password'] = password_hash($update_data['password'], PASSWORD_BCRYPT);
            } else {
                unset($update_data['password']);
            }

            $this->guru->updateData($id, $update_data);
            session()->setFlashdata('success', 'Berhasil mengubah profil kepala sekolah');
            return redirect()->to(route_to('user_index', 'kepsek'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah profil kepala sekolah');
            return redirect()->back()->withInput();
        }
    }
    public function setNonaktif($id, $level)
    {
        $data = ['status' => 'nonaktif'];
        try {
            switch ($level) {
                case 'admin':
                    $this->admin->updateData($id, $data);
                    return json_encode(['code' => 1, 'message' => 'Berhasil menonaktifkan admin']);
                    break;
                case 'siswa':
                    $this->siswa->updateData($id, $data);
                    $anggota_kelas = $this->anggota_kelas->where('id_siswa', $id)->findAll();
                    foreach ($anggota_kelas as $anggota) {
                        $this->anggota_kelas->updateData($anggota['id'], [
                            'status' => 'nonaktif'
                        ]);
                    }
                    return json_encode(['code' => 1, 'message' => 'Berhasil menonaktifkan siswa']);
                    break;
                case 'guru':
                    $this->guru->updateData($id, $data);
                    return json_encode(['code' => 1, 'message' => 'Berhasil menonaktifkan guru']);
                    break;
                case 'kepsek':
                    $this->guru->updateData($id, $data);
                    return json_encode(['code' => 1, 'message' => 'Berhasil menonaktifkan kepala sekolah']);
                    break;
                case 'ortu':
                    $this->ortu->updateData($id, $data);
                    return json_encode(['code' => 1, 'message' => 'Berhasil menonaktifkan orang tua']);
                    break;
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return json_encode(['code' => 0, 'message' => 'Gagal menonaktifkan user']);
        }
    }

    public function setLulus($id_siswa, $nis)
    {
        $siswa = $this->siswa->getData($id_siswa);

        if (count($siswa) < 1) {
            return json_encode(['code' => 0, 'message' => 'Data siswa tidak ditemukan']);
        }

        if ($siswa['nis'] != $nis) {
            return json_encode(['code' => 0, 'message' => 'Data siswa tidak ditemukan']);
        }

        $anggota_kelas = $this->anggota_kelas->where([
            'id_siswa' => $siswa['id'],
            'kelas.jenjang' => '6'
        ])->join('kelas', 'anggota_kelas.id_kelas = kelas.id')->countAllResults();

        if ($anggota_kelas < 1) {
            return json_encode(['code' => 0, 'message' => 'Siswa belum pada jenjang kelas 6']);
        }

        try {
            $this->siswa->updateData($siswa['id'], ['status' => 'lulus']);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return json_encode(['code' => 0, 'message' => 'Gagal meluluskan siswa']);
        }

        return json_encode(['code' => 1, 'message' => 'Siswa atas nama ' . $siswa['nama'] . ' telah dinyatakan lulus']);
    }
}
