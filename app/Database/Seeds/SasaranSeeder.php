<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SasaranSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('sasaran');

        $builder->insertBatch([
            [
                'sasaran_id' => '1',
                'keterangan' => 'Tersedianya lulusan yang memiliki nilai-nilai religius, mandiri, sosial, beretika, berakhlak mulia, berkarakter dan mampu mengaplikasikan nilai-nilai Syiah Kuala dan terciptanya lulusan yang berjiwa entrepreneur, leadership, kreatif, inovatif, dan tangguh sehingga mampu bersaing pada level nasional dan global',
            ],
            [
                'sasaran_id' => '2',
                'keterangan' => 'Terwujudnya hasil-hasil penelitian dan pengabdian masyarakat yang inovatif, aplikatif dan berdampak langsung kepada masyarakat dalam rangka mendukung pembangunan daerah, nasional dan global',
            ],
            [
                'sasaran_id' => '3',
                'keterangan' => 'Terealisasi peningkatan kerjasama dengan berbagai institusi nasional dan global di bidang IPTEK, Humaniora, Olahraga dan Seni',
            ],
            [
                'sasaran_id' => '4',
                'keterangan' => 'Terwujudnya tata kelola manajemen pendidikan tinggi yang bermutu',
            ]
        ]);
    }
}
