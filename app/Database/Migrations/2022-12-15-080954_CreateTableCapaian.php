<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCapaian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'capaian_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'ik_id' => [
                'type'       => 'INT',
            ],
            'triwulan_satu' => [
                'type'       => 'INT',
            ],
            'triwulan_dua' => [
                'type'       => 'INT',
            ],
            'triwulan_tiga' => [
                'type'       => 'INT',
            ],
            'triwulan_empat' => [
                'type'       => 'INT',
            ],
            'jurusan_id' => [
                'type'       => 'INT',
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('capaian_id', true);
        $this->forge->createTable('capaian');
    }

    public function down()
    {
        $this->forge->dropTable('capaian');
    }
}
