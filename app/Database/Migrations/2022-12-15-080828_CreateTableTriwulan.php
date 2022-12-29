<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTriwulan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'triwulan_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama_triwulan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'keterangan' => [
                'type'       => 'TEXT',
            ],
        ]);
        $this->forge->addKey('triwulan_id', true);
        $this->forge->createTable('triwulan');

        $seeder = \Config\Database::seeder();
        $seeder->call('TriwulanSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('triwulan');
    }
}
