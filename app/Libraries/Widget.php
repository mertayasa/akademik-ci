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
}
