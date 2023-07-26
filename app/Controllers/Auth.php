<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use \Config\Database;

class Auth extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function login()
    {
        $method = $this->request->getServer('REQUEST_METHOD');
        if ($method === 'GET') {
            if (session('isLoggedIn') == TRUE) {
                return redirect()->to('/');
            }

            return view('auth/login');
        } else if ($method === 'POST') {
            $data = [
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password')
            ];

            if (!$this->validate([
                'username' => [
                    'rules' => 'required',
                ],
                'password' => [
                    'rules' => 'required',
                ]
            ])) {
                $response = ['message' => 'Tidak boleh kosong'];
                return $this->respond($response, 422);
            }

            $pengguna = $this->db->table('pengguna')->where('username', $data['username'])->get()->getRowArray();
            if (!$pengguna) {
                $response = ['message' => 'Pengguna belum terdaftar'];
                return $this->respond($response, 422);
            }

            if (!password_verify($data['password'], $pengguna['password'])) {
                $response = ['message' => 'Password Salah'];
                return $this->respond($response, 422);
            }

            $level = $this->db->table('level')->where('level_id', $pengguna['level_id'])->get()->getRowArray();
            $menu_akses = explode(',', $level['menu_akses']);
            $url_akses = [];
            for ($i=0; $i < count($menu_akses); $i++) { 
                $menu = $this->db->table('menu')->where('nama_menu', $menu_akses[$i])->get()->getRowArray();
                array_push($url_akses, $menu['url']);
            }

            session()->set([
                'isLoggedIn' => TRUE,
                'username' => $pengguna['username'],
                'nama' => $pengguna['nama'],
                'pengguna_id' => $pengguna['pengguna_id'],
                'level' => $pengguna['level_id'],
                'jurusan' => $pengguna['jurusan_id'],
                'menu_akses' => $url_akses
            ]);

            $response = [
                'message' => 'Berhasil Login',
            ];
            return $this->respond($response, 200);
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/auth/login');
    }
}
