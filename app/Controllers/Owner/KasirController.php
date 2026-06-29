<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\UserModel;

class KasirController extends BaseController
{
    private UserModel $model;
    private int $tenantId;

    public function __construct()
    {
        $this->model    = new UserModel();
        $this->tenantId = (int) session('tenant_id');
    }

    public function index()
    {
        return view('owner/kasir/index', [
            'title'  => 'Kelola Kasir',
            'kasirs' => $this->model
                ->where('tenant_id', $this->tenantId)
                ->where('role', 'kasir')
                ->orderBy('name')
                ->findAll(),
        ]);
    }

    public function create()
    {
        return view('owner/kasir/form', ['title' => 'Tambah Kasir', 'kasir' => null]);
    }

    public function store()
    {
        if (!$this->validate([
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'tenant_id' => $this->tenantId,
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'      => 'kasir',
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('owner/kasir'))->with('success', 'Akun kasir berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $kasir = $this->model->where('tenant_id', $this->tenantId)->where('role', 'kasir')->find($id);
        if (!$kasir) return redirect()->to(base_url('owner/kasir'))->with('error', 'Kasir tidak ditemukan.');

        return view('owner/kasir/form', ['title' => 'Edit Kasir', 'kasir' => $kasir]);
    }

    public function update(int $id)
    {
        $kasir = $this->model->where('tenant_id', $this->tenantId)->where('role', 'kasir')->find($id);
        if (!$kasir) return redirect()->to(base_url('owner/kasir'))->with('error', 'Kasir tidak ditemukan.');

        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
        ];
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        $this->model->update($id, $data);

        return redirect()->to(base_url('owner/kasir'))->with('success', 'Akun kasir berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $kasir = $this->model->where('tenant_id', $this->tenantId)->where('role', 'kasir')->find($id);
        if (!$kasir) return redirect()->to(base_url('owner/kasir'))->with('error', 'Kasir tidak ditemukan.');

        $this->model->delete($id);
        return redirect()->to(base_url('owner/kasir'))->with('success', 'Akun kasir berhasil dihapus.');
    }
}
