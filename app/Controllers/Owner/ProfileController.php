<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        return view('owner/profile/index', [
            'title' => 'Profil',
            'user' => $model->find(session('user_id'))
        ]);
    }
    public function update()
    {
        $model = $model = new UserModel();
        $user = $model->find(session('user_id'));
        $photo = $user['profile_photo'];
        $file = $this->request->getFile('profile_photo');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profiles', $newName);
            if ($photo && file_exists(FCPATH . 'uploads/profiles/' . $photo)) {
                unlink(FCPATH . 'uploads/profiles/' . $photo);
            }
            $photo = $newName;
        }
        $model->update(session('user_id'), [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'profile_photo' => $photo
        ]);
        session()->set([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'profile_photo' => $photo
        ]);
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function password()
    {
        return view('owner/profile/password', [
            'title' => 'Ubah Password'
        ]);
    }

    public function updatePassword()
    {
        $userModel = new \App\Models\UserModel();

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
