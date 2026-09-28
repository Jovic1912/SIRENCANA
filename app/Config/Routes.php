<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');

// Data Induk
$routes->get('prodi', 'ProdiController::index');
$routes->post('prodi/store', 'ProdiController::store');
$routes->get('prodi/delete/(:num)', 'ProdiController::delete/$1');

$routes->get('dosen', 'DosenController::index');
$routes->post('dosen/store', 'DosenController::store');
$routes->get('dosen/delete/(:num)', 'DosenController::delete/$1');

$routes->get('mahasiswa', 'MahasiswaController::index');
$routes->post('mahasiswa/store', 'MahasiswaController::store');
$routes->get('mahasiswa/delete/(:num)', 'MahasiswaController::delete/$1');

$routes->get('mata-kuliah', 'MataKuliahController::index');
$routes->post('mata-kuliah/store', 'MataKuliahController::store');
$routes->get('mata-kuliah/delete/(:num)', 'MataKuliahController::delete/$1');

// Kurikulum & CPMK
$routes->get('kurikulum', 'KurikulumController::index');
$routes->post('kurikulum/cpl/store', 'KurikulumController::storeCpl');
$routes->get('kurikulum/cpl/delete/(:num)', 'KurikulumController::deleteCpl/$1');
$routes->post('kurikulum/cpmk/store', 'KurikulumController::storeCpmk');
$routes->get('kurikulum/cpmk/delete/(:num)', 'KurikulumController::deleteCpmk/$1');
$routes->post('kurikulum/cpmk/bobot', 'KurikulumController::setBobot');

// RPS
$routes->get('rps', 'RpsController::index');
$routes->post('rps/store', 'RpsController::store');
$routes->get('rps/(:num)', 'RpsController::detail/$1');
$routes->post('rps/(:num)/pertemuan', 'RpsController::updatePertemuan/$1');
$routes->post('rps/(:num)/jenis/add', 'RpsController::addJenis/$1');
$routes->get('rps/(:num)/jenis/delete/(:num)', 'RpsController::deleteJenis/$1/$2');
$routes->post('rps/(:num)/jenis/update', 'RpsController::updateJenis/$1');
$routes->post('rps/(:num)/matriks', 'RpsController::updateMatriks/$1');
$routes->post('rps/(:num)/workflow/ajukan', 'RpsController::wfAjukan/$1');
$routes->post('rps/(:num)/workflow/revisi', 'RpsController::wfRevisi/$1');
$routes->post('rps/(:num)/workflow/setuju', 'RpsController::wfSetuju/$1');
$routes->post('rps/(:num)/workflow/ttd-dosen', 'RpsController::wfTtdDosen/$1');
$routes->post('rps/(:num)/workflow/ttd-kaprodi', 'RpsController::wfTtdKaprodi/$1');
$routes->post('rps/(:num)/workflow/arsip', 'RpsController::wfArsip/$1');

// Kelas & Kontrak
$routes->get('kelas', 'KelasController::index');
$routes->post('kelas/store', 'KelasController::store');
$routes->get('kelas/(:num)', 'KelasController::detail/$1');
$routes->post('kelas/(:num)/kontrak', 'KelasController::updateKontrak/$1');
$routes->post('kelas/(:num)/peserta/add', 'KelasController::addPeserta/$1');
$routes->get('kelas/(:num)/peserta/delete/(:num)', 'KelasController::deletePeserta/$1/$2');

// Presensi & Nilai
$routes->get('presensi', 'PresensiController::index');
$routes->get('presensi/(:num)', 'PresensiController::show/$1');
$routes->post('presensi/(:num)/simpan', 'PresensiController::simpanPresensi/$1');
$routes->post('presensi/(:num)/nilai', 'PresensiController::simpanNilai/$1');

// Capaian CPMK
$routes->get('capaian', 'CapaianController::index');
$routes->get('capaian/(:num)', 'CapaianController::show/$1');

// Portofolio
$routes->get('portofolio', 'PortofolioController::index');
$routes->get('portofolio/(:num)', 'PortofolioController::show/$1');
$routes->post('portofolio/(:num)/narasi', 'PortofolioController::updateNarasi/$1');
