<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('pengguna');

        $builder->insertBatch([
            [
                'pengguna_id' => '1',
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'level_id' => 1,
                'jurusan_id' => null
            ],
            [
                'pengguna_id' => '2',
                'nama' => 'Operator FMIPA',
                'username' => 'fmipa',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'level_id' => 2,
                'jurusan_id' => null
            ],
            [
                'pengguna_id' => '3',
                'nama' => 'Operator Informatika',
                'username' => 'informatika',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'level_id' => 3,
                'jurusan_id' => 5
            ],
        ]);
    }
}
