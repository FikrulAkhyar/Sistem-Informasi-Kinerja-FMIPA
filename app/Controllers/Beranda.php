<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;

class Beranda extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('beranda/index');
    }
}
