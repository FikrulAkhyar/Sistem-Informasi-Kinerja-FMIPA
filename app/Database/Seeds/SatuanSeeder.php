<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SatuanSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('satuan');

        $builder->insertBatch([
            [
                'satuan_id' => '1',
                'nama_satuan' => 'Persentase (%)',
            ],
            [
                'satuan_id' => '2',
                'nama_satuan' => 'Jumlah',
            ],
            [
                'satuan_id' => '3',
                'nama_satuan' => 'Nilai',
            ],
            [
                'satuan_id' => '4',
                'nama_satuan' => 'Tahun',
            ],
            [
                'satuan_id' => '5',
                'nama_satuan' => 'Lab',
            ],
            [
                'satuan_id' => '6',
                'nama_satuan' => 'Ranking',
            ],
            [
                'satuan_id' => '7',
                'nama_satuan' => 'Pusat Unggulan Iptek (PUI)',
            ],
            [
                'satuan_id' => '8',
                'nama_satuan' => 'Jumlah Dosen',
            ],
            [
                'satuan_id' => '9',
                'nama_satuan' => 'Jurnal',
            ],
            [
                'satuan_id' => '10',
                'nama_satuan' => 'Sitasi',
            ],
            [
                'satuan_id' => '11',
                'nama_satuan' => 'Produk',
            ],
            [
                'satuan_id' => '12',
                'nama_satuan' => 'Buah',
            ],
            [
                'satuan_id' => '13',
                'nama_satuan' => 'Orang',
            ],
            [
                'satuan_id' => '14',
                'nama_satuan' => 'Mahasiswa',
            ],
            [
                'satuan_id' => '15',
                'nama_satuan' => 'Kegiatan',
            ],
        ]);
    }
}
