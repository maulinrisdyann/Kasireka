<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'transaction_id' => ['type' => 'INT', 'unsigned' => true],
            'product_id'     => ['type' => 'INT', 'unsigned' => true],
            'product_name'   => ['type' => 'VARCHAR', 'constraint' => 150],
            'price'          => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'quantity'       => ['type' => 'INT'],
            'subtotal'       => ['type' => 'DECIMAL', 'constraint' => '12,2'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transaction_items');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_items');
    }
}
