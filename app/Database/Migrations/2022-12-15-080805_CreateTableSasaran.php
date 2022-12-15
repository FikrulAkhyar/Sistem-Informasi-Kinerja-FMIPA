<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableSasaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sasaran_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'keterangan' => [
                'type'       => 'TEXT',
            ],
        ]);
        $this->forge->addKey('sasaran_id', true);
        $this->forge->createTable('sasaran');

        $seeder = \Config\Database::seeder();
        $seeder->call('SasaranSeeder');
    }

    public function down()
    {
        $this->forge->dropTable('sasaran');
    }
}
