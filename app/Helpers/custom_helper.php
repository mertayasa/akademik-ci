<?php

use App\Models\AbsensiModel;
use App\Models\AnggotaKelasModel;
use App\Models\GuruKepsekModel;
use App\Models\NilaiModel;
use App\Models\TahunAjarModel;
use App\Models\WaliKelasModel;
use App\Models\KelasPerTahunModel;
use App\Models\PindahSekolahModel;
use App\Models\JadwalModel;

if (! function_exists('isActive')) {
    function isActive($param)
    {
        $current_url = explode('/', uri_string());
    
        if (is_array($param)) {
            foreach ($param as $par) {
                if ($current_url[0] == $par) {
                    return 'active';
                }
            }
        } else {
            return $current_url[0] === $param ? 'active' : '';
        }
    }

    function isActiveSub($param)
    {
        $current_url = explode('/', uri_string());

        if (is_array($param)) {
            foreach ($param as $par) {
                if (($current_url[1] ?? '-') == $param) {
                    return 'active';
                }
            }
        } else {
            return ($current_url[1] ?? '-') == $param ? 'active' : '';
        }
    }

    function getLevelName($level = null)
    {
        if ($level != null) {
            return ucwords(str_replace('_', ' ', $level));
        }
    }

    function isAdmin()
    {
        if (session()->get('level') == 'admin') {
            return true;
        }

        return false;
    }

    function isSiswa()
    {
        if (session()->get('level') == 'siswa') {
            return true;
        }

        return false;
    }

    function isGuru()
    {
        if (session()->get('level') == 'guru') {
            return true;
        }

        return false;
    }

    function isKepsek()
    {
        if (session()->get('level') == 'kepsek') {
            return true;
        }

        return false;
    }

    function isOrtu()
    {
        if (session()->get('level') == 'ortu') {
            return true;
        }

        return false;
    }

    function kepsekNotNull()
    {
        $guru_kepsek_model = new GuruKepsekModel;
        $active_kepsek = $guru_kepsek_model->where(['level' => 'kepsek', 'status' => 'aktif'])->countAllResults();
        
        return $active_kepsek > 0 ? true : false;
    }

    function checkPindahKeluar($id)
    {
        $pindah_sekolah = new PindahSekolahModel();
        $check_pindah = $pindah_sekolah->where([
            'id_siswa' => $id,
            'tipe' => 'keluar'
        ])->findAll();

        if (count($check_pindah) > 0) {
            return true;
        }

        return false;
    }

    function getIndonesianMonth($date)
    {
        $explode = explode('-', $date);
        $month = $explode[1];

        switch ($month) {
            case '1':
                $month = 'Januari';
                break;
            case '2':
                $month = 'Februari';
                break;
            case '3':
                $month = 'Maret';
                break;
            case '4':
                $month = 'April';
                break;
            case '5':
                $month = 'Mei';
                break;
            case '6':
                $month = 'Juni';
                break;
            case '7':
                $month = 'Juli';
                break;
            case '8':
                $month = 'Agustus';
                break;
            case '9':
                $month = 'September';
                break;
            case '10':
                $month = 'Oktober';
                break;
            case '11':
                $month = 'November';
                break;
            case '12':
                $month = 'Desember';
                break;
        }

        return $month . ' ' . $explode[0];
    }

    function getNamaSekolah()
    {
        return 'SD MUHAMMADIYAH 2 DENPASAR';
    }

    function getStatusGuru($status = null)
    {
        if ($status == null) {
            return [
                'tetap' => 'Tetap',
                'honorer' => 'Honorer',
                'bukan_guru' => 'Bukan Guru'
            ];
        }

        return ucfirst($status);
    }

    function convertRoman($number)
    {
        switch ($number) {
            case 1:
                return 'I';
                break;
            case 2:
                return 'II';
                break;
            case 3:
                return 'III';
                break;
            case 4:
                return 'IV';
                break;
            case 5:
                return 'V';
                break;
            case 6:
                return 'VI';
                break;
        }
    }

    function getHari()
    {
        return [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu',
        ];
    }

    function getKategoriPrestasi($kategori, $with_html = false)
    {
        if ($with_html) {
            switch ($kategori) {
                case 'guru':
                    return '<span class="badge badge-primary">' . ucfirst($kategori) . '</span>';
                    break;
                case 'siswa':
                    return '<span class="badge badge-info">' . ucfirst($kategori) . '</span>';
                    break;
                case 'pegawai':
                    return '<span class="badge badge-success">' . ucfirst($kategori) . '</span>';
                    break;
            }
        }
        return ucfirst($kategori);
    }

    function getTingkatPrestasi($tingkat, $with_html = false)
    {
        // "kec", "kab", "prov", "nas", "kota", "inter", "antar_sekolah"
        switch ($tingkat) {
            case 'kec':
                return $with_html ? '<span class="badge badge-warning">Kecamatan</span>' : 'Kecamatan';
                break;
            case 'kab':
                return $with_html ? '<span class="badge badge-info">Kabupaten</span>' : 'Kabupaten';
                break;
            case 'prov':
                return $with_html ? '<span class="badge badge-info">Provinsi</span>' : 'Provinsi';
                break;
            case 'nas':
                return $with_html ? '<span class="badge badge-success">Nasional</span>' : 'Nasional';
                break;
            case 'kota':
                return $with_html ? '<span class="badge badge-info">Kota</span>' : 'Kota';
                break;
            case 'inter':
                return $with_html ? '<span class="badge badge-success">Internasional</span>' : 'Internasional';
                break;
            case 'antar_sekolah':
                return $with_html ? '<span class="badge badge-warning">Antar Sekola</span>' : 'Antar Sekolah';
                break;
        }
    }

    function uploadFile($base_64_foto, $folder)
    {
        try {
            $foto = base64_decode($base_64_foto['data']);
            $folderName = 'images/' . $folder;

            $formatted_file_name = str_replace(' ', '-', $base_64_foto['name']);

            if (file_exists($folderName . '/' . $formatted_file_name)) {
                return 'images/' . $folder . '/' . $formatted_file_name;
            };

            if (!file_exists($folderName)) {
                mkdir($folderName, 0755, true);
            }

            $safeName = time() . $formatted_file_name;
            $inventoriePath =  $folderName;
            file_put_contents($inventoriePath . '/' . $safeName, $foto);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return 0;
        }

        return 'images/' . $folder . '/' . $safeName;
    }

    function getKelasBySiswa($id_siswa)
    {
        $anggota_kelas = new AnggotaKelasModel;
        $check_anggota = $anggota_kelas->where([
            'anggota_kelas.id_siswa' => $id_siswa,
        ])
            ->join('tahun_ajar', 'anggota_kelas.id_tahun_ajar = tahun_ajar.id')
            ->join('kelas', 'anggota_kelas.id_kelas = kelas.id')
            ->orderBy('kelas.jenjang', 'desc')
            ->findAll();

        return $check_anggota;
    }

    function checkWali($id_guru)
    {
        $tahun_ajar = new TahunAjarModel;
        $wali_kelas = new WaliKelasModel;

        $id_tahun_ajar = $tahun_ajar->getActiveId();
        $wali_kelas = $wali_kelas->where([
            'id_guru_wali' => $id_guru,
            'id_tahun_ajar' => $id_tahun_ajar
        ])
            ->join('tahun_ajar', 'wali_kelas.id_tahun_ajar = tahun_ajar.id')
            ->join('kelas', 'wali_kelas.id_kelas = kelas.id')
            ->orderBy('tahun_ajar.tahun_mulai', 'desc')
            ->findAll();

        return isset($wali_kelas[0]) ? $wali_kelas[0] : null;
    }

    function checkKelasByTahun($id_kelas, $id_tahun_ajar)
    {
        $kelas_per_tahun = new KelasPerTahunModel;
        $check_kelas = $kelas_per_tahun->where([
            'id_kelas' => $id_kelas,
            'id_tahun_ajar' => $id_tahun_ajar
        ])->findAll();

        return isset($check_kelas[0]) ? true : false;
    }

    function getAbsensiByDate($tgl, $id_anggota_kelas, $id_kelas, $semester)
    {
        $absensi = new AbsensiModel;
        $check_absensi = $absensi->where([
            'tanggal' => $tgl,
            'id_anggota_kelas' => $id_anggota_kelas,
            'id_kelas' => $id_kelas,
            'semester' => $semester,
        ])->findAll();

        return isset($check_absensi[0]) && ($check_absensi[0]['kehadiran'] != '' || $check_absensi[0]['kehadiran'] != null) ? getAbsenceCode($check_absensi[0]['kehadiran']) : '-';
    }

    function getStatusAnggota($id_kelas, $id_tahun_ajar, $id_siswa)
    {
        $anggota_kelas = new AnggotaKelasModel;
        $check_anggota = $anggota_kelas->where([
            'id_kelas' => $id_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'id_siswa' => $id_siswa,
        ])->findAll();

        log_message('error', json_encode($check_anggota[0]['status']));
        return $check_anggota[0]['status'];
    }

    function getAnggotaKelasId($id_kelas, $id_tahun_ajar, $id_siswa)
    {
        $anggota_kelas = new AnggotaKelasModel;
        $check_anggota = $anggota_kelas->where([
            'id_kelas' => $id_kelas,
            'id_tahun_ajar' => $id_tahun_ajar,
            'id_siswa' => $id_siswa,
        ])->findAll();

        log_message('error', json_encode($check_anggota[0]['id']));

        return $check_anggota[0]['id'];
    }

    function getAbsenceCode($kehadiran)
    {
        switch ($kehadiran) {
            case 'hadir':
                return 'H';
                break;
            case 'sakit':
                return 'S';
                break;
            case 'ijin':
                return 'I';
                break;
            case 'tanpa_keterangan':
                return 'A';
                break;
        }
    }
    function getNilaiByJadwal($id_kelas, $id_anggota_kelas, $semester, $id_mapel)
    {
        $nilai_model = new NilaiModel();
        return $nilai_model->select(
            'tugas, uts, uas, harian, nilai.id as id_nilai, nilai.id_kelas as id_kelas, nilai.id_anggota_kelas as id_anggota, nilai.id_mapel as id_mapel'
        )->where([
            'nilai.id_anggota_kelas' => $id_anggota_kelas,
            'nilai.semester' => $semester
        ])
            ->where('id_mapel', $id_mapel)
            ->orderBy('id', 'ASC')
            ->find();
    }
    function getKelasPerMapel($id_mapel)
    {
        $jadwal_model = new JadwalModel();

        $data = $jadwal_model
            ->select('id_mapel, id_kelas, jenjang, kode,id_tahun_ajar, tahun_ajar.status')
            ->join('kelas', 'jadwal.id_kelas=kelas.id')
            ->join('tahun_ajar', 'jadwal.id_tahun_ajar=tahun_ajar.id')
            ->where('jadwal.id_mapel', $id_mapel)
            ->where('tahun_ajar.status', 'aktif')
            ->groupBy(['jenjang', 'kode'])
            ->findAll();
        $kelas_per_mapel = array_map(function ($data) {
            return $data['jenjang'] . '' . $data['kode'];
        }, $data);
        return ($kelas_per_mapel != null or $kelas_per_mapel != "") ? implode(', ', $kelas_per_mapel) : '-';
    }
    function getUrlIndex()
    {
        $current_url = explode('/', uri_string());
        return $current_url[0];
    }

}