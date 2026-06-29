<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return $this->redirectByRole(session()->get('role'));
        }
        return view('auth/login');
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
            'user_id'   => $user['id'],
            'name'      => $user['name'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'tenant_id' => $user['tenant_id'],
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
