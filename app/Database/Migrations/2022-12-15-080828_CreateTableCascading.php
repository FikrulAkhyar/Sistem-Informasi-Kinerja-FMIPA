<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCascading extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cascading_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama_cascading' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('cascading_id', true);
        $this->forge->createTable('cascading');

        $seeder = \Config\Database::seeder();
        $seeder->call('CascadingSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('cascading');
    }
}
