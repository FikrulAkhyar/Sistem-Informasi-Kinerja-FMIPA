<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use Hermawan\DataTables\DataTable;

class Sasaran extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        if (!in_array('/sasaran', session('menu_akses'))) {
            return redirect()->to('/');
        }

        return view('sasaran/index');
    }

    public function datatable()
    {
        $builder = $this->db->table('sasaran s')
            ->join('indikator_kinerja ik', 'ik.sasaran_id = s.sasaran_id', 'left')
            ->select('
                s.sasaran_id,
                s.keterangan,
                COUNT(ik.sasaran_id) as jumlah_digunakan
            ')
            ->groupBy('s.sasaran_id');

        return DataTable::of($builder)->toJson(TRUE);
    }

    public function modal_create()
    {
        $view = \Config\Services::renderer();
        $response['html'] = $view->render('sasaran/components/modal_create');
        return $this->respond($response, 200);
    }

    public function store()
    {
        $data = [
            'keterangan' => $this->request->getPost('sasaran'),
        ];

        if ($this->db->table('sasaran')->insert($data) === FALSE) {
            $response = [
                'message' => 'Gagal menambahkan sasaran'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil menambahkan sasaran',
        ];

        return $this->respondCreated($response);
    }

    public function modal_edit($id)
    {
        $data['sasaran'] = $this->db->table('sasaran')->where('sasaran_id', $id)->get()->getRowArray();

        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->setData($data)
            ->render('sasaran/components/modal_edit');
        return $this->respond($response, 200);
    }

    public function update($id)
    {
        $data = [
            'keterangan' => $this->request->getPost('sasaran'),
        ];

        if ($this->db->table('sasaran')->where('sasaran_id', $id)->update($data) === FALSE) {
            $response = [
                'message' => 'Gagal mengubah data sasaran'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil mengubah data sasaran',
        ];

        return $this->respond($response);
    }

    public function modal_delete($id)
    {
        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->render('sasaran/components/modal_delete');
        return $this->respond($response, 200);
    }

    public function delete($id)
    {
        if ($this->db->table('sasaran')->where('sasaran_id', $id)->delete() === FALSE) {
            $response = [
                'message' => 'Gagal menghapus sasaran'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil menghapus sasaran'
        ];

        return $this->respond($response);
    }
}
