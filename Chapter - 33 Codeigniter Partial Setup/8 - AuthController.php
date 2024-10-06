<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{


    public function forget_password()
    {
        return view('frontend/forget_password');
    }

}
