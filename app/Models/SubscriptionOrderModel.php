<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionOrderModel extends Model
{
    protected $table      = 'subscription_orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenant_id', 'package_id', 'amount', 'payment_proof',
        'status', 'notes', 'verified_by', 'verified_at',
    ];
    protected $useTimestamps = true;

    public function getPendingCount(): int
    {
        return $this->where('status', 'pending')->countAllResults();
    }

    public function getWithDetails(): array
    {
        return $this->db->table('subscription_orders so')
                        ->select('so.*, t.name as tenant_name, sp.name as package_name, sp.duration_days, u.name as verified_by_name')
                        ->join('tenants t', 't.id = so.tenant_id')
                        ->join('subscription_packages sp', 'sp.id = so.package_id')
                        ->join('users u', 'u.id = so.verified_by', 'left')
                        ->orderBy('so.created_at', 'DESC')
                        ->get()
                        ->getResultArray();
    }
}
