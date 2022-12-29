<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('jurusan');

        $builder->insertBatch([
            [
                'jurusan_id' => '1',
                'nama_jurusan' => 'Matematika',
                'fakultas' => 'MIPA',
            ],
            [
                'jurusan_id' => '2',
                'nama_jurusan' => 'Fisika',
                'fakultas' => 'MIPA',
            ],
            [
                'jurusan_id' => '3',
                'nama_jurusan' => 'Kimia',
                'fakultas' => 'MIPA',
            ],
            [
                'jurusan_id' => '4',
                'nama_jurusan' => 'Biologi',
                'fakultas' => 'MIPA',
            ],
            [
                'jurusan_id' => '5',
                'nama_jurusan' => 'Informatika',
                'fakultas' => 'MIPA',
            ],
            [
                'jurusan_id' => '6',
                'nama_jurusan' => 'Farmasi',
                'fakultas' => 'MIPA',
            ],
            [
                'jurusan_id' => '7',
                'nama_jurusan' => 'Statistika',
                'fakultas' => 'MIPA',
            ],
        ]);
    }
}
