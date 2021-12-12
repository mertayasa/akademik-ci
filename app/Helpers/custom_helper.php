<?php

if ( ! function_exists('isActive'))
{
    function isActive($param)
    {
        $current_url = explode('/', uri_string());

        if(is_array($param)){
            foreach($param as $par){
               if($current_url[0] == $par || ($current_url[1] ?? '-') == $param){
                   return 'active';
               } 
            }
        }else{
            return $current_url[0] == $param || ($current_url[1] ?? '-') == $param ? 'active' : '';
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
}
