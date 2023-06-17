<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'menu_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama_menu' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('menu_id', true);
        $this->forge->createTable('menu');

        $seeder = \Config\Database::seeder();
        $seeder->call('MenuSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('menu');
    }
}
