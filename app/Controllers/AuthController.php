<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to(site_url('/'));
        }
        return view('auth/login', ['title' => 'Masuk']);
    }

    public function attempt()
    {
        $throttler = service('throttler');
        if ($throttler->check('login_' . md5($this->request->getIPAddress()), 10, MINUTE) === false) {
            return redirect()->to(site_url('login'))->with('error', 'Terlalu banyak percobaan login. Tunggu sebentar lalu coba lagi.');
        }

        $username = strtolower(trim((string) $this->request->getPost('username')));
        $password = (string) $this->request->getPost('password');

        $model = new UserModel();
        $user  = $username !== '' ? $model->where('username', $username)->first() : null;

        $hash  = $user['password'] ?? '$2y$10$usesomesillystringforsalt.abcdefghijklmnopqrstuvwxyz0123456';
        $valid = password_verify($password, $hash);

        if (! $user || ! $valid) {
            return redirect()->to(site_url('login'))->with('error', 'Username atau password salah.');
        }
        if ((int) $user['aktif'] !== 1) {
            return redirect()->to(site_url('login'))->with('error', 'Akun Anda dinonaktifkan. Hubungi administrator.');
        }

        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            $model->update($user['id'], ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        }

        session()->regenerate(true);
        session()->set([
            'user_id'  => (int) $user['id'],
            'nama'     => $user['nama'],
            'role'     => $user['role'],
            'dosen_id' => $user['dosen_id'] !== null ? (int) $user['dosen_id'] : null,
        ]);
        $model->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

        if ((int) $user['wajib_ganti_password'] === 1) {
            return redirect()->to(site_url('ganti-password'));
        }
        return redirect()->to(site_url('/'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'))->with('success', 'Anda telah keluar.');
    }

    public function password()
    {
        $user = (new UserModel())->find(session()->get('user_id'));
        return view('auth/password', ['title' => 'Ganti Password', 'wajib' => (int) $user['wajib_ganti_password'] === 1]);
    }

    public function updatePassword()
    {
        $model = new UserModel();
        $user  = $model->find(session()->get('user_id'));

        $lama  = (string) $this->request->getPost('password_lama');
        $baru  = (string) $this->request->getPost('password_baru');
        $ulang = (string) $this->request->getPost('password_ulang');

        $back = redirect()->to(site_url('ganti-password'));
        if (! password_verify($lama, $user['password'])) {
            return $back->with('error', 'Password lama tidak sesuai.');
        }
        if (strlen($baru) < 8) {
            return $back->with('error', 'Password baru minimal 8 karakter.');
        }
        if ($baru !== $ulang) {
            return $back->with('error', 'Konfirmasi password baru tidak sama.');
        }
        if ($baru === $lama) {
            return $back->with('error', 'Password baru harus berbeda dari password lama.');
        }
        if (strtolower($baru) === strtolower($user['username'])) {
            return $back->with('error', 'Password tidak boleh sama dengan username.');
        }

        $model->update($user['id'], [
            'password'             => password_hash($baru, PASSWORD_DEFAULT),
            'wajib_ganti_password' => 0,
        ]);
        session()->regenerate(true);
        return redirect()->to(site_url('/'))->with('success', 'Password berhasil diganti.');
    }
}
