<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if(session()->get('logged_in')){
            return redirect()->to(route_to('dashboard_index'));
        }

        helper(['form']);
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->where('email', $email)->first();
        if($data){
            if($data['status'] == 'aktif'){
                $pass = $data['password'];
                $verify_pass = password_verify($password, $pass);
                if($verify_pass){
                    $ses_data = [
                        'id'       => $data['id'],
                        'nama'     => $data['nama'],
                        'level'     => $data['level'],
                        'email'    => $data['email'],
                        'logged_in'     => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to(route_to('dashboard_index'));
                }else{
                    $session->setFlashdata('error', 'Password yang anda masukkan salah');
                    return redirect()->to(route_to('login_form'));
                }
            }

            $session->setFlashdata('error', 'Akun anda sudah tidak aktif');
        }else{
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
