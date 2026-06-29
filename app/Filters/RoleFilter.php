<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\TenantModel;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek session login
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = session()->get('role');

        // Cek role sesuai dengan yang dibutuhkan
        if ($arguments && !in_array($userRole, $arguments)) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        // Cek status langganan untuk owner dan kasir
        if (in_array($userRole, ['owner', 'kasir'])) {
            $tenantId = session()->get('tenant_id');
            if ($tenantId) {
                $tenantModel = new TenantModel();
                if (!$tenantModel->isSubscriptionActive($tenantId)) {
                    session()->destroy();
                    return redirect()->to(base_url('login'))->with('error', 'Langganan Anda telah habis. Hubungi admin untuk perpanjang.');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
