<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableIndikatorKinerjaJurusan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ik_jurusan_id' => [
                'type'       => 'INT',
                'auto_increment' => true
            ],
            'indikator_kinerja_id' => [
                'type'       => 'INT',
            ],
            'jurusan_id' => [
                'type'       => 'INT',
            ],
            'satuan_id' => [
                'type'       => 'INT',
            ],
            'keterangan' => [
                'type'       => 'TEXT',
                'null'      => true
            ]
        ]);
        $this->forge->addKey('ik_jurusan_id', true);
        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'jurusan_id');
        $this->forge->addForeignKey('indikator_kinerja_id', 'indikator_kinerja', 'indikator_kinerja_id');
        $this->forge->addForeignKey('satuan_id', 'satuan', 'satuan_id');

        $this->forge->createTable('indikator_kinerja_jurusan');
    }

    public function down()
    {
        $this->forge->dropTable('indikator_kinerja_jurusan');
    }
}
