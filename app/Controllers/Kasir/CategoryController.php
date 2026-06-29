<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    private CategoryModel $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function index()
    {
        return view('kasir/categories/index', [
            'title'      => 'Kategori Produk',
            'categories' => $this->model->getByTenant(session('tenant_id')),
        ]);
    }

    public function create()
    {
        return view('kasir/categories/form', ['title' => 'Tambah Kategori', 'category' => null]);
    }

    public function store()
    {
        if (!$this->validate(['name' => 'required|min_length[2]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'tenant_id' => session('tenant_id'),
            'name'      => $this->request->getPost('name'),
        ]);

        return redirect()->to(base_url('kasir/categories'))->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $cat = $this->model->where('tenant_id', session('tenant_id'))->find($id);
        if (!$cat) return redirect()->to(base_url('kasir/categories'))->with('error', 'Tidak ditemukan.');
        return view('kasir/categories/form', ['title' => 'Edit Kategori', 'category' => $cat]);
    }

    public function update(int $id)
    {
        $cat = $this->model->where('tenant_id', session('tenant_id'))->find($id);
        if (!$cat) return redirect()->to(base_url('kasir/categories'))->with('error', 'Tidak ditemukan.');

        if (!$this->validate(['name' => 'required|min_length[2]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, ['name' => $this->request->getPost('name')]);
        return redirect()->to(base_url('kasir/categories'))->with('success', 'Kategori diperbarui.');
    }

    public function delete(int $id)
    {
        $cat = $this->model->where('tenant_id', session('tenant_id'))->find($id);
        if (!$cat) return redirect()->to(base_url('kasir/categories'))->with('error', 'Tidak ditemukan.');
        $this->model->delete($id);
        return redirect()->to(base_url('kasir/categories'))->with('success', 'Kategori dihapus.');
    }
}
