<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TenantModel;
use App\Models\UserModel;
use App\Models\SubscriptionOrderModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $tenantModel = new TenantModel();
        $orderModel  = new SubscriptionOrderModel();
        $userModel   = new UserModel();

        $data = [
            'title'           => 'Dashboard Admin',
            'total_tenants'   => $tenantModel->countAll(),
            'active_tenants'  => $tenantModel->where('is_active', 1)->countAllResults(),
            'pending_orders'  => $orderModel->getPendingCount(),
            'total_users'     => $userModel->countAll(),
            'recent_orders'   => $orderModel->getWithDetails(),
        ];

        return view('admin/dashboard', $data);
    }
}
