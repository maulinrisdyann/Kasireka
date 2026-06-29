<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionItemModel;
use App\Models\ProductModel;

class TransactionController extends BaseController
{
    private int $tenantId;
    private int $kasirId;

    public function __construct()
    {
        $this->tenantId = (int) session('tenant_id');
        $this->kasirId  = (int) session('user_id');
    }

    public function index()
    {
        return view('kasir/transaction/index', ['title' => 'Kasir POS']);
    }

    public function store()
    {
        $items = json_decode($this->request->getPost('items'), true);

        if (empty($items)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Keranjang kosong.']);
        }

        $paymentAmount = (float) $this->request->getPost('payment_amount');
        $paymentMethod = $this->request->getPost('payment_method') === 'transfer' ? 'transfer' : 'cash';
        $note          = $this->request->getPost('note');

        $productModel = new ProductModel();
        $transModel   = new TransactionModel();
        $itemModel    = new TransactionItemModel();

        $totalAmount = 0;
        $cartItems   = [];

        // Validasi produk dan hitung total
        foreach ($items as $item) {
            $product = $productModel->where('tenant_id', $this->tenantId)
                                    ->where('is_active', 1)
                                    ->find((int) $item['id']);
            if (!$product) {
                return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan: ' . $item['name']]);
            }
            if ($product['stock'] < (int) $item['qty']) {
                return $this->response->setJSON(['success' => false, 'message' => 'Stok tidak cukup untuk: ' . $product['name'] . ' (stok: ' . $product['stock'] . ')']);
            }
            $subtotal      = $product['price'] * (int) $item['qty'];
            $totalAmount  += $subtotal;
            $cartItems[]   = [
                'product'  => $product,
                'qty'      => (int) $item['qty'],
                'subtotal' => $subtotal,
            ];
        }

        if ($paymentAmount < $totalAmount) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pembayaran kurang. Total: Rp ' . number_format($totalAmount, 0, ',', '.')]);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $invoiceNumber = $transModel->generateInvoiceNumber($this->tenantId);
            $changeAmount  = $paymentAmount - $totalAmount;

            $transId = $transModel->insert([
                'tenant_id'      => $this->tenantId,
                'kasir_id'       => $this->kasirId,
                'invoice_number' => $invoiceNumber,
                'total_amount'   => $totalAmount,
                'payment_amount' => $paymentAmount,
                'change_amount'  => $changeAmount,
                'payment_method' => $paymentMethod,
                'note'           => $note,
                'created_at'     => date('Y-m-d H:i:s'),
            ], true);

            foreach ($cartItems as $ci) {
                $itemModel->insert([
                    'transaction_id' => $transId,
                    'product_id'     => $ci['product']['id'],
                    'product_name'   => $ci['product']['name'],
                    'price'          => $ci['product']['price'],
                    'quantity'       => $ci['qty'],
                    'subtotal'       => $ci['subtotal'],
                ]);

                // Kurangi stok
                $productModel->update($ci['product']['id'], [
                    'stock' => $ci['product']['stock'] - $ci['qty'],
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan transaksi.']);
            }

            return $this->response->setJSON([
                'success'        => true,
                'transaction_id' => $transId,
                'invoice_number' => $invoiceNumber,
                'total_amount'   => $totalAmount,
                'payment_amount' => $paymentAmount,
                'change_amount'  => $changeAmount,
                'print_url'      => base_url('kasir/transaction/' . $transId . '/print'),
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function history()
    {
        $transactions = \Config\Database::connect()
            ->table('transactions t')
            ->select('t.*, u.name as kasir_name')
            ->join('users u', 'u.id = t.kasir_id')
            ->where('t.tenant_id', $this->tenantId)
            ->where('t.kasir_id', $this->kasirId)
            ->orderBy('t.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('kasir/transaction/history', [
            'title'        => 'Riwayat Transaksi',
            'transactions' => $transactions,
        ]);
    }

    public function show(int $id)
    {
        $db          = \Config\Database::connect();
        $transaction = $db->table('transactions t')
                          ->select('t.*, u.name as kasir_name')
                          ->join('users u', 'u.id = t.kasir_id')
                          ->where('t.id', $id)
                          ->where('t.tenant_id', $this->tenantId)
                          ->get()
                          ->getRowArray();

        if (!$transaction) return redirect()->to(base_url('kasir/transaction/history'))->with('error', 'Transaksi tidak ditemukan.');

        $items = $db->table('transaction_items')->where('transaction_id', $id)->get()->getResultArray();

        return view('kasir/transaction/show', [
            'title'       => 'Detail Transaksi',
            'transaction' => $transaction,
            'items'       => $items,
        ]);
    }

    public function printStruk(int $id)
    {
        $db          = \Config\Database::connect();
        $transaction = $db->table('transactions t')
                          ->select('t.*, u.name as kasir_name')
                          ->join('users u', 'u.id = t.kasir_id')
                          ->where('t.id', $id)
                          ->where('t.tenant_id', $this->tenantId)
                          ->get()
                          ->getRowArray();

        if (!$transaction) return redirect()->to(base_url('kasir/transaction/history'));

        $items = $db->table('transaction_items')->where('transaction_id', $id)->get()->getResultArray();

        // Ambil info tenant
        $tenantModel = new \App\Models\TenantModel();
        $tenant      = $tenantModel->find($this->tenantId);

        return view('kasir/transaction/print', [
            'transaction' => $transaction,
            'items'       => $items,
            'tenant'      => $tenant,
        ]);
    }
}
