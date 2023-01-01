<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('jabatan');

        $builder->insertBatch([
            [
                'jabatan_id' => '1',
                'nama_jabatan' => 'Rektor',
            ],
            [
                'jabatan_id' => '2',
                'nama_jabatan' => 'Dekan FMIPA',
            ],
            [
                'jabatan_id' => '3',
                'nama_jabatan' => 'Ketua Jurusan',
            ],
        ]);
    }
}
