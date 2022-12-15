<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableSatuan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'satuan_id' => [
                'type'       => 'INT',
                'auto_increment' => true,
            ],
            'nama_satuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('satuan_id', true);
        $this->forge->createTable('satuan');
    }

    public function down()
    {
        $this->forge->dropTable('satuan');
    }
}
