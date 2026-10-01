<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userId  = $session->get('user_id');

        if (! $userId) {
            return redirect()->to(site_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = (new UserModel())->find($userId);
        if (! $user || (int) $user['aktif'] !== 1) {
            $session->remove(['user_id', 'nama', 'role', 'dosen_id']);
            return redirect()->to(site_url('login'))->with('error', 'Akun tidak ditemukan atau dinonaktifkan.');
        }

        $session->set([
            'nama'     => $user['nama'],
            'role'     => $user['role'],
            'dosen_id' => $user['dosen_id'] !== null ? (int) $user['dosen_id'] : null,
        ]);

        if ((int) $user['wajib_ganti_password'] === 1) {
            $path = trim($request->getPath(), '/');
            if (! in_array($path, ['ganti-password', 'logout'], true)) {
                return redirect()->to(site_url('ganti-password'))->with('error', 'Anda harus mengganti password sebelum melanjutkan.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
