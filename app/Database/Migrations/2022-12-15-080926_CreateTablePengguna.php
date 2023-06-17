<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePengguna extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pengguna_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'level_id' => [
                'type'       => 'INT',
            ],
            'jurusan_id' => [
                'type'       => 'INT',
                'null'      => true
            ],
        ]);
        $this->forge->addKey('pengguna_id', true);
        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'jurusan_id');
        $this->forge->addForeignKey('level_id', 'level', 'level_id');
        $this->forge->createTable('pengguna');

        $seeder = \Config\Database::seeder();
        $seeder->call('PenggunaSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('pengguna');
    }
}
