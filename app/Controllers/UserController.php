<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\UserModel;

class UserController extends BaseController
{
    private function rolesNeedingDosen(): array
    {
        return ['dosen', 'kaprodi'];
    }

    private function validateInput(array $in, ?int $exceptId = null): ?string
    {
        $model = new UserModel();
        if ($in['nama'] === '') return 'Nama wajib diisi.';
        if (! isset(UserModel::ROLES[$in['role']])) return 'Peran tidak valid.';
        if ($exceptId === null) {
            if (! preg_match('/^[a-z0-9._-]{3,30}$/', $in['username'])) {
                return 'Username 3-30 karakter: huruf kecil, angka, titik, garis bawah, atau strip.';
            }
            if ($model->where('username', $in['username'])->first()) return 'Username sudah dipakai.';
        }
        if (in_array($in['role'], $this->rolesNeedingDosen(), true)) {
            if (! $in['dosen_id']) return 'Peran Dosen/Kaprodi wajib ditautkan ke data dosen.';
        }
        if ($in['dosen_id']) {
            $dup = $model->where('dosen_id', $in['dosen_id']);
            if ($exceptId) $dup = $dup->where('id !=', $exceptId);
            if ($dup->first()) return 'Data dosen tersebut sudah ditautkan ke akun lain.';
        }
        return null;
    }

    public function index()
    {
        $users = (new UserModel())->orderBy('role', 'ASC')->orderBy('nama', 'ASC')->findAll();
        $data = [
            'title'     => 'Pengguna',
            'users'     => $users,
            'dosenById' => array_column((new DosenModel())->findAll(), null, 'id'),
            'dosenList' => (new DosenModel())->orderBy('nama', 'ASC')->findAll(),
        ];
        return view('users/index', $data);
    }

    public function store()
    {
        $in = [
            'nama'     => trim((string) $this->request->getPost('nama')),
            'username' => strtolower(trim((string) $this->request->getPost('username'))),
            'role'     => (string) $this->request->getPost('role'),
            'dosen_id' => (int) $this->request->getPost('dosen_id') ?: null,
        ];
        $password = (string) $this->request->getPost('password');

        $err = $this->validateInput($in);
        if (! $err && strlen($password) < 8) $err = 'Password awal minimal 8 karakter.';
        if ($err) return redirect()->to(site_url('users'))->with('error', $err);

        (new UserModel())->insert($in + [
            'password'             => password_hash($password, PASSWORD_DEFAULT),
            'aktif'                => 1,
            'wajib_ganti_password' => 1,
            'created_at'           => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to(site_url('users'))->with('success', 'Pengguna dibuat. Mereka wajib mengganti password saat login pertama.');
    }

    public function edit(int $id)
    {
        $user = (new UserModel())->find($id);
        if (! $user) return redirect()->to(site_url('users'))->with('error', 'Pengguna tidak ditemukan.');
        return view('users/edit', [
            'title'     => 'Ubah Pengguna',
            'user'      => $user,
            'dosenList' => (new DosenModel())->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    private function activeAdminCount(?int $exceptId = null): int
    {
        $q = (new UserModel())->where(['role' => 'admin', 'aktif' => 1]);
        if ($exceptId) $q = $q->where('id !=', $exceptId);
        return $q->countAllResults();
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $user  = $model->find($id);
        if (! $user) return redirect()->to(site_url('users'))->with('error', 'Pengguna tidak ditemukan.');

        $in = [
            'nama'     => trim((string) $this->request->getPost('nama')),
            'username' => $user['username'],
            'role'     => (string) $this->request->getPost('role'),
            'dosen_id' => (int) $this->request->getPost('dosen_id') ?: null,
        ];
        $aktif = $this->request->getPost('aktif') ? 1 : 0;

        $err = $this->validateInput($in, $id);
        if (! $err && $id === (int) session()->get('user_id') && ($in['role'] !== 'admin' || ! $aktif)) {
            $err = 'Anda tidak dapat menurunkan peran atau menonaktifkan akun Anda sendiri.';
        }
        if (! $err && $user['role'] === 'admin' && ($in['role'] !== 'admin' || ! $aktif) && $this->activeAdminCount($id) < 1) {
            $err = 'Harus ada minimal satu administrator aktif.';
        }
        if ($err) return redirect()->to(site_url('users/edit/' . $id))->with('error', $err);

        $model->update($id, [
            'nama' => $in['nama'], 'role' => $in['role'], 'dosen_id' => $in['dosen_id'], 'aktif' => $aktif,
        ]);
        return redirect()->to(site_url('users'))->with('success', 'Data pengguna diperbarui.');
    }

    public function resetPassword(int $id)
    {
        $model = new UserModel();
        $user  = $model->find($id);
        if (! $user) return redirect()->to(site_url('users'))->with('error', 'Pengguna tidak ditemukan.');

        $temp = substr(bin2hex(random_bytes(8)), 0, 12);
        $model->update($id, ['password' => password_hash($temp, PASSWORD_DEFAULT), 'wajib_ganti_password' => 1]);
        return redirect()->to(site_url('users'))->with('success',
            'Password sementara untuk "' . $user['username'] . '": ' . $temp . ' (tampil sekali; pengguna wajib menggantinya saat login).');
    }

    public function delete(int $id)
    {
        $model = new UserModel();
        $user  = $model->find($id);
        if (! $user) return redirect()->to(site_url('users'))->with('error', 'Pengguna tidak ditemukan.');
        if ($id === (int) session()->get('user_id')) {
            return redirect()->to(site_url('users'))->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        if ($user['role'] === 'admin' && (int) $user['aktif'] === 1 && $this->activeAdminCount($id) < 1) {
            return redirect()->to(site_url('users'))->with('error', 'Harus ada minimal satu administrator aktif.');
        }
        $model->delete($id);
        return redirect()->to(site_url('users'))->with('success', 'Pengguna dihapus.');
    }
}
