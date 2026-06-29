<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tenant_id', 'name'];
    protected $useTimestamps = true;

    public function getByTenant(int $tenantId): array
    {
        return $this->where('tenant_id', $tenantId)->orderBy('name')->findAll();
    }
}
