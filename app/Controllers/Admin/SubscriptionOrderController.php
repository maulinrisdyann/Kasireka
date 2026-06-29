<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubscriptionOrderModel;
use App\Models\TenantModel;

class SubscriptionOrderController extends BaseController
{
    private SubscriptionOrderModel $model;

    public function __construct()
    {
        $this->model = new SubscriptionOrderModel();
    }

    public function index()
    {
        return view('admin/subscriptions/index', [
            'title'  => 'Order Langganan',
            'orders' => $this->model->getWithDetails(),
        ]);
    }

    public function verify(int $id)
    {
        $order = $this->model->find($id);
        if (!$order || $order['status'] !== 'pending') {
            return redirect()->to(base_url('admin/subscriptions'))->with('error', 'Order tidak valid.');
        }

        // Perpanjang subscription tenant
        $tenantModel = new TenantModel();
        $tenant      = $tenantModel->find($order['tenant_id']);

        // Ambil package untuk durasi
        $packageModel = new \App\Models\SubscriptionPackageModel();
        $package      = $packageModel->find($order['package_id']);

        $currentExpiry = $tenant['subscription_expires_at'] && strtotime($tenant['subscription_expires_at']) > time()
            ? $tenant['subscription_expires_at']
            : date('Y-m-d H:i:s');

        $newExpiry = date('Y-m-d H:i:s', strtotime($currentExpiry . ' +' . $package['duration_days'] . ' days'));

        $tenantModel->update($order['tenant_id'], [
            'is_active'               => 1,
            'subscription_expires_at' => $newExpiry,
        ]);

        $this->model->update($id, [
            'status'      => 'verified',
            'verified_by' => session('user_id'),
            'verified_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/subscriptions'))->with('success', 'Order diverifikasi. Langganan diperpanjang hingga ' . date('d/m/Y', strtotime($newExpiry)) . '.');
    }

    public function reject(int $id)
    {
        $order = $this->model->find($id);
        if (!$order || $order['status'] !== 'pending') {
            return redirect()->to(base_url('admin/subscriptions'))->with('error', 'Order tidak valid.');
        }

        $this->model->update($id, [
            'status'      => 'rejected',
            'notes'       => $this->request->getPost('notes'),
            'verified_by' => session('user_id'),
            'verified_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/subscriptions'))->with('success', 'Order ditolak.');
    }

    public function proof(int $id)
    {
        $order = $this->model->find($id);
        if (!$order || !$order['payment_proof']) {
            return redirect()->to(base_url('admin/subscriptions'))->with('error', 'Bukti pembayaran tidak ditemukan.');
        }

        // Cek di public/uploads (lokasi baru)
        $publicPath = FCPATH . 'uploads/payment_proofs/' . $order['payment_proof'];
        if (is_file($publicPath)) {
            return redirect()->to(base_url('uploads/payment_proofs/' . $order['payment_proof']));
        }

        // Fallback: cek di writable/uploads (lokasi lama)
        $writablePath = WRITEPATH . 'uploads/payment_proofs/' . $order['payment_proof'];
        if (is_file($writablePath)) {
            $mime = mime_content_type($writablePath);
            header('Content-Type: ' . $mime);
            header('Content-Disposition: inline; filename="' . basename($order['payment_proof']) . '"');
            readfile($writablePath);
            exit;
        }

        return redirect()->to(base_url('admin/subscriptions'))->with('error', 'File tidak ditemukan.');
    }
}
