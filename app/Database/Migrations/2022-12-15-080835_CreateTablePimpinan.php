<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePimpinan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pimpinan_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama_pimpinan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'jabatan_id' => [
                'type'       => 'INT',
            ],
            'jurusan_id' => [
                'type'       => 'INT',
                'null' => true
            ],
        ]);
        $this->forge->addKey('pimpinan_id', true);
        $this->forge->addForeignKey('jabatan_id', 'jabatan', 'jabatan_id');
        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'jurusan_id');

        $this->forge->createTable('pimpinan');

        $seeder = \Config\Database::seeder();
        $seeder->call('PimpinanSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('pimpinan');
    }
}
