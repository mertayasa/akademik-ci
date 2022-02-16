<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\GuruKepsekModel;
use App\Models\OrtuModel;
use App\Models\SiswaModel;

use function PHPUnit\Framework\returnSelf;

class Profile extends BaseController
{
    protected $user;
    protected $admin;
    protected $siswa;
    protected $ortu;
    protected $guru;

    public function __construct()
    {
        // $this->user = new UserModel();
        $this->siswa = new SiswaModel();
        $this->guru = new GuruKepsekModel();
        $this->admin = new AdminModel();
        $this->ortu = new OrtuModel();
    }

    public function show($level, $id)
    {
        if ($level != null) {
            if ($level == 'siswa') {
                $user = $this->siswa->getData($id);
                $user['foto'] = $this->siswa->getFoto($user['id']);
                $ortu = $this->ortu->getData($user['id_ortu']);
            } elseif ($level == 'admin') {
                $user = $this->admin->getData($id);
                $user['foto'] = $this->admin->getFoto($user['id']);
                $ortu = [];
            } elseif ($level == 'ortu') {
                $user = $this->ortu->getData($id);
                $user['foto'] = $this->ortu->getFoto($user['id']);
                $ortu = [];
            } else {
                $user = $this->guru->getData($id);
                $user['foto'] = $this->guru->getFoto($user['id']);
                $ortu = [];
            }

            if (($level == 'ortu' or $level == 'admin')) {
                $siswa = $this->siswa->where('id_ortu', $user['id'])->findAll();
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
            return view('profile/show', $data);
        }

        session()->setFlashdata('error', 'Akun pengguna tidak ditemukan');
        return redirect()->back();
    }

    public function edit()
    {
        $id = session()->get('id');
        $level = session()->get('level');
        switch ($level) {
            case 'admin':
                $user = $this->admin->getData($id);
                $user['foto'] = $this->admin->getFoto($user['id']);
                break;
            case 'siswa':
                $user = $this->siswa->getData($id);
                $user['foto'] = $this->siswa->getFoto($user['id']);
                break;
            case 'ortu':
                $user = $this->ortu->getData($id);
                $user['foto'] = $this->ortu->getFoto($user['id']);
                break;
            case 'guru':
                $user = $this->guru->getData($id);
                $user['foto'] = $this->guru->getFoto($user['id']);
                break;
            case 'kepsek':
                $user = $this->guru->getData($id);
                $user['foto'] = $this->guru->getFoto($user['id']);
                break;
            default:
                $user = [];
        }

        $data = [
            'user' => $user,
            'include_form' => 'profile/form/' . $level
        ];

        return view('profile/edit', $data);
    }

    public function update()
    {
        $level = session()->get('level');
        try {
            $id = session()->get('id');
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

            switch ($level) {
                case 'admin':
                    $this->admin->updateData($id, $update_data);
                    break;
                case 'siswa':
                    $this->siswa->updateData($id, $update_data);
                    break;
                case 'ortu':
                    $this->ortu->updateData($id, $update_data);
                    break;
                case 'guru':
                    $this->guru->updateData($id, $update_data);
                    break;
                case 'kepsek':
                    $this->guru->updateData($id, $update_data);
                    break;
                default:
                    $user = [];
            }
            session()->setFlashdata('success', 'Berhasil mengubah profil');
            return redirect()->to(route_to('profile_show', $level, $id));
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah profil');
            return redirect()->back()->withInput();
        }
    }
}
