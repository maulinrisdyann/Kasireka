<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use Milon\Barcode\DNS1D;

class ProductController extends BaseController
{
    private ProductModel $model;
    private int $tenantId;

    public function __construct()
    {
        $this->model    = new ProductModel();
        $this->tenantId = (int) session('tenant_id');
    }

    public function index()
    {
        return view('kasir/products/index', [
            'title'    => 'Produk',
            'products' => $this->model->getWithCategory($this->tenantId),
        ]);
    }

    public function create()
    {
        $catModel = new CategoryModel();
        return view('kasir/products/form', [
            'title'      => 'Tambah Produk',
            'product'    => null,
            'categories' => $catModel->getByTenant($this->tenantId),
        ]);
    }

    public function store()
    {
        if (!$this->validate([
            'name'  => 'required|min_length[2]',
            'price' => 'required|decimal|greater_than[0]',
            'stock' => 'required|integer|greater_than_equal_to[0]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $barcode = trim($this->request->getPost('barcode'));

        $data = [
            'tenant_id'   => $this->tenantId,
            'category_id' => $this->request->getPost('category_id') ?: null,
            'name'        => $this->request->getPost('name'),
            'barcode'     => $barcode ?: null,
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'stock_alert' => $this->request->getPost('stock_alert') ?: 5,
            'unit'        => $this->request->getPost('unit') ?: 'pcs',
            'is_active'   => 1,
        ];

        $productId = $this->model->insert($data, true);

        // Generate barcode jika tidak diisi manual
        if (!$barcode) {
            $generated = $this->model->generateBarcode($this->tenantId, $productId);
            $this->model->update($productId, ['barcode' => $generated]);
        }

        return redirect()->to(base_url('kasir/products'))->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $product = $this->model->where('tenant_id', $this->tenantId)->find($id);
        if (!$product) return redirect()->to(base_url('kasir/products'))->with('error', 'Produk tidak ditemukan.');

        $catModel = new CategoryModel();
        return view('kasir/products/form', [
            'title'      => 'Edit Produk',
            'product'    => $product,
            'categories' => $catModel->getByTenant($this->tenantId),
        ]);
    }

    public function update(int $id)
    {
        $product = $this->model->where('tenant_id', $this->tenantId)->find($id);
        if (!$product) return redirect()->to(base_url('kasir/products'))->with('error', 'Produk tidak ditemukan.');

        if (!$this->validate([
            'name'  => 'required|min_length[2]',
            'price' => 'required|decimal|greater_than[0]',
            'stock' => 'required|integer|greater_than_equal_to[0]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $barcode = trim($this->request->getPost('barcode'));
        if (!$barcode) {
            $barcode = $product['barcode'] ?: $this->model->generateBarcode($this->tenantId, $id);
        }

        $this->model->update($id, [
            'category_id' => $this->request->getPost('category_id') ?: null,
            'name'        => $this->request->getPost('name'),
            'barcode'     => $barcode,
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'stock_alert' => $this->request->getPost('stock_alert') ?: 5,
            'unit'        => $this->request->getPost('unit') ?: 'pcs',
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('kasir/products'))->with('success', 'Produk diperbarui.');
    }

    public function delete(int $id)
    {
        $product = $this->model->where('tenant_id', $this->tenantId)->find($id);
        if (!$product) return redirect()->to(base_url('kasir/products'))->with('error', 'Produk tidak ditemukan.');
        $this->model->delete($id);
        return redirect()->to(base_url('kasir/products'))->with('success', 'Produk dihapus.');
    }

    public function barcode(int $id)
    {
        $product = $this->model->where('tenant_id', $this->tenantId)->find($id);
        if (!$product) return redirect()->to(base_url('kasir/products'))->with('error', 'Produk tidak ditemukan.');

        $dns1d = new DNS1D();
        $dns1d->setStorPath(WRITEPATH . 'cache/');
        $barcodeSvg = $dns1d->getBarcodeSVG($product['barcode'], 'C128', 2, 60);

        return view('kasir/products/barcode', [
            'title'      => 'Barcode — ' . $product['name'],
            'product'    => $product,
            'barcodeSvg' => $barcodeSvg,
        ]);
    }

    public function search()
    {
        $q        = $this->request->getGet('q');
        $products = $this->model->select('id, name, barcode, price, stock, unit')
                                ->where('tenant_id', $this->tenantId)
                                ->where('is_active', 1)
                                ->groupStart()
                                    ->like('name', $q)
                                    ->orLike('barcode', $q)
                                ->groupEnd()
                                ->where('stock >', 0)
                                ->limit(10)
                                ->findAll();

        return $this->response->setJSON($products);
    }
}
