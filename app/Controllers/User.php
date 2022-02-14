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
use App\Models\OrtuModel;
use App\Models\SiswaModel;
use App\Models\WaliKelasModel;
use Config\Services;

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
    protected $wali_kelas;

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
        $this->level = session()->get('level');
    }

    public function index($level)
    {

        // $asd = getKelasBySiswa(2);
        // dd($asd);
        if ($level == 'kepsek') {
            $kepsek = $this->guru->where('level', 'kepsek')->findAll()[0] ?? [];
            if ($kepsek) {
                $kepsek['foto'] = $this->guru->getFoto($kepsek['id']);
            }
        } else {
            $kepsek = [];
        }

        $data = [
            'kepsek' => $kepsek,
            'level' => $level
        ];

        return view('user/index', $data);
    }

    public function datatables($level)
    {

        $request = Services::request();
        switch ($level) {
            case 'kepsek':
                $datatable = new GuruKepsekModel($request, $level);
                break;
            case 'ortu':
                $datatable = new OrtuDataTable($request, $level);
                break;
            case 'guru':
                $datatable = new GuruKepsekDataTable($request, $level);
                break;
            case 'siswa':
                $datatable = new SiswaAllDataTable($request, $level);
                break;
            default:
                $datatable = new AdminDataTable($request, $level);
                break;
        }
        // $datatable = new OrtuDataTable($request, $level);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                if ($level == 'siswa') {
                    $row[] = "
                    <a target='_blank' href='" . base_url($this->siswa->getFoto($list->id)) . "'>
                        <img src='" . base_url($this->siswa->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                    </a>";
                } elseif ($level == 'guru' || $level == 'kepsek') {
                    $row[] = "
                    <a target='_blank' href='" . base_url($this->guru->getFoto($list->id)) . "'>
                        <img src='" . base_url($this->guru->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                    </a>";
                } elseif ($level == 'ortu') {
                    $row[] = "
                    <a target='_blank' href='" . base_url($this->ortu->getFoto($list->id)) . "'>
                        <img src='" . base_url($this->ortu->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                    </a>";
                } else {
                    $row[] = "
                    <a target='_blank' href='" . base_url($this->admin->getFoto($list->id)) . "'>
                        <img src='" . base_url($this->admin->getFoto($list->id)) . "' width='100px' height='100px' style='object-fit:contain'>
                    </a>";
                }

                $row[] = $list->nama;
                if ($level != 'siswa') {
                    $row[] = $list->email;
                }

                if ($level == 'siswa') {
                    $kelas = getKelasBySiswa($list->id);
                    $row[] = $list->nis;
                    $row[] = isset($kelas[0]) ? $kelas[0]['jenjang'] . ' ' . $kelas[0]['kode'] : 'Tanpa Kelas';
                    $row[] = isset($kelas[0]) ? $kelas[0]['tahun_mulai'] . '-' . $kelas[0]['tahun_selesai'] : '-';
                    $row[] = ucfirst($list->status);
                }

                if ($level == 'ortu') {
                    $row[] = $list->no_telp ?? '-';
                    $row[] = ucfirst($list->status);
                }

                if ($level == 'guru') {
                    $row[] = $list->nip ?? '-';
                    $row[] = $list->no_telp ?? '-';
                    $row[] = ucfirst($list->status);
                }

                if ($level == 'admin') {
                    $row[] = $list->nip ?? '-';
                    $row[] = $list->no_telp ?? '-';
                    $row[] = $list->alamat ?? '-';
                    $row[] = ucfirst($list->status);
                }

                if (isAdmin()) {
                    $row[] = "
                    <a href='" . route_to('profile_show', $level, $list->id) . "' class='btn btn-sm btn-primary mb-2'>Profil</a>
                    <a href='" . route_to('user_edit', $level, $list->id) . "' class='btn btn-sm btn-warning mb-2'>Edit</a>";
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

    public function create($level)
    {
        if ($level == 'siswa') {
            $ortu = $this->ortu->select('id, nama')->where('status', 'aktif')->orderBy('nama', 'asd')->findAll();
        } else {
            $ortu = [];
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
            $check_kepsek = $this->guru->where('level', 'kepsek')->findAll();
            if (count($check_kepsek) > 0) {
                session()->setFlashdata('error', 'Akun Kepala Sekolah Sudah Ada');
                return redirect()->back()->withInput();
            }

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

            $new_data['level'] = 'kepsek';
            $new_data['password'] = password_hash($new_data['password'], PASSWORD_BCRYPT);

            $this->guru->insertData($new_data);
            session()->setFlashdata('success', 'Berhasil menambahkan profil kepala sekolah');
            return redirect()->to(route_to('user_index', 'kepsek'));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan profil kepala sekolah');
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
}
