<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableJurusan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'jurusan_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama_jurusan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('jurusan_id', true);
        $this->forge->createTable('jurusan');

        $seeder = \Config\Database::seeder();
        $seeder->call('JurusanSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('jurusan');
    }
}
