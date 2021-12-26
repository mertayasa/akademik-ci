<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function show()
    {
        $id = session()->get('id');
        $level = session()->get('level');
        $user = $this->user->getData($id);
        
        $data = [
            'user' => $user,
            'include_form' => 'profile/form/'.$level
        ];

        return view('profile/edit', $data);
    }

    public function update()
    {
        
    }
}
