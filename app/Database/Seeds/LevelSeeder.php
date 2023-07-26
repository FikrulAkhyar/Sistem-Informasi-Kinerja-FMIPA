<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('level');

        $builder->insertBatch([
            [
                'level_id' => '1',
                'nama_level' => 'Admin',
                'menu_akses' => 'Indikator Kinerja,Capaian Fakultas,Capaian Jurusan,Kelola Level,Kelola Pengguna,Kelola Sasaran'
            ],
            [
                'level_id' => '2',
                'nama_level' => 'Operator Fakultas',
                'menu_akses' => 'Capaian Fakultas,Capaian Jurusan'
            ],
            [
                'level_id' => '3',
                'nama_level' => 'Operator Jurusan',
                'menu_akses' => 'Capaian Jurusan'
            ],
            [
                'level_id' => '4',
                'nama_level' => 'Pimpinan',
                'menu_akses' => 'Capaian Jurusan,Capaian Fakultas'
            ],
            [
                'level_id' => '5',
                'nama_level' => 'Subbag Akademik',
                'menu_akses' => 'Capaian Jurusan,Capaian Fakultas'
            ],
            [
                'level_id' => '6',
                'nama_level' => 'Subbag Kemahasiswaan, Alumni, dan Kemitraan',
                'menu_akses' => 'Capaian Jurusan,Capaian Fakultas'
            ],
            [
                'level_id' => '7',
                'nama_level' => 'Subbag Keuangan dan Kepegawaian',
                'menu_akses' => 'Capaian Jurusan,Capaian Fakultas'
            ],
        ]);
    }
}
