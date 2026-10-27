<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 *
 * Peran: admin, dosen, gkm, kaprodi, gpm
 * Filter 'auth'  = wajib login
 * Filter 'role:a,b' = hanya peran tertentu (aturan kepemilikan data ada di App\Libraries\Access)
 */

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attempt');

$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes) {
    $routes->post('logout', 'AuthController::logout');
    $routes->get('ganti-password', 'AuthController::password');
    $routes->post('ganti-password', 'AuthController::updatePassword');

    $routes->get('/', 'Dashboard::index');

    $routes->group('users', ['filter' => 'role:admin'], static function (RouteCollection $routes) {
        $routes->get('/', 'UserController::index');
        $routes->post('store', 'UserController::store');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->post('update/(:num)', 'UserController::update/$1');
        $routes->post('reset/(:num)', 'UserController::resetPassword/$1');
        $routes->post('delete/(:num)', 'UserController::delete/$1');
    });

    $routes->get('prodi', 'ProdiController::index', ['filter' => 'role:admin,kaprodi']);
    $routes->get('dosen', 'DosenController::index', ['filter' => 'role:admin,kaprodi']);
    $routes->get('mahasiswa', 'MahasiswaController::index', ['filter' => 'role:admin,kaprodi']);
    $routes->get('mata-kuliah', 'MataKuliahController::index', ['filter' => 'role:admin,kaprodi']);

    $routes->post('prodi/store', 'ProdiController::store', ['filter' => 'role:admin']);
    $routes->post('prodi/delete/(:num)', 'ProdiController::delete/$1', ['filter' => 'role:admin']);
    $routes->post('dosen/store', 'DosenController::store', ['filter' => 'role:admin']);
    $routes->post('dosen/delete/(:num)', 'DosenController::delete/$1', ['filter' => 'role:admin']);
    $routes->post('mahasiswa/store', 'MahasiswaController::store', ['filter' => 'role:admin']);
    $routes->post('mahasiswa/delete/(:num)', 'MahasiswaController::delete/$1', ['filter' => 'role:admin']);
    $routes->post('mata-kuliah/store', 'MataKuliahController::store', ['filter' => 'role:admin,kaprodi']);
    $routes->post('mata-kuliah/delete/(:num)', 'MataKuliahController::delete/$1', ['filter' => 'role:admin,kaprodi']);

    $routes->get('kurikulum', 'KurikulumController::index');
    $routes->group('kurikulum', ['filter' => 'role:admin,kaprodi'], static function (RouteCollection $routes) {
        $routes->post('cpl/store', 'KurikulumController::storeCpl');
        $routes->post('cpl/delete/(:num)', 'KurikulumController::deleteCpl/$1');
        $routes->post('cpmk/store', 'KurikulumController::storeCpmk');
        $routes->post('cpmk/delete/(:num)', 'KurikulumController::deleteCpmk/$1');
        $routes->post('cpmk/bobot', 'KurikulumController::setBobot');
    });

    $routes->get('rps', 'RpsController::index');
    $routes->get('rps/(:num)', 'RpsController::detail/$1');
    $routes->post('rps/store', 'RpsController::store', ['filter' => 'role:dosen,admin']);
    $routes->post('rps/(:num)/pertemuan', 'RpsController::updatePertemuan/$1', ['filter' => 'role:dosen,admin']);
    $routes->post('rps/(:num)/jenis/add', 'RpsController::addJenis/$1', ['filter' => 'role:dosen,admin']);
    $routes->post('rps/(:num)/jenis/delete/(:num)', 'RpsController::deleteJenis/$1/$2', ['filter' => 'role:dosen,admin']);
    $routes->post('rps/(:num)/jenis/update', 'RpsController::updateJenis/$1', ['filter' => 'role:dosen,admin']);
    $routes->post('rps/(:num)/matriks', 'RpsController::updateMatriks/$1', ['filter' => 'role:dosen,admin']);
    $routes->post('rps/(:num)/identitas', 'RpsController::updateIdentitas/$1', ['filter' => 'role:dosen,admin']);
    $routes->post('rps/(:num)/jenis/(:num)/rencana', 'RpsController::updateRencana/$1/$2', ['filter' => 'role:dosen,admin']);
    $routes->post('rps/(:num)/workflow/ajukan', 'RpsController::wfAjukan/$1', ['filter' => 'role:dosen,admin']);
    $routes->post('rps/(:num)/workflow/revisi', 'RpsController::wfRevisi/$1', ['filter' => 'role:gkm']);
    $routes->post('rps/(:num)/workflow/setuju', 'RpsController::wfSetuju/$1', ['filter' => 'role:gkm']);
    $routes->post('rps/(:num)/workflow/ttd-dosen', 'RpsController::wfTtdDosen/$1', ['filter' => 'role:dosen,kaprodi']);
    $routes->post('rps/(:num)/workflow/ttd-kaprodi', 'RpsController::wfTtdKaprodi/$1', ['filter' => 'role:kaprodi']);
    $routes->post('rps/(:num)/workflow/arsip', 'RpsController::wfArsip/$1', ['filter' => 'role:gpm,kaprodi']);

    $routes->group('kelas', ['filter' => 'role:admin,kaprodi,dosen'], static function (RouteCollection $routes) {
        $routes->get('/', 'KelasController::index');
        $routes->get('(:num)', 'KelasController::detail/$1');
        $routes->post('(:num)/kontrak', 'KelasController::updateKontrak/$1');
        $routes->post('(:num)/peserta/add', 'KelasController::addPeserta/$1');
        $routes->post('(:num)/peserta/delete/(:num)', 'KelasController::deletePeserta/$1/$2');
    });
    $routes->post('kelas/store', 'KelasController::store', ['filter' => 'role:admin,kaprodi']);

    $routes->group('presensi', ['filter' => 'role:admin,kaprodi,dosen'], static function (RouteCollection $routes) {
        $routes->get('/', 'PresensiController::index');
        $routes->get('(:num)', 'PresensiController::show/$1');
        $routes->post('(:num)/simpan', 'PresensiController::simpanPresensi/$1');
        $routes->post('(:num)/nilai', 'PresensiController::simpanNilai/$1');
    });

    $routes->get('capaian', 'CapaianController::index');
    $routes->get('capaian/(:num)', 'CapaianController::show/$1');
    $routes->get('portofolio', 'PortofolioController::index');
    $routes->get('portofolio/(:num)', 'PortofolioController::show/$1');
    $routes->post('portofolio/(:num)/narasi', 'PortofolioController::updateNarasi/$1', ['filter' => 'role:admin,kaprodi,dosen']);

    // Laporan sesuai format dokumen OBE UMRAH 2026 (halaman siap cetak / simpan PDF)
    $routes->get('laporan', 'LaporanController::index');
    $routes->get('laporan/silabus/(:num)', 'LaporanController::silabus/$1');
    $routes->get('laporan/rps/(:num)', 'LaporanController::rps/$1');
    $routes->get('laporan/kontrak/(:num)', 'LaporanController::kontrak/$1');
    $routes->get('laporan/portofolio/(:num)', 'LaporanController::portofolio/$1');
    $routes->get('laporan/epbm/(:num)', 'LaporanController::epbm/$1', ['filter' => 'role:admin,kaprodi,gkm,gpm']);

    $routes->group('epbm', ['filter' => 'role:admin,kaprodi,gkm,gpm'], static function (RouteCollection $routes) {
        $routes->get('/', 'EpbmController::index');
        $routes->get('(:num)', 'EpbmController::edit/$1');
        $routes->post('store', 'EpbmController::store', ['filter' => 'role:admin,gkm']);
        $routes->post('(:num)/update', 'EpbmController::update/$1', ['filter' => 'role:admin,gkm']);
        $routes->post('(:num)/delete', 'EpbmController::delete/$1', ['filter' => 'role:admin,gkm']);
    });
});
