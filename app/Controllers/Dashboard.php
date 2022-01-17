<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\GuruKepsekModel;
use App\Models\OrtuModel;
use App\Models\SiswaModel;


class Dashboard extends BaseController
{
    protected $user;
    protected $siswa;
    protected $admin;
    protected $guru;
    protected $ortu;

    public function __construct()
    {
        // $this->user = new UserModel();
    }

    public function index()
    {
        $data = [
            'count' => $this->getCoundData()
        ];

        return view('dashboard/index', $data);
    }

    private function getCoundData()
    {
        $this->siswa = new SiswaModel();
        $this->guru = new GuruKepsekModel();
        $this->ortu = new OrtuModel();
        $this->admin = new AdminModel();
        return [
            'siswa' => $this->siswa->countAllResults(),
            'guru' => $this->guru->where('level', 'guru')->countAllResults(),
            'ortu' => $this->ortu->countAllResults(),
            'admin' => $this->admin->countAllResults(),
        ];
    }

    public function show($aseg = null)
    {
        echo $aseg;
    }
}
