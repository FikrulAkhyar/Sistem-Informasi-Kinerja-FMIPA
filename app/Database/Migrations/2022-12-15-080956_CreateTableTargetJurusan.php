<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTargetJurusan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'target_jurusan_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'indikator_kinerja_id' => [
                'type'       => 'INT',
            ],
            'cascading_id' => [
                'type'       => 'INT',
            ],
            'jurusan_id' => [
                'type'       => 'INT',
            ],
            'triwulan_satu' => [
                'type'       => 'FLOAT',
            ],
            'triwulan_dua' => [
                'type'       => 'FLOAT',
            ],
            'triwulan_tiga' => [
                'type'       => 'FLOAT',
            ],
            'triwulan_empat' => [
                'type'       => 'FLOAT',
            ]
        ]);
        $this->forge->addKey('target_jurusan_id', true);
        $this->forge->addForeignKey('indikator_kinerja_id', 'indikator_kinerja', 'indikator_kinerja_id');
        $this->forge->addForeignKey('cascading_id', 'cascading', 'cascading_id');
        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'jurusan_id');

        $this->forge->createTable('target_jurusan');
    }

    public function down()
    {
        $this->forge->dropTable('target_jurusan');
    }
}
