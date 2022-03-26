<?php

namespace App\Libraries;

class Widget
{
    public function tabSiswa(array $param)
    {
        return view('panel_wali/table_siswa', $param);
    }
    public function tabJadwal(array $param)
    {
        return view('panel_wali/jadwal', $param);
    }
    public function tabAbsen(array $param)
    {
        return view('panel_wali/absen', $param);
    }
    public function listSiswa(array $param)
    {
        return view('profile/card-profile', $param);
    }
}
