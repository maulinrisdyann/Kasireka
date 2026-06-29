<?php

namespace App\Models;

use CodeIgniter\Model;

class TenantModel extends Model
{
    protected $table      = 'tenants';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'slug', 'email', 'phone', 'address',
        'is_active', 'subscription_expires_at',
    ];
    protected $useTimestamps = true;

    public function isSubscriptionActive(int $tenantId): bool
    {
        $tenant = $this->find($tenantId);
        if (!$tenant) return false;
        if (!$tenant['subscription_expires_at']) return false;
        return strtotime($tenant['subscription_expires_at']) > time();
    }
}
