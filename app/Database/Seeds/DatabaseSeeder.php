<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // 1. Admin super
        $this->db->table('users')->insert([
            'tenant_id'  => null,
            'name'       => 'Super Admin',
            'email'      => 'admin@kasirpos.com',
            'password'   => password_hash('admin123', PASSWORD_BCRYPT),
            'role'       => 'admin',
            'is_active'  => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Paket langganan demo
        $this->db->table('subscription_packages')->insert([
            'name'          => 'Paket Bulanan',
            'duration_days' => 30,
            'price'         => 99000,
            'description'   => 'Akses penuh selama 30 hari',
            'is_active'     => 1,
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);

        $this->db->table('subscription_packages')->insert([
            'name'          => 'Paket Tahunan',
            'duration_days' => 365,
            'price'         => 799000,
            'description'   => 'Akses penuh selama 1 tahun, hemat 33%',
            'is_active'     => 1,
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);

        // 3. Tenant demo
        $this->db->table('tenants')->insert([
            'name'                    => 'Toko Serbaguna Maju',
            'slug'                    => 'toko-maju',
            'email'                   => 'toko@maju.com',
            'phone'                   => '081234567890',
            'address'                 => 'Jl. Raya No. 1, Jakarta',
            'is_active'               => 1,
            'subscription_expires_at' => date('Y-m-d H:i:s', strtotime('+365 days')),
            'created_at'              => $now,
            'updated_at'              => $now,
        ]);

        $tenantId = $this->db->insertID();

        // 4. Owner tenant demo
        $this->db->table('users')->insert([
            'tenant_id'  => $tenantId,
            'name'       => 'Owner Toko Maju',
            'email'      => 'owner@maju.com',
            'password'   => password_hash('owner123', PASSWORD_BCRYPT),
            'role'       => 'owner',
            'is_active'  => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 5. Kasir tenant demo
        $this->db->table('users')->insert([
            'tenant_id'  => $tenantId,
            'name'       => 'Kasir Budi',
            'email'      => 'kasir@maju.com',
            'password'   => password_hash('kasir123', PASSWORD_BCRYPT),
            'role'       => 'kasir',
            'is_active'  => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

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
