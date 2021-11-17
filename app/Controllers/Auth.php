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
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if($verify_pass){
                $ses_data = [
                    'id'       => $data['id'],
                    'nama'     => $data['nama'],
                    'email'    => $data['email'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to(route_to('dashboard_index'));
            }else{
                $session->setFlashdata('error', 'Wrong Password');
                return redirect()->to(route_to('login_form'));
            }
        }else{
            $session->setFlashdata('error', 'Email not Found');
            return redirect()->to(route_to('login_form'));
        }
    }
 
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(route_to('login_form'));
    }
}
