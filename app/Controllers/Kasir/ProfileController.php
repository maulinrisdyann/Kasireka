<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function password()
    {
        return view('kasir/profile/password', [
            'title' => 'Ubah Password'
        ]);
    }

    public function updatePassword()
    {
        $userModel = new UserModel();

        $user = $userModel->find(session('user_id'));

        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!password_verify($oldPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        if ($newPassword != $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak sama.');
        }

        if (strlen($newPassword) < 8) {
            return redirect()->back()->with('error', 'Password minimal 8 karakter.');
        }

        $userModel->update($user['id'], [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
}
