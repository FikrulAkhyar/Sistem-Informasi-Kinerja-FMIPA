<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use Hermawan\DataTables\DataTable;

class Pengguna extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }
        return view('pengguna/index');
    }

    public function datatable()
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        $builder = $this->db->table('pengguna p')
            ->join('level l', 'l.level_id = p.level_id')
            ->join('jurusan j', 'j.jurusan_id = p.jurusan_id', 'left')
            ->select('
                p.pengguna_id,
                p.nama,
                p.username,
                p.jurusan_id,
                l.nama_level,
                j.nama_jurusan,
            ');

        return DataTable::of($builder)->toJson(TRUE);
    }

    public function modal_create()
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        $data['level'] = $this->db->table('level')->get()->getResultArray();
        $data['jurusan'] = $this->db->table('jurusan')->get()->getResultArray();
        $view = \Config\Services::renderer();
        $response['html'] = $view->setData($data)->render('pengguna/components/modal_create');
        return $this->respond($response, 200);
    }

    public function store()
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'level_id' => $this->request->getPost('level'),
        ];

        if ($data['level_id'] == 3) {
            $data['jurusan_id'] = $this->request->getPost('jurusan');
        }

        if ($this->db->table('pengguna')->insert($data) === FALSE) {
            $response = [
                'message' => 'Gagal menambahkan pengguna'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil menambahkan pengguna',
        ];

        return $this->respondCreated($response);
    }

    public function modal_edit($id)
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        $data['pengguna'] = $this->db->table('pengguna')->where('pengguna_id', $id)->get()->getRowArray();
        $data['level'] = $this->db->table('level')->get()->getResultArray();
        $data['jurusan'] = $this->db->table('jurusan')->get()->getResultArray();

        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->setData($data)
            ->render('pengguna/components/modal_edit');
        return $this->respond($response, 200);
    }

    public function update($id)
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'level_id' => $this->request->getPost('level'),
        ];

        if ($data['level_id'] == 3) {
            $data['jurusan_id'] = $this->request->getPost('jurusan');
        }

        if ($this->db->table('pengguna')->where('pengguna_id', $id)->update($data) === FALSE) {
            $response = [
                'message' => 'Gagal mengubah data pengguna'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil mengubah data pengguna',
        ];

        return $this->respond($response);
    }

    public function modal_delete($id)
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->render('pengguna/components/modal_delete');
        return $this->respond($response, 200);
    }

    public function delete($id)
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        if ($this->db->table('pengguna')->where('pengguna_id', $id)->delete() === FALSE) {
            $response = [
                'message' => 'Gagal menghapus pengguna'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil menghapus pengguna'
        ];

        return $this->respond($response);
    }

    public function modal_edit_password($id)
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)
            ->render('pengguna/components/modal_edit_password');
        return $this->respond($response, 200);
    }

    public function update_password($id)
    {
        if (session('level') != 1) {
            return redirect()->to('/');
        }

        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        if ($password != $confirm_password) {
            $response = [
                'message' => 'Konfirmasi password harus sama'
            ];
            return $this->respond($response, 422);
        }

        $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        if ($this->db->table('pengguna')->where('pengguna_id', $id)->update($data) === FALSE) {
            $response = [
                'message' => 'Gagal mengubah password pengguna'
            ];
            return $this->respond($response, 422);
        }

        $response = [
            'message' => 'Berhasil mengubah password pengguna',
        ];

        return $this->respond($response);
    }
}
