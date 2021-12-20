<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TinyUpload extends BaseController
{
    public function upload()
    {
        $destinationPathImage = 'images/uploaded';
        $file = $this->request->getFile('file');

        $extension = $file->getClientExtension();
        // $filename = $file->getClientName();

        $newName = $file->getRandomName();
        $validextensions = array("jpeg","jpg","png");

        if(in_array(strtolower($extension), $validextensions)){
            $file->move($destinationPathImage, $newName);
            // $file->move(WRITEPATH.'uploads', $newName);
            return json_encode(['location' => base_url('images/uploaded/'.$newName)], JSON_UNESCAPED_SLASHES);
        }else{
            return json_encode(["Gagal mengupload gambar"]);
        }
    }
}
