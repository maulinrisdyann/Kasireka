<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\ProductModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $tenantId = session()->get('tenant_id');
        $model    = new TransactionModel();
        $prodModel = new ProductModel();

        $today    = date('Y-m-d');
        $weekFrom = date('Y-m-d', strtotime('-6 days'));
        $monthFrom = date('Y-m-01');

        $todaySales   = $model->getSalesSummary($tenantId, $today, $today);
        $weekSales    = $model->getSalesSummary($tenantId, $weekFrom, $today);
        $monthSales   = $model->getSalesSummary($tenantId, $monthFrom, $today);
        $topProducts  = $model->getTopProducts($tenantId, 5);
        $dailyData    = $model->getDailySales($tenantId, 7);
        $lowStockCount = $prodModel->countLowStock($tenantId);

        // Format data untuk Chart.js
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-{$i} days"));
            $chartLabels[] = date('d/m', strtotime($d));
            $found = array_filter($dailyData, fn($r) => $r['date'] === $d);
            $chartData[] = $found ? (float) array_values($found)[0]['total'] : 0;
        }

        return view('owner/dashboard', [
            'title'          => 'Dashboard Owner',
            'today_sales'    => $todaySales,
            'week_sales'     => $weekSales,
            'month_sales'    => $monthSales,
            'top_products'   => $topProducts,
            'low_stock_count'=> $lowStockCount,
            'chart_labels'   => json_encode($chartLabels),
            'chart_data'     => json_encode($chartData),
        ]);
    }
}
