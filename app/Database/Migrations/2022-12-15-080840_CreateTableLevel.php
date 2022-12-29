<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableLevel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'level_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama_level' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('level_id', true);
        $this->forge->createTable('level');

        $seeder = \Config\Database::seeder();
        $seeder->call('LevelSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('level');
    }
}
