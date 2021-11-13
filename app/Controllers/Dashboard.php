<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('dashboard/index');
    }

    public function show($aseg = null)
    {
        echo $aseg;
    }
}
