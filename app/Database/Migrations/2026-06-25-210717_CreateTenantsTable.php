<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTenantsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                      => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'                    => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'                    => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'                   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'phone'                   => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'address'                 => ['type' => 'TEXT', 'null' => true],
            'is_active'               => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'subscription_expires_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at'              => ['type' => 'DATETIME', 'null' => true],
            'updated_at'              => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('tenants');
    }

    public function down()
    {
        $this->forge->dropTable('tenants');
    }
}
