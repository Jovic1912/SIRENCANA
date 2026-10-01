<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'                 => ['type' => 'VARCHAR', 'constraint' => 150],
            'username'             => ['type' => 'VARCHAR', 'constraint' => 50],
            'password'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'                 => ['type' => 'VARCHAR', 'constraint' => 20],
            'dosen_id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'aktif'                => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'wajib_ganti_password' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'last_login'           => ['type' => 'DATETIME', 'null' => true],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addForeignKey('dosen_id', 'dosen', 'id', '', 'SET NULL');
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
