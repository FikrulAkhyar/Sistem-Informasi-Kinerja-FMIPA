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
            ],
            [
                'level_id' => '2',
                'nama_level' => 'Operator Fakultas MIPA',
            ],
            [
                'level_id' => '3',
                'nama_level' => 'Operator Jurusan',
            ],
        ]);
    }
}
