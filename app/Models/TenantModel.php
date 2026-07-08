<?php

namespace App\Models;

use CodeIgniter\Model;

class TenantModel extends Model
{
    protected $table      = 'tenants';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'is_active',
        'subscription_expires_at',
    ];
    protected $useTimestamps = true;

    public function isSubscriptionActive(int $tenantId): bool
    {
        $tenant = $this->find($tenantId);

        // Tenant tidak ditemukan
        if (!$tenant) {
            return false;
        }

        // Tenant dinonaktifkan oleh admin
        if ((int) $tenant['is_active'] !== 1) {
            return false;
        }

        // Tidak memiliki masa langganan
        if (empty($tenant['subscription_expires_at'])) {
            return false;
        }

        // Langganan sudah habis
        if (strtotime($tenant['subscription_expires_at']) <= time()) {
            return false;
        }

        return true;
    }
}
