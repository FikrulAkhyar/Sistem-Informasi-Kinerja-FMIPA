<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;

class IndikatorKinerja extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('indikatorkinerja/index');
    }

    public function create()
    {
        return view('indikatorkinerja/create');
    }

    public function edit()
    {
        return view('indikatorkinerja/edit');
    }

    public function datatable()
    {
    }

    public function modal_delete($id)
    {
        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->render('indikatorkinerja/components/modal_delete');
        return $this->respond($response, 200);
    }
}
