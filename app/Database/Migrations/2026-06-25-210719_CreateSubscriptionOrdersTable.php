<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubscriptionOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'     => ['type' => 'INT', 'unsigned' => true],
            'package_id'    => ['type' => 'INT', 'unsigned' => true],
            'amount'        => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'payment_proof' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['pending', 'verified', 'rejected'], 'default' => 'pending'],
            'notes'         => ['type' => 'TEXT', 'null' => true],
            'verified_by'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'verified_at'   => ['type' => 'DATETIME', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('package_id', 'subscription_packages', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('subscription_orders');
    }

    public function down()
    {
        $this->forge->dropTable('subscription_orders');
    }
}
