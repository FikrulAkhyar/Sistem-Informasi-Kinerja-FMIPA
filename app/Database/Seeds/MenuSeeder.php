<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('menu');

        $builder->insertBatch([
            [
                'menu_id' => '1',
                'nama_menu' => 'Indikator Kinerja',
                'url' => '/indikatorKinerja'
            ],
            [
                'menu_id' => '2',
                'nama_menu' => 'Capaian Fakultas',
                'url' => '/capaianFakultas'
            ],
            [
                'menu_id' => '3',
                'nama_menu' => 'Capaian Jurusan',
                'url' => '/capaianJurusan'
            ],
            [
                'menu_id' => '4',
                'nama_menu' => 'Kelola Level',
                'url' => '/level'
            ],
            [
                'menu_id' => '5',
                'nama_menu' => 'Kelola Pengguna',
                'url' => '/pengguna'
            ],
            [
                'menu_id' => '6',
                'nama_menu' => 'Kelola Sasaran',
                'url' => '/sasaran'
            ],
        ]);
    }
}
