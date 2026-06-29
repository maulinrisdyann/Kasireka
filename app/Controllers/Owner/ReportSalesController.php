<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

class ReportSalesController extends BaseController
{
    public function index()
    {
        $tenantId  = session('tenant_id');
        $dateFrom  = $this->request->getGet('date_from') ?: date('Y-m-01');
        $dateTo    = $this->request->getGet('date_to') ?: date('Y-m-d');

        $db           = \Config\Database::connect();
        $transactions = $db->table('transactions t')
                           ->select('t.*, u.name as kasir_name')
                           ->join('users u', 'u.id = t.kasir_id')
                           ->where('t.tenant_id', $tenantId)
                           ->where('DATE(t.created_at) >=', $dateFrom)
                           ->where('DATE(t.created_at) <=', $dateTo)
                           ->orderBy('t.created_at', 'DESC')
                           ->get()
                           ->getResultArray();

        $model   = new TransactionModel();
        $summary = $model->getSalesSummary($tenantId, $dateFrom, $dateTo);

        return view('owner/report_sales', [
            'title'        => 'Laporan Penjualan',
            'transactions' => $transactions,
            'summary'      => $summary,
            'date_from'    => $dateFrom,
            'date_to'      => $dateTo,
        ]);
    }

    public function exportPdf()
    {
        $tenantId  = session('tenant_id');
        $dateFrom  = $this->request->getGet('date_from') ?: date('Y-m-01');
        $dateTo    = $this->request->getGet('date_to') ?: date('Y-m-d');

        $db           = \Config\Database::connect();
        $transactions = $db->table('transactions t')
                           ->select('t.*, u.name as kasir_name')
                           ->join('users u', 'u.id = t.kasir_id')
                           ->where('t.tenant_id', $tenantId)
                           ->where('DATE(t.created_at) >=', $dateFrom)
                           ->where('DATE(t.created_at) <=', $dateTo)
                           ->orderBy('t.created_at', 'DESC')
                           ->get()
                           ->getResultArray();

        $model     = new TransactionModel();
        $summary   = $model->getSalesSummary($tenantId, $dateFrom, $dateTo);
        $tenantModel = new \App\Models\TenantModel();
        $tenant    = $tenantModel->find($tenantId);

        $html = view('pdf/sales_report', [
            'transactions' => $transactions,
            'summary'      => $summary,
            'date_from'    => $dateFrom,
            'date_to'      => $dateTo,
            'tenant'       => $tenant,
        ]);

        $dompdf = new \Dompdf\Dompdf(['chroot' => ROOTPATH]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-penjualan-' . $dateFrom . '-' . $dateTo . '.pdf', ['Attachment' => false]);
    }
}
