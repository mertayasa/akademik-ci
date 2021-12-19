<?php

if ( ! function_exists('isActive'))
{
    function isActive($param)
    {
        $current_url = explode('/', uri_string());
        // dd($current_url);

        if(is_array($param)){
            foreach($param as $par){
               if($current_url[0] == $par || ($current_url[1] ?? '-') == $param){
                   return 'active';
               } 
            }
        }else{
            return $current_url[0] === $param || ($current_url[1] ?? '-') === $param ? 'active' : '';
        }
    }

    function getLevelName($level = null)
    {
        if($level != null){
            return ucwords(str_replace('_', ' ', $level));
        }
    }

    function getStatusGuru($status = null)
    {
        if($status == null){
            return [
                'tetap' => 'Tetap',
                'honorer' => 'Honorer'
            ];
        }

        return ucfirst($status);
    }

    function convertRoman($number)
    {
        switch($number){
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
                return 'IV';
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
        if($with_html){
            switch($kategori){
                case 'guru':
                    return '<span class="badge badge-primary">'. ucfirst($kategori) .'</span>';
                break;
                case 'siswa':
                    return '<span class="badge badge-info">'. ucfirst($kategori) .'</span>';
                break;
                case 'pegawai':
                    return '<span class="badge badge-success">'. ucfirst($kategori) .'</span>';
                break;
            }
        }
        return ucfirst($kategori);
    }

    function getTingkatPrestasi($tingkat, $with_html = false)
    {
        // "kec", "kab", "prov", "nas", "kota", "inter", "antar_sekolah"
        switch($tingkat){
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
}
