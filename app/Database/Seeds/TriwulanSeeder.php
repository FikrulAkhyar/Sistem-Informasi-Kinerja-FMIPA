<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TriwulanSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('triwulan');

        $builder->insertBatch([
            [
                'triwulan_id' => '1',
                'nama_triwulan' => 'Triwulan 1',
                'keterangan' => 'January,February,March'
            ],
            [
                'triwulan_id' => '2',
                'nama_triwulan' => 'Triwulan 2',
                'keterangan' => 'April,May,June'
            ],
            [
                'triwulan_id' => '3',
                'nama_triwulan' => 'Triwulan 3',
                'keterangan' => 'July,August,September'
            ],
            [
                'triwulan_id' => '4',
                'nama_triwulan' => 'Triwulan 4',
                'keterangan' => 'October,November,December'
            ],
        ]);
    }
}
