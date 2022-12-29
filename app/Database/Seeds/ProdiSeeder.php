<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdiSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('prodi');

        $builder->insertBatch([
            [
                'prodi_id' => '1',
                'nama_prodi' => 'Matematika',
                'jurusan_id' => '1',
                'jenjang_studi' => 'S1'
            ],
            [
                'prodi_id' => '2',
                'nama_prodi' => 'Matematika',
                'jurusan_id' => '1',
                'jenjang_studi' => 'S2'
            ],
            [
                'prodi_id' => '3',
                'nama_prodi' => 'Teknik Elektronika',
                'jurusan_id' => '2',
                'jenjang_studi' => 'D3'
            ],

            [
                'prodi_id' => '4',
                'nama_prodi' => 'Fisika',
                'jurusan_id' => '2',
                'jenjang_studi' => 'S1'
            ],
            [
                'prodi_id' => '5',
                'nama_prodi' => 'Fisika',
                'jurusan_id' => '2',
                'jenjang_studi' => 'S2'
            ],
            [
                'prodi_id' => '6',
                'nama_prodi' => 'Kimia',
                'jurusan_id' => '3',
                'jenjang_studi' => 'S1'
            ],
            [
                'prodi_id' => '7',
                'nama_prodi' => 'Kimia',
                'jurusan_id' => '3',
                'jenjang_studi' => 'S2'
            ],
            [
                'prodi_id' => '8',
                'nama_prodi' => 'Biologi',
                'jurusan_id' => '4',
                'jenjang_studi' => 'S1'
            ],
            [
                'prodi_id' => '9',
                'nama_prodi' => 'Biologi',
                'jurusan_id' => '4',
                'jenjang_studi' => 'S2'
            ],
            [
                'prodi_id' => '10',
                'nama_prodi' => 'Manajemen Informatika',
                'jurusan_id' => '5',
                'jenjang_studi' => 'D3'
            ],
            [
                'prodi_id' => '11',
                'nama_prodi' => 'Informatika',
                'jurusan_id' => '5',
                'jenjang_studi' => 'S1'
            ],
            [
                'prodi_id' => '12',
                'nama_prodi' => 'Kecerdasan Buatan',
                'jurusan_id' => '5',
                'jenjang_studi' => 'S2'
            ],
            [
                'prodi_id' => '13',
                'nama_prodi' => 'Farmasi',
                'jurusan_id' => '6',
                'jenjang_studi' => 'S1'
            ],
            [
                'prodi_id' => '14',
                'nama_prodi' => 'Statistika',
                'jurusan_id' => '7',
                'jenjang_studi' => 'S1'
            ],
        ]);
    }
}
