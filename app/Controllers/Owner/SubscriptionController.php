<?php
namespace App\Controllers\Owner;
use App\Controllers\BaseController;
use App\Models\SubscriptionPackageModel;
use App\Models\SubscriptionOrderModel;
use App\Models\TenantModel;
use App\Models\PaymentAccountModel;
class SubscriptionController extends BaseController
{
    public function index()
    {
        $tenantId     = session('tenant_id');
        $packageModel = new SubscriptionPackageModel();
        $orderModel   = new SubscriptionOrderModel();
        $tenantModel  = new TenantModel();
        $paymentModel = new PaymentAccountModel();
        $orders = $orderModel
            ->where('subscription_orders.tenant_id', $tenantId)
            ->select('subscription_orders.*, 
                subscription_packages.name as package_name,
                subscription_packages.duration_days')
            ->join(
                'subscription_packages',
                'subscription_packages.id = subscription_orders.package_id'
            )
            ->orderBy('subscription_orders.created_at', 'DESC')
            ->findAll();
        return view('owner/subscription', [
            'title' => 'Langganan',
            'packages' =>
            $packageModel
                ->where('is_active', 1)
                ->orderBy('price')
                ->findAll(),
            'orders' => $orders,
            'tenant' => $tenantModel->find($tenantId),
            // tambahan rekening
            'payment_accounts' =>
            $paymentModel
                ->where('is_active', 1)
                ->findAll()
        ]);
    }
    public function order()
    {
        $tenantId = session('tenant_id');
        if (!$this->validate([
            'package_id' => 'required|integer',
            'payment_account' => 'required'
        ])) {
            return redirect()->back()
                ->with('error', 'Pilih paket dan rekening pembayaran.');
        }
        $packageModel = new SubscriptionPackageModel();
        $package = $packageModel
            ->find(
                $this->request->getPost('package_id')
            );
        if (!$package || !$package['is_active']) {
            return redirect()->back()
                ->with('error', 'Paket tidak valid.');
        }
        // upload bukti
        $file = $this->request->getFile('payment_proof');
        $proofPath = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $allowedMime = [
                'image/jpeg',
                'image/png',
                'application/pdf'
            ];
            $allowedExt = [
                'jpg',
                'jpeg',
                'png',
                'pdf'
            ];
            $ext = strtolower(
                $file->getClientExtension()
            );
            if (
                !in_array($file->getMimeType(), $allowedMime)
                &&
                !in_array($ext, $allowedExt)
            ) {
                return redirect()->back()
                    ->with('error', 'Format file tidak valid.');
            }
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()
                    ->with('error', 'File maksimal 2MB.');
            }
            $uploadDir =
                FCPATH . 'uploads/payment_proofs/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $newName =
                uniqid('proof_', true)
                . '.' . $ext;
            $file->move(
                $uploadDir,
                $newName
            );
            $proofPath = $newName;
        }
        $orderModel = new SubscriptionOrderModel();
        $orderModel->insert([
            'tenant_id' => $tenantId,
            'package_id' => $package['id'],
            'amount' => $package['price'],
            // rekening tujuan
            'payment_account_id' =>
            $this->request->getPost('payment_account'),
            'payment_proof' => $proofPath,
            'status' => 'pending'
        ]);
        return redirect()
            ->to(base_url('owner/subscription'))
            ->with(
                'success',
                'Order berhasil dikirim. Menunggu verifikasi admin.'
            );
    }
}
