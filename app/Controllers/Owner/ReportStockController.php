<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class ReportStockController extends BaseController
{
    public function index()
    {
        $tenantId = session('tenant_id');
        $model    = new ProductModel();
        $products = $model->getWithCategory($tenantId);

        return view('owner/report_stock', [
            'title'    => 'Laporan Stok',
            'products' => $products,
        ]);
    }

    public function exportPdf()
    {
        $tenantId    = session('tenant_id');
        $model       = new ProductModel();
        $products    = $model->getWithCategory($tenantId);
        $tenantModel = new \App\Models\TenantModel();
        $tenant      = $tenantModel->find($tenantId);

        $html = view('pdf/stock_report', [
            'products' => $products,
            'tenant'   => $tenant,
        ]);

        $dompdf = new \Dompdf\Dompdf(['chroot' => ROOTPATH]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-stok-' . date('Ymd') . '.pdf', ['Attachment' => false]);
    }
}
