<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenant_id', 'kasir_id', 'invoice_number', 'total_amount',
        'payment_amount', 'change_amount', 'payment_method', 'note',
    ];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    public function generateInvoiceNumber(int $tenantId): string
    {
        $date     = date('Ymd');
        $prefix   = 'INV-' . $tenantId . '-' . $date . '-';
        $lastInv  = $this->db->table('transactions')
                             ->like('invoice_number', $prefix, 'after')
                             ->orderBy('id', 'DESC')
                             ->limit(1)
                             ->get()
                             ->getRow();
        $seq = 1;
        if ($lastInv) {
            $parts = explode('-', $lastInv->invoice_number);
            $seq   = (int) end($parts) + 1;
        }
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public function getSalesSummary(int $tenantId, string $dateFrom, string $dateTo): array
    {
        return $this->db->table('transactions')
                        ->select('COUNT(id) as total_trx, SUM(total_amount) as total_revenue')
                        ->where('tenant_id', $tenantId)
                        ->where('DATE(created_at) >=', $dateFrom)
                        ->where('DATE(created_at) <=', $dateTo)
                        ->get()
                        ->getRowArray();
    }

    public function getTopProducts(int $tenantId, int $limit = 5): array
    {
        return $this->db->table('transaction_items ti')
                        ->select('ti.product_name, SUM(ti.quantity) as total_qty, SUM(ti.subtotal) as total_revenue')
                        ->join('transactions t', 't.id = ti.transaction_id')
                        ->where('t.tenant_id', $tenantId)
                        ->groupBy('ti.product_id, ti.product_name')
                        ->orderBy('total_qty', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->getResultArray();
    }

    public function getDailySales(int $tenantId, int $days = 7): array
    {
        return $this->db->table('transactions')
                        ->select('DATE(created_at) as date, SUM(total_amount) as total')
                        ->where('tenant_id', $tenantId)
                        ->where('created_at >=', date('Y-m-d', strtotime("-{$days} days")))
                        ->groupBy('DATE(created_at)')
                        ->orderBy('date', 'ASC')
                        ->get()
                        ->getResultArray();
    }
}
