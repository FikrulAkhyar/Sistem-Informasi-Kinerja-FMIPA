<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use Hermawan\DataTables\DataTable;

class Level extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        return view('level/index');
    }

    public function datatable()
    {
        $builder = $this->db->table('level l')
            ->join('pengguna p', 'p.level_id = l.level_id', 'left')
            ->select('
                l.level_id,
                l.nama_level,
                l.menu_akses,
                COUNT(p.level_id) as jumlah_pengguna
            ')
            ->groupBy('l.level_id');

        return DataTable::of($builder)->toJson(TRUE);
    }

    public function modal_create()
    {
        $data['menu'] = $this->db->table('menu')->get()->getResultArray();
        $view = \Config\Services::renderer();
        $response['html'] = $view->setData($data)->render('level/components/modal_create');
        return $this->respond($response, 200);
    }

    public function store()
    {
        $data = [
            'nama_level' => $this->request->getPost('nama_level'),
            'menu_akses' => implode(',', $this->request->getPost('menu_akses'))
        ];

        if ($this->db->table('level')->insert($data) === FALSE) {
            $response = [
                'message' => 'Gagal menambahkan level'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil menambahkan level',
        ];

        return $this->respondCreated($response);
    }

    public function modal_edit($id)
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        $data['level'] = $this->db->table('level')->where('level_id', $id)->get()->getRowArray();
        $data['level']['menu_akses'] = explode(',', $data['level']['menu_akses']);
        $data['menu'] = $this->db->table('menu')->get()->getResultArray();

        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->setData($data)
            ->render('level/components/modal_edit');
        return $this->respond($response, 200);
    }

    public function update($id)
    {
        $data = [
            'nama_level' => $this->request->getPost('nama_level'),
            'menu_akses' => implode(',', $this->request->getPost('menu_akses'))
        ];

        if ($this->db->table('level')->where('level_id', $id)->update($data) === FALSE) {
            $response = [
                'message' => 'Gagal mengubah data level'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil mengubah data level',
        ];

        return $this->respond($response);
    }

    public function modal_delete($id)
    {
        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->render('level/components/modal_delete');
        return $this->respond($response, 200);
    }

    public function delete($id)
    {
        if ($this->db->table('level')->where('level_id', $id)->delete() === FALSE) {
            $response = [
                'message' => 'Gagal menghapus level'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil menghapus level'
        ];

        return $this->respond($response);
    }
}
