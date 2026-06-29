<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class StockController extends BaseController
{
    public function index()
    {
        $tenantId = session('tenant_id');
        $model    = new ProductModel();

        $products = $model->select('products.*, categories.name as category_name')
                          ->join('categories', 'categories.id = products.category_id', 'left')
                          ->where('products.tenant_id', $tenantId)
                          ->orderBy('products.stock', 'ASC')
                          ->findAll();

        return view('kasir/stock/index', [
            'title'    => 'Monitoring Stok',
            'products' => $products,
        ]);
    }
}
