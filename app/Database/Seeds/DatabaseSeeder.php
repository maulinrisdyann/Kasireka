<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        
        // 6. Kategori demo
        $categories = ['Minuman', 'Makanan', 'Sembako', 'Alat Tulis', 'Elektronik'];
        $catIds = [];
        foreach ($categories as $cat) {
            $this->db->table('categories')->insert([
                'tenant_id'  => $tenantId,
                'name'       => $cat,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $catIds[$cat] = $this->db->insertID();
        }

        // 7. Produk demo (termasuk beberapa yang stok menipis)
        $kasirId = $this->db->table('users')->where('email', 'kasir@maju.com')->get()->getRow()->id;
        $products = [
            ['name' => 'Aqua 600ml', 'cat' => 'Minuman', 'price' => 3500, 'stock' => 50, 'stock_alert' => 10, 'unit' => 'botol'],
            ['name' => 'Teh Botol 350ml', 'cat' => 'Minuman', 'price' => 5000, 'stock' => 30, 'stock_alert' => 10, 'unit' => 'botol'],
            ['name' => 'Indomie Goreng', 'cat' => 'Makanan', 'price' => 3000, 'stock' => 4, 'stock_alert' => 10, 'unit' => 'pcs'],
            ['name' => 'Beras 5kg', 'cat' => 'Sembako', 'price' => 65000, 'stock' => 3, 'stock_alert' => 5, 'unit' => 'karung'],
            ['name' => 'Minyak Goreng 1L', 'cat' => 'Sembako', 'price' => 18000, 'stock' => 2, 'stock_alert' => 5, 'unit' => 'botol'],
            ['name' => 'Pulpen Pilot', 'cat' => 'Alat Tulis', 'price' => 5000, 'stock' => 25, 'stock_alert' => 5, 'unit' => 'pcs'],
            ['name' => 'Buku Tulis 38 lembar', 'cat' => 'Alat Tulis', 'price' => 4500, 'stock' => 40, 'stock_alert' => 10, 'unit' => 'pcs'],
            ['name' => 'Baterai AA Energizer', 'cat' => 'Elektronik', 'price' => 12000, 'stock' => 0, 'stock_alert' => 5, 'unit' => 'pack'],
        ];

        foreach ($products as $p) {
            $barcode = $tenantId . '-' . time() . '-' . rand(100, 999);
            $this->db->table('products')->insert([
                'tenant_id'   => $tenantId,
                'category_id' => $catIds[$p['cat']],
                'name'        => $p['name'],
                'barcode'     => $barcode,
                'price'       => $p['price'],
                'stock'       => $p['stock'],
                'stock_alert' => $p['stock_alert'],
                'unit'        => $p['unit'],
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
            usleep(1000); // ensure unique barcode timestamp
        }
    }
}
