<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'      => ['type' => 'INT', 'unsigned' => true],
            'kasir_id'       => ['type' => 'INT', 'unsigned' => true],
            'invoice_number' => ['type' => 'VARCHAR', 'constraint' => 50],
            'total_amount'   => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'payment_amount' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'change_amount'  => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'payment_method' => ['type' => 'ENUM', 'constraint' => ['cash', 'transfer'], 'default' => 'cash'],
            'note'           => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('invoice_number');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kasir_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
