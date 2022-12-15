<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CascadingSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('cascading');

        $builder->insertBatch([
            [
                'cascading_id' => '1',
                'nama_cascading' => 'Wakil Dekan I',
            ],
            [
                'cascading_id' => '2',
                'nama_cascading' => 'Wakil Dekan II',
            ],
            [
                'cascading_id' => '3',
                'nama_cascading' => 'Wakil Direktur I PPS',
            ],
            [
                'cascading_id' => '4',
                'nama_cascading' => 'Wakil Direktur II PPS',
            ],
            [
                'cascading_id' => '5',
                'nama_cascading' => 'Ketua LP3M',
            ],
            [
                'cascading_id' => '6',
                'nama_cascading' => 'Ketua LP2M',
            ],
            [
                'cascading_id' => '7',
                'nama_cascading' => 'Semua Kepala UPT',
            ],
            [
                'cascading_id' => '8',
                'nama_cascading' => 'Kepala UPT TIK',
            ],
            [
                'cascading_id' => '9',
                'nama_cascading' => 'Kepala UPT Lab Terpadu',
            ],
            [
                'cascading_id' => '10',
                'nama_cascading' => 'Kepala UPT Perpustakaan',
            ],
            [
                'cascading_id' => '11',
                'nama_cascading' => 'Kepala UPT Kewirausahaan',
            ],
            [
                'cascading_id' => '12',
                'nama_cascading' => 'Kepala UPT Pusat Bahasa',
            ],
            [
                'cascading_id' => '13',
                'nama_cascading' => 'Kepala UPT Pusat Mitigasi Bencana',
            ],
            [
                'cascading_id' => '14',
                'nama_cascading' => 'Jurusan',
            ],
            [
                'cascading_id' => '15',
                'nama_cascading' => 'Prodi S1',
            ],
            [
                'cascading_id' => '16',
                'nama_cascading' => 'Prodi S2',
            ],
            [
                'cascading_id' => '17',
                'nama_cascading' => 'Prodi D3',
            ],

        ]);
    }
}
