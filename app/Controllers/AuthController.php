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
        $tenantName = trim($this->request->getPost('tenant'));
        $email      = trim($this->request->getPost('email'));
        $password   = $this->request->getPost('password');

        $tenantModel = new TenantModel();
        $userModel   = new UserModel();

        // Cek email sudah digunakan
        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email sudah digunakan.');
        }

        // Token verifikasi
        $verificationToken = bin2hex(random_bytes(32));

        // Buat tenant
        $tenantId = $tenantModel->insert([
            'name'                     => $tenantName,
            'slug'                     => url_title($tenantName, '-', true),
            'email'                    => $email,
            'is_active'                => 1,
            'subscription_expires_at'  => date('Y-m-d H:i:s', strtotime('+30 days')),
        ], true);

        // Buat akun owner
        $userModel->insert([
            'tenant_id'             => $tenantId,
            'name'                  => $tenantName,
            'email'                 => $email,
            'password'              => password_hash($password, PASSWORD_DEFAULT),
            'role'                  => 'owner',
            'is_active'             => 1,

            // Verifikasi Email
            'email_verified'        => 0,
            'email_verified_at'     => null,
            'verification_token'    => $verificationToken,
        ]);

        // ==========================
        // Kirim Email Verifikasi
        // ==========================
        $emailService = \Config\Services::email();

        $verifyLink = base_url('verify-email/' . $verificationToken);

        $message = view('emails/verify_email', [
            'name'       => $tenantName,
            'verifyLink' => $verifyLink,
        ]);

        $emailService->setTo($email);
        $emailService->setSubject('Verifikasi Email Akun Kasireka');
        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', $emailService->printDebugger(['headers']));
        }

        return redirect()->to(base_url('login'))
            ->with(
                'success',
                'Registrasi berhasil. Silakan cek email Anda untuk melakukan verifikasi akun sebelum login.'
            );
    }


    public function verifyEmail($token)
    {
        $userModel = new UserModel();

        $user = $userModel
            ->where('verification_token', $token)
            ->first();

        if (!$user) {
            return view('auth/email_not_verified', [
                'title' => 'Verifikasi Gagal'
            ]);
        }

        if ($user['email_verified']) {
            return view('auth/email_verified', [
                'title' => 'Email Sudah Diverifikasi'
            ]);
        }

        $userModel->update($user['id'], [
            'email_verified'      => 1,
            'email_verified_at'   => date('Y-m-d H:i:s'),
            'verification_token'  => null,
        ]);

        return view('auth/email_verified', [
            'title' => 'Email Berhasil Diverifikasi'
        ]);
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

        if (!$user['email_verified']) {
            return redirect()->back()
                ->with('error', 'Email belum diverifikasi. Silakan cek email Anda.');
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


    public function resendVerification()
    {
        $email = trim($this->request->getPost('email'));

        $userModel = new UserModel();

        $user = $userModel
            ->where('email', $email)
            ->first();

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Email tidak ditemukan.');
        }

        if ($user['email_verified']) {
            return redirect()->back()
                ->with('success', 'Email sudah terverifikasi.');
        }

        $token = bin2hex(random_bytes(32));

        $userModel->update($user['id'], [
            'verification_token' => $token,
        ]);

        $verifyLink = base_url('verify-email/' . $token);

        $emailService = \Config\Services::email();

        $message = view('emails/verify_email', [
            'name'       => $user['name'],
            'verifyLink' => $verifyLink,
        ]);

        $emailService->setTo($user['email']);
        $emailService->setSubject('Verifikasi Email Akun Kasireka');
        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', $emailService->printDebugger(['headers']));
            return redirect()->back()
                ->with('error', 'Gagal mengirim email verifikasi.');
        }

        return redirect()->back()
            ->with('success', 'Email verifikasi berhasil dikirim ulang.');
    }

    // ==========================
    // Lupa Password
    // ==========================


    public function forgotPassword()
    {
        return view('auth/forgot_password', [
            'title' => 'Lupa Password'
        ]);
    }

    public function sendResetLink()
    {
        $email = trim($this->request->getPost('email'));

        $userModel = new UserModel();

        $user = $userModel
            ->where('email', $email)
            ->first();

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Email tidak ditemukan.');
        }

        $token = bin2hex(random_bytes(32));

        $userModel->update($user['id'], [
            'reset_token' => $token,
            'reset_token_expired_at' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);

        $resetLink = base_url('reset-password/' . $token);

        $email = \Config\Services::email();

        $message = view('emails/reset_password', [
            'name'      => $user['name'],
            'resetLink' => $resetLink
        ]);

        $email->setTo($user['email']);
        $email->setSubject('Reset Password Kasireka');
        $email->setMessage($message);

        if (!$email->send()) {
            log_message('error', $email->printDebugger(['headers']));

            return redirect()->back()
                ->with('error', 'Gagal mengirim email reset password.');
        }

        return redirect()->back()
            ->with('success', 'Link reset password telah dikirim ke email Anda.');
    }


    public function resetPassword($token)
    {
        $userModel = new UserModel();

        $user = $userModel
            ->where('reset_token', $token)
            ->first();

        if (!$user) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Link reset password tidak valid.');
        }

        if (strtotime($user['reset_token_expired_at']) < time()) {
            return redirect()->to(base_url('forgot-password'))
                ->with('error', 'Link reset password telah kedaluwarsa.');
        }

        return view('auth/reset_password', [
            'title' => 'Reset Password',
            'token' => $token,
        ]);
    }

    public function updatePassword()
    {
        $token            = $this->request->getPost('token');
        $password         = $this->request->getPost('password');
        $confirmPassword  = $this->request->getPost('confirm_password');

        if ($password !== $confirmPassword) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Konfirmasi password tidak sama.');
        }

        $userModel = new UserModel();

        $user = $userModel
            ->where('reset_token', $token)
            ->first();

        if (!$user) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Token reset tidak valid.');
        }

        if (strtotime($user['reset_token_expired_at']) < time()) {
            return redirect()->to(base_url('forgot-password'))
                ->with('error', 'Token reset telah kedaluwarsa.');
        }

        $userModel->update($user['id'], [
            'password'                => password_hash($password, PASSWORD_DEFAULT),
            'reset_token'             => null,
            'reset_token_expired_at'  => null,
        ]);

        return redirect()->to(base_url('login'))
            ->with('success', 'Password berhasil diperbarui. Silakan login.');
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
