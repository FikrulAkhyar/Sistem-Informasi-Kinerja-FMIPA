<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableIndikatorKinerja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ik_id' => [
                'type'       => 'INT',
                'auto_increment' => true
            ],
            'sasaran_id' => [
                'type'       => 'INT',
            ],
            'kode_ik' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'ket_fakultas' => [
                'type'       => 'TEXT',
                'null'      => true
            ],
            'ket_jurusan' => [
                'type'       => 'TEXT',
                'null'      => true
            ],
            'satuan_fakultas' => [
                'type'       => 'INT',
                'null'      => true
            ],
            'satuan_jurusan' => [
                'type'       => 'INT',
                'null'      => true
            ],
            'tahun' => [
                'type'       => 'INT'
            ],
            'target' => [
                'type'       => 'INT'
            ],
            'cascading_jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'      => true
            ],
            'cascading_fakultas' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'      => true
            ],
            'is_jurusan' => [
                'type'       => 'INT'
            ],
        ]);
        $this->forge->addKey('ik_id', true);
        $this->forge->addForeignKey('sasaran_id', 'sasaran', 'sasaran_id');
        $this->forge->addForeignKey('satuan_jurusan', 'satuan', 'satuan_id');
        $this->forge->addForeignKey('satuan_fakultas', 'satuan', 'satuan_id');

        $this->forge->createTable('indikator_kinerja');
    }

    public function down()
    {
        $this->forge->dropTable('indikator_kinerja');
    }
}
