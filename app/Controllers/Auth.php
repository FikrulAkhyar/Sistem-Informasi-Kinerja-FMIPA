<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;

class Auth extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        return view('auth/login');
    }
}
