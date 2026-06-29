<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubscriptionPackageModel;

class SubscriptionPackageController extends BaseController
{
    private SubscriptionPackageModel $model;

    public function __construct()
    {
        $this->model = new SubscriptionPackageModel();
    }

    public function index()
    {
        return view('admin/packages/index', [
            'title'    => 'Paket Langganan',
            'packages' => $this->model->orderBy('price')->findAll(),
        ]);
    }

    public function create()
    {
        return view('admin/packages/form', ['title' => 'Tambah Paket', 'package' => null]);
    }

    public function store()
    {
        if (!$this->validate([
            'name'          => 'required',
            'duration_days' => 'required|integer|greater_than[0]',
            'price'         => 'required|decimal|greater_than[0]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'name'          => $this->request->getPost('name'),
            'duration_days' => $this->request->getPost('duration_days'),
            'price'         => $this->request->getPost('price'),
            'description'   => $this->request->getPost('description'),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/packages'))->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $package = $this->model->find($id);
        if (!$package) return redirect()->to(base_url('admin/packages'))->with('error', 'Paket tidak ditemukan.');
        return view('admin/packages/form', ['title' => 'Edit Paket', 'package' => $package]);
    }

    public function update(int $id)
    {
        if (!$this->validate([
            'name'          => 'required',
            'duration_days' => 'required|integer|greater_than[0]',
            'price'         => 'required|decimal|greater_than[0]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'          => $this->request->getPost('name'),
            'duration_days' => $this->request->getPost('duration_days'),
            'price'         => $this->request->getPost('price'),
            'description'   => $this->request->getPost('description'),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/packages'))->with('success', 'Paket berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/packages'))->with('success', 'Paket berhasil dihapus.');
    }
}
