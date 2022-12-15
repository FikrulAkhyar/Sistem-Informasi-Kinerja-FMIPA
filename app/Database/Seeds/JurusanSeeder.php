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
            ],
            [
                'jurusan_id' => '2',
                'nama_jurusan' => 'Kimia',
            ],
            [
                'jurusan_id' => '3',
                'nama_jurusan' => 'Fisika',
            ],
            [
                'jurusan_id' => '4',
                'nama_jurusan' => 'Informatika',
            ],
            [
                'jurusan_id' => '5',
                'nama_jurusan' => 'Biologi',
            ],
            [
                'jurusan_id' => '6',
                'nama_jurusan' => 'Farmasi',
            ],
            [
                'jurusan_id' => '7',
                'nama_jurusan' => 'Statistika',
            ],
        ]);
    }
}
