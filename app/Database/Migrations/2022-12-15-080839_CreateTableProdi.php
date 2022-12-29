<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableProdi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'prodi_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama_prodi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'jurusan_id' => [
                'type'       => 'INT',
            ],
            'jenjang_studi' => [
                'type'       => 'VARCHAR',
                'constraint' => '2',
            ],
        ]);
        $this->forge->addKey('prodi_id', true);
        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'jurusan_id');

        $this->forge->createTable('prodi');

        $seeder = \Config\Database::seeder();
        $seeder->call('ProdiSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('prodi');
    }
}
