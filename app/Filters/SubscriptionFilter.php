<?php

namespace App\Filters;

use App\Models\TenantModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SubscriptionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $tenantId = session()->get('tenant_id');

        if (!$tenantId) {
            return;
        }

        $tenantModel = new TenantModel();

        if (!$tenantModel->isSubscriptionActive($tenantId)) {
            return redirect()->back()->with(
                'error',
                'Langganan owner telah habis. Transaksi tidak dapat dilakukan.'
            );
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}