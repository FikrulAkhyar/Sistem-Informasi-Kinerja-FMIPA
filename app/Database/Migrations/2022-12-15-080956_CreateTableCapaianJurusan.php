<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableCapaianJurusan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'capaian_jurusan_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'indikator_kinerja_id' => [
                'type'       => 'INT',
            ],
            'cascading_id' => [
                'type'       => 'INT',
            ],
            'uraian' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'capaian' => [
                'type'       => 'FLOAT',
                'default'    => '0'
            ],
            'pembagi' => [
                'type'       => 'FLOAT',
                'default'       => '0'
            ],
            'hasil' => [
                'type'       => 'FLOAT',
                'default'       => '0'
            ],
            'triwulan_id' => [
                'type'       => 'INT',
            ],
            'jurusan_id' => [
                'type'       => 'INT',
            ],
            'file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('capaian_jurusan_id', true);
        $this->forge->addForeignKey('indikator_kinerja_id', 'indikator_kinerja', 'indikator_kinerja_id');
        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'jurusan_id');
        $this->forge->addForeignKey('triwulan_id', 'triwulan', 'triwulan_id');
        $this->forge->addForeignKey('cascading_id', 'cascading', 'cascading_id');

        $this->forge->createTable('capaian_jurusan');
    }

    public function down()
    {
        $this->forge->dropTable('capaian_jurusan');
    }
}
