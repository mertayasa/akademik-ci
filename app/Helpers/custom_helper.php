<?php

if ( ! function_exists('isActive'))
{
    function isActive($param)
    {
        $current_url = explode('/', uri_string());

        if(is_array($param)){
            foreach($param as $par){
               if($current_url[0] == $par){
                   return 'active';
               } 
            }
        }else{
            return $current_url[0] == $param ? 'active' : '';
        }
    }
}
