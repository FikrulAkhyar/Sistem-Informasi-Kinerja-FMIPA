<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PimpinanSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('pimpinan');

        $builder->insertBatch([
            [
                'pimpinan_id' => 1,
                'nama_pimpinan' => 'Prof. Dr. Ir. Marwan',
                'nip' => '196612241992031003',
                'jabatan_id' => 1,
                'jurusan_id' => null,
            ],
            [
                'pimpinan_id' => 2,
                'nama_pimpinan' => 'Prof. Dr. Teuku Mohamad lqbalsyah, S.Si, M.Sc',
                'nip' => '196307251991021001',
                'jabatan_id' => 2,
                'jurusan_id' => null,
            ],
            [
                'pimpinan_id' => 3,
                'nama_pimpinan' => 'Nurmaulidar, S.Si., M.Sc',
                'nip' => '196307251991021001',
                'jabatan_id' => 3,
                'jurusan_id' => 1,
            ],
            [
                'pimpinan_id' => 4,
                'nama_pimpinan' => 'Dr. Mursal, S.Si., M.Si',
                'nip' => '197012201997021001',
                'jabatan_id' => 3,
                'jurusan_id' => 2,
            ],
            [
                'pimpinan_id' => 5,
                'nama_pimpinan' => 'Dr. Khairi, S.Si., M.Si.',
                'nip' => '196906141999031002',
                'jabatan_id' => 3,
                'jurusan_id' => 3,
            ],
            [
                'pimpinan_id' => 6,
                'nama_pimpinan' => 'Dr. Ir. Dahlan, S.Hut., M.Si., IPU',
                'nip' => '197610062006041003',
                'jabatan_id' => 3,
                'jurusan_id' => 4,
            ],
            [
                'pimpinan_id' => 7,
                'nama_pimpinan' => 'Viska Mutiawani, B.IT, M.IT',
                'nip' => '198008312009122003',
                'jabatan_id' => 3,
                'jurusan_id' => 5,
            ],
            [
                'pimpinan_id' => 8,
                'nama_pimpinan' => 'Lydia Septa Desiyana, S.Farm., M.Si.Apt',
                'nip' => '198109252008122002',
                'jabatan_id' => 3,
                'jurusan_id' => 6,
            ],
            [
                'pimpinan_id' => 9,
                'nama_pimpinan' => 'Dr. Zurnila Marli Kesuma, S.Si., M.Si',
                'nip' => '196903061994122001',
                'jabatan_id' => 3,
                'jurusan_id' => 7,
            ],
        ]);
    }
}
