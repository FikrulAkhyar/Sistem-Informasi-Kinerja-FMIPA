<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableIndikatorKinerja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'indikator_kinerja_id' => [
                'type'       => 'INT',
                'auto_increment' => true
            ],
            'sasaran_id' => [
                'type'       => 'INT',
            ],
            'kode_indikator_kinerja' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'keterangan' => [
                'type'       => 'TEXT',
                'null'      => true
            ],
            'satuan_id' => [
                'type'       => 'INT',
            ],
            'tahun' => [
                'type'       => 'INT'
            ],
            'cascading' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'      => true
            ]
        ]);
        $this->forge->addKey('indikator_kinerja_id', true);
        $this->forge->addForeignKey('sasaran_id', 'sasaran', 'sasaran_id');
        $this->forge->addForeignKey('satuan_id', 'satuan', 'satuan_id');

        $this->forge->createTable('indikator_kinerja');
    }

    public function down()
    {
        $this->forge->dropTable('indikator_kinerja');
    }
}
