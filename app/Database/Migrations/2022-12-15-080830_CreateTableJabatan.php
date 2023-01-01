<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableJabatan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'jabatan_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama_jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('jabatan_id', true);
        $this->forge->createTable('jabatan');

        $seeder = \Config\Database::seeder();
        $seeder->call('JabatanSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('jabatan');
    }
}
