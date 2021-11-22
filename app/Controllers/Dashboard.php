<?php

namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $user;
    
    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        $data = [
            'count' => $this->getCoundData()
        ];

        return view('dashboard/index', $data);
    }

    private function getCoundData(){
        return [
            'siswa' => $this->user->where('level', 'siswa')->countAllResults(),
            'guru' => $this->user->where('level', 'guru')->countAllResults(),
            'ortu' => $this->user->where('level', 'ortu')->countAllResults(),
            'admin' => $this->user->where('level', 'admin')->countAllResults(),
        ];
    }

    public function show($aseg = null)
    {
        echo $aseg;
    }
}
