<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\GuruKepsekModel;
use App\Models\OrtuModel;
use App\Models\SiswaModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(route_to('dashboard_index'));
        }

        helper(['form']);
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model_admin = new AdminModel();
        $model_siswa = new SiswaModel();
        $model_guru = new GuruKepsekModel();
        $model_ortu = new OrtuModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data_admin = $model_admin->where('email', $email)->first();
        $data_siswa = $model_siswa->where('nis', $email)->first();
        $data_guru = $model_guru->where('email', $email)->first();
        $data_ortu = $model_ortu->where('email', $email)->first();
        if ($data_admin) {
            if ($data_admin['status'] == 'aktif') {
                $pass = $data_admin['password'];
                $verify_pass = password_verify($password, $pass);
                if ($verify_pass) {
                    $ses_data = [
                        'id'       => $data_admin['id'],
                        'nama'     => $data_admin['nama'],
                        'level'     => 'admin',
                        'email'    => $data_admin['email'],
                        'table'     => 'admin',
                        'logged_in'     => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to(route_to('dashboard_index'));
                } else {
                    $session->setFlashdata('error', 'Password yang anda masukkan salah');
                    return redirect()->to(route_to('login_form'));
                }
            }
            $session->setFlashdata('error', 'Akun anda sudah tidak aktif');
        } elseif ($data_guru) {
            if ($data_guru['status'] == 'aktif') {
                $pass = $data_guru['password'];
                $verify_pass = password_verify($password, $pass);
                if ($verify_pass) {
                    $ses_data = [
                        'id'       => $data_guru['id'],
                        'nama'     => $data_guru['nama'],
                        'level'     => $data_guru['level'],
                        'email'    => $data_guru['email'],
                        'table'     => 'guru_kepsek',
                        'logged_in'     => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to(route_to('dashboard_index'));
                } else {
                    $session->setFlashdata('error', 'Password yang anda masukkan salah');
                    return redirect()->to(route_to('login_form'));
                }
            }
            $session->setFlashdata('error', 'Akun anda sudah tidak aktif');
        } elseif ($data_siswa) {
            if ($data_siswa['status'] == 'aktif') {
                $pass = $data_siswa['password'];
                $verify_pass = password_verify($password, $pass);
                if ($verify_pass) {
                    $ses_data = [
                        'id'       => $data_siswa['id'],
                        'nama'     => $data_siswa['nama'],
                        'level'     => 'siswa',
                        'email'    => $data_siswa['email'],
                        'table'     => 'siswa',
                        'logged_in'     => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to(route_to('dashboard_index'));
                } else {
                    $session->setFlashdata('error', 'Password yang anda masukkan salah');
                    return redirect()->to(route_to('login_form'));
                }
            }
            $session->setFlashdata('error', 'Akun anda sudah tidak aktif');
        } elseif ($data_ortu) {
            if ($data_ortu['status'] == 'aktif') {
                $pass = $data_ortu['password'];
                $verify_pass = password_verify($password, $pass);
                if ($verify_pass) {
                    $ses_data = [
                        'id'       => $data_ortu['id'],
                        'nama'     => $data_ortu['nama'],
                        'level'     => 'ortu',
                        'email'    => $data_ortu['email'],
                        'table'     => 'ortu',
                        'logged_in'     => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to(route_to('dashboard_index'));
                } else {
                    $session->setFlashdata('error', 'Password yang anda masukkan salah');
                    return redirect()->to(route_to('login_form'));
                }
            }
            $session->setFlashdata('error', 'Akun anda sudah tidak aktif');
        } else {
            $session->setFlashdata('error', 'Akun tidak ditemukan');
        }

        return redirect()->to(route_to('login_form'));
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(route_to('login_form'));
    }
}
