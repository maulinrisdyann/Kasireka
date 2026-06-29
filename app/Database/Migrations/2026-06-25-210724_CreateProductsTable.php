<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tenant_id'   => ['type' => 'INT', 'unsigned' => true],
            'category_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'barcode'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'price'       => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'stock'       => ['type' => 'INT', 'default' => 0],
            'stock_alert' => ['type' => 'INT', 'default' => 5],
            'unit'        => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'pcs'],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('barcode');
        $this->forge->addForeignKey('tenant_id', 'tenants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
