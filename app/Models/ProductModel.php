<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenant_id', 'category_id', 'name', 'barcode', 'price',
        'stock', 'stock_alert', 'unit', 'is_active',
    ];
    protected $useTimestamps = true;

    public function getLowStockByTenant(int $tenantId): array
    {
        return $this->where('tenant_id', $tenantId)
                    ->where('is_active', 1)
                    ->where('stock <=', $this->db->escapeIdentifiers('stock_alert'), false)
                    ->orderBy('stock', 'ASC')
                    ->findAll();
    }

    public function countLowStock(int $tenantId): int
    {
        return $this->where('tenant_id', $tenantId)
                    ->where('is_active', 1)
                    ->where('stock <=', $this->db->escapeIdentifiers('stock_alert'), false)
                    ->countAllResults();
    }

    public function findByBarcode(string $barcode, int $tenantId): ?array
    {
        return $this->where('tenant_id', $tenantId)
                    ->where('barcode', $barcode)
                    ->where('is_active', 1)
                    ->first();
    }

    public function getWithCategory(int $tenantId): array
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->where('products.tenant_id', $tenantId)
                    ->orderBy('products.name')
                    ->findAll();
    }

    public function generateBarcode(int $tenantId, int $productId): string
    {
        return $tenantId . '-' . $productId . '-' . time();
    }
}
