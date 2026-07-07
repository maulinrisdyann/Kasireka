<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TenantModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return $this->redirectByRole(session()->get('role'));
        }
        return view('auth/login');
    }

    public function doRegister()
    {
        $tenantName = $this->request->getPost('tenant');
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('password');

        $tenantModel = new TenantModel();
        $userModel   = new UserModel();


        // buat tenant
        $tenantId = $tenantModel->insert([
            'name' => $tenantName,
            'slug' => url_title($tenantName, '-', true),
            'email' => $email,
            'is_active' => 1,
            'subscription_expires_at' => date('Y-m-d H:i:s', strtotime('+30 days'))
        ]);


        // buat owner
        $userModel->insert([
            'tenant_id' => $tenantId,
            'name'      => $tenantName,
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'role'      => 'owner',
            'is_active' => 1
        ]);


        return redirect()->to(base_url('login'))
            ->with('success', 'Registrasi berhasil, silahkan login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function doLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user  = $model->where('email', $email)->where('is_active', 1)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->to(base_url('login'))->with('error', 'Email atau password salah.');
        }

        session()->set([
            'user_id'        => $user['id'],
            'tenant_id'      => $user['tenant_id'],
            'name'           => $user['name'],
            'email'          => $user['email'],
            'role'           => $user['role'],
            'profile_photo'  => $user['profile_photo']
        ]);

        return $this->redirectByRole($user['role']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Anda telah logout.');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin' => redirect()->to(base_url('admin/dashboard')),
            'owner' => redirect()->to(base_url('owner/dashboard')),
            'kasir' => redirect()->to(base_url('kasir/dashboard')),
            default => redirect()->to(base_url('login')),
        };
    }
}
