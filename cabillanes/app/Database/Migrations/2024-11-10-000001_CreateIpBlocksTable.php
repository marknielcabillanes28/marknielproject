<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIpBlocksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'from_ip' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
            ],
            'to_ip' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
            ],
            'reason' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ip_blocks');
    }

    public function down()
    {
        $this->forge->dropTable('ip_blocks');
    }
}
