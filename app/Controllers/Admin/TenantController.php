<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TenantModel;
use App\Models\UserModel;

class TenantController extends BaseController
{
    private TenantModel $model;

    public function __construct()
    {
        $this->model = new TenantModel();
    }

    public function index()
    {
        return view('admin/tenants/index', [
            'title'   => 'Kelola Tenant',
            'tenants' => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('admin/tenants/form', ['title' => 'Tambah Tenant', 'tenant' => null]);
    }

    public function store()
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'slug'  => 'required|is_unique[tenants.slug]|regex_match[/^[a-z0-9-]+$/]',
            'email' => 'permit_empty|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'                    => $this->request->getPost('name'),
            'slug'                    => $this->request->getPost('slug'),
            'email'                   => $this->request->getPost('email'),
            'phone'                   => $this->request->getPost('phone'),
            'address'                 => $this->request->getPost('address'),
            'is_active'               => $this->request->getPost('is_active') ? 1 : 0,
            'subscription_expires_at' => $this->request->getPost('subscription_expires_at') ?: null,
        ];

        $tenantId = $this->model->insert($data, true);

        // Buat owner untuk tenant jika diisi
        $ownerEmail    = $this->request->getPost('owner_email');
        $ownerName     = $this->request->getPost('owner_name');
        $ownerPassword = $this->request->getPost('owner_password');

        if ($ownerEmail && $ownerName && $ownerPassword) {
            $userModel = new UserModel();
            $userModel->insert([
                'tenant_id' => $tenantId,
                'name'      => $ownerName,
                'email'     => $ownerEmail,
                'password'  => password_hash($ownerPassword, PASSWORD_BCRYPT),
                'role'      => 'owner',
                'is_active' => 1,
            ]);
        }

        return redirect()->to(base_url('admin/tenants'))->with('success', 'Tenant berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $tenant = $this->model->find($id);
        if (!$tenant) return redirect()->to(base_url('admin/tenants'))->with('error', 'Tenant tidak ditemukan.');
        return view('admin/tenants/form', ['title' => 'Edit Tenant', 'tenant' => $tenant]);
    }

    public function update(int $id)
    {
        $tenant = $this->model->find($id);
        if (!$tenant) return redirect()->to(base_url('admin/tenants'))->with('error', 'Tenant tidak ditemukan.');

        $rules = [
            'name'  => 'required|min_length[3]',
            'slug'  => "required|is_unique[tenants.slug,id,{$id}]|regex_match[/^[a-z0-9-]+$/]",
            'email' => 'permit_empty|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'name'                    => $this->request->getPost('name'),
            'slug'                    => $this->request->getPost('slug'),
            'email'                   => $this->request->getPost('email'),
            'phone'                   => $this->request->getPost('phone'),
            'address'                 => $this->request->getPost('address'),
            'is_active'               => $this->request->getPost('is_active') ? 1 : 0,
            'subscription_expires_at' => $this->request->getPost('subscription_expires_at') ?: null,
        ]);

        return redirect()->to(base_url('admin/tenants'))->with('success', 'Tenant berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/tenants'))->with('success', 'Tenant berhasil dihapus.');
    }
}
