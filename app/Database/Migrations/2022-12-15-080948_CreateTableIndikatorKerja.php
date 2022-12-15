<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableIndikatorKerja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ik_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
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
            ],
            'ket_jurusan' => [
                'type'       => 'TEXT',
            ],
            'satuan_fakultas' => [
                'type'       => 'INT',
            ],
            'satuan_jurusan' => [
                'type'       => 'INT',
            ],
            'tahun' => [
                'type'       => 'INT',
            ],
            'target' => [
                'type'       => 'INT',
            ],
            'cascading_jurusan' => [
                'type'       => 'VARCHAR',
            ],
            'cascading_fakultas' => [
                'type'       => 'VARCHAR',
            ],
            'is_jurusan' => [
                'type'       => 'BOOLEAN',
            ],
        ]);
        $this->forge->addKey('ik_id', true);
        $this->forge->createTable('indikator_kerja');
    }

    public function down()
    {
        $this->forge->dropTable('indikator_kerja');
    }
}
