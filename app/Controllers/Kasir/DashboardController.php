<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\TransactionModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $tenantId      = session('tenant_id');
        $productModel  = new ProductModel();
        $transModel    = new TransactionModel();

        $today      = date('Y-m-d');
        $salesToday = $transModel->getSalesSummary($tenantId, $today, $today);

        $data = [
            'title'         => 'Dashboard Kasir',
            'low_stock'     => $productModel->getLowStockByTenant($tenantId),
            'low_stock_count' => $productModel->countLowStock($tenantId),
            'sales_today'   => $salesToday,
        ];

        return view('kasir/dashboard', $data);
    }
}
