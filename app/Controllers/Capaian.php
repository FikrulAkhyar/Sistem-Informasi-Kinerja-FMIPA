<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;

class Capaian extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('capaian/index');
    }

    public function modal_edit($id)
    {
        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->render('capaian/components/modal_edit');
        return $this->respond($response, 200);
    }
}
