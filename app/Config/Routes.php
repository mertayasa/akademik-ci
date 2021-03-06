<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

if (file_exists(APPPATH . 'Helpers/custom_helper.php')) {
    require APPPATH . 'Helpers/custom_helper.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', function () {
    // return redirect()->to(fullRoute('login_form'));
    return redirect()->to(route_to('login_form'));
});

$routes->get('login', 'Auth::index', ['as' => 'login_form']);
$routes->post('login', 'Auth::login', ['as' => 'login']);
$routes->get('logout', 'Auth::logout', ['as' => 'logout']);

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index', ['as' => 'dashboard_index']);
    $routes->get('show/(:any)', 'Dashboard::show/$1', ['as' => 'dashboard_show']);
});

$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('(:segment)', 'User::index/$1', ['as' => 'user_index']);
    $routes->get('(:segment)/(:num)/edit', 'User::edit/$1/$2', ['as' => 'user_edit']);
    $routes->patch('update/(:segment)/(:num)', 'User::update/$1/$2', ['as' => 'user_update']);
    $routes->get('(:segment)/create', 'User::create/$1', ['as' => 'user_create']);
    $routes->post('insert/(:segment)', 'User::insert/$1', ['as' => 'user_insert']);
    $routes->get('destroy/(:num)/(:segment)', 'User::destroy/$1/$2', ['as' => 'user_destroy']);
    $routes->post('datatables/(:segment)', 'User::datatables/$1', ['as' => 'user_datatables']);
    $routes->get('datatables/(:segment)', 'User::datatables/$1', ['as' => 'user_datatables_get']);
    $routes->get('kepsek-edit/(:num)', 'User::kepsekEdit/$1', ['as' => 'kepsek_edit']);
    $routes->patch('kepsekUpdate/(:num)', 'User::kepsekUpdate/$1', ['as' => 'kepsek_update']);
    $routes->get('create/kepsek', 'User::kepsekCreate', ['as' => 'kepsek_create']);
    $routes->post('insert/new/kepsek', 'User::kepsekInsert', ['as' => 'kepsek_insert']);
    $routes->get('nonaktif/(:num)/(:segment)', 'User::setNonaktif/$1/$2', ['as' => 'user_set_nonaktif']);
    $routes->get('set-lulus/(:num)/(:num)', 'User::setLulus/$1/$2', ['as' => 'user_set_siswa_status']);
});

$routes->group('profile', ['filter' => 'auth'], function ($routes) {
    $routes->get('(:segment)/(:num)/show', 'Profile::show/$1/$2', ['as' => 'profile_show']);
    $routes->get('edit', 'Profile::edit', ['as' => 'profile_edit']);
    $routes->patch('update', 'Profile::update', ['as' => 'profile_update']);
});

$routes->group('tahunAjar', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'TahunAjar::index', ['as' => 'tahun_ajar_index']);
    $routes->get('(:num)/edit', 'TahunAjar::edit/$1', ['as' => 'tahun_ajar_edit']);
    $routes->get('(:num)/active', 'TahunAjar::setActive/$1', ['as' => 'tahun_ajar_set_active']);
    $routes->patch('update/(:num)', 'TahunAjar::update/$1', ['as' => 'tahun_ajar_update']);
    $routes->get('create', 'TahunAjar::create', ['as' => 'tahun_ajar_create']);
    $routes->post('insert', 'TahunAjar::insert', ['as' => 'tahun_ajar_insert']);
    $routes->get('destroy/(:num)', 'TahunAjar::destroy/$1', ['as' => 'tahun_ajar_destroy']);
    $routes->post('datatables', 'TahunAjar::datatables', ['as' => 'tahun_ajar_datatables']);
});

$routes->group('kelasPerTahun', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'KelasPerTahun::index', ['as' => 'kelas_per_tahun_index']);
    $routes->get('(:num)/edit', 'KelasPerTahun::edit/$1', ['as' => 'kelas_per_tahun_edit']);
    $routes->post('update/(:num)', 'KelasPerTahun::update/$1', ['as' => 'kelas_per_tahun_update']);
});

$routes->group('pindah', ['filter' => 'auth'], function ($routes) {
    $routes->get('(:segment)', 'PindahSekolah::index/$1', ['as' => 'pindah_sekolah_index']);
    $routes->get('(:num)/edit', 'PindahSekolah::edit/$1', ['as' => 'pindah_sekolah_edit']);
    $routes->post('update/(:segment)/(:num)', 'PindahSekolah::update/$1/$2', ['as' => 'pindah_sekolah_update']);
    $routes->get('(:segment)/show/(:num)', 'PindahSekolah::show/$1/$2', ['as' => 'pindah_sekolah_show']);
    $routes->get('(:segment)/create', 'PindahSekolah::create/$1', ['as' => 'pindah_sekolah_create']);
    $routes->post('insert/(:segment)', 'PindahSekolah::insert/$1', ['as' => 'pindah_sekolah_insert']);
    $routes->get('destroy/(:num)', 'PindahSekolah::destroy/$1', ['as' => 'pindah_sekolah_destroy']);
    $routes->post('datatables/(:segment)', 'PindahSekolah::datatables/$1', ['as' => 'pindah_sekolah_datatables']);
});

$routes->group('mapel', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Mapel::index', ['as' => 'mapel_index']);
    $routes->get('(:num)/edit', 'Mapel::edit/$1', ['as' => 'mapel_edit']);
    $routes->patch('update/(:num)', 'Mapel::update/$1', ['as' => 'mapel_update']);
    $routes->get('create', 'Mapel::create', ['as' => 'mapel_create']);
    $routes->post('insert', 'Mapel::insert', ['as' => 'mapel_insert']);
    $routes->get('destroy/(:num)', 'Mapel::destroy/$1', ['as' => 'mapel_destroy']);
    $routes->post('datatables', 'Mapel::datatables', ['as' => 'mapel_datatables']);
});

$routes->group('kelas', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Kelas::index', ['as' => 'kelas_index']);
    $routes->get('(:num)/edit', 'Kelas::edit/$1', ['as' => 'kelas_edit']);
    $routes->patch('update/(:num)', 'Kelas::update/$1', ['as' => 'kelas_update']);
    $routes->get('create', 'Kelas::create', ['as' => 'kelas_create']);
    $routes->post('insert', 'Kelas::insert', ['as' => 'kelas_insert']);
    $routes->get('destroy/(:num)', 'Kelas::destroy/$1', ['as' => 'kelas_destroy']);
    $routes->post('datatables', 'Kelas::datatables', ['as' => 'kelas_datatables']);
});

$routes->group('jadwal', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Jadwal::index', ['as' => 'jadwal_index']);
    $routes->get('(:num)/edit', 'Jadwal::edit/$1', ['as' => 'jadwal_edit']);
    $routes->patch('update/(:num)', 'Jadwal::update/$1', ['as' => 'jadwal_update']);
    $routes->post('create', 'Jadwal::create', ['as' => 'jadwal_create']);
    $routes->post('insert', 'Jadwal::insert', ['as' => 'jadwal_insert']);
    $routes->get('destroy/(:num)', 'Jadwal::destroy/$1', ['as' => 'jadwal_destroy']);
    $routes->post('datatables', 'Jadwal::datatables', ['as' => 'jadwal_datatables']);
    $routes->get('jadwal-guru', 'Jadwal::ShowjadwalGuru', ['as' => 'jadwal_guru']);
    $routes->get('jadwal-print-pdf/(:num)/(:num)', 'Jadwal::printJadwal/$1/$2', ['as' => 'jadwal_pdf']);
});

$routes->group('panel_wali', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PanelWali::index', ['as' => 'panel_wali_index']);
    $routes->get('absen/(:num)/(:num)/(:num)', 'PanelWali::absensi/$1/$2/$3', ['as' => 'panel_wali_absensi']);
});

$routes->group('absensi', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Absensi::index', ['as' => 'absensi_index']);
    $routes->post('get', 'Absensi::getAbsensi', ['as' => 'cek_absensi']);
    $routes->post('insert', 'Absensi::InsertAbsensi', ['as' => 'insert_absensi']);
    $routes->get('destroy/(:num)/(:num)', 'Absensi::destroy/$1/$2', ['as' => 'destroy_absensi']);
    $routes->get('detail/(:num)/(:num)/(:segment)', 'Absensi::detail/$1/$2/$3', ['as' => 'detail_absensi']);
    $routes->get('filter', 'Absensi::indexOrtu', ['as' => 'absensi_filter']);
});

$routes->group('nilai', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Nilai::index', ['as' => 'nilai_index']);
    $routes->get('(:num)/edit', 'Nilai::edit/$1', ['as' => 'nilai_edit']);
    $routes->get('(:num)/(:any)/edit', 'Nilai::edit/$1/$2', ['as' => 'nilai_edit_ganjil']);
    $routes->get('(:num)/(:any)/edit', 'Nilai::edit/$1/$2', ['as' => 'nilai_edit_genap']);
    $routes->patch('update/(:num)', 'Nilai::update/$1', ['as' => 'nilai_update']);
    $routes->get('create', 'Nilai::create', ['as' => 'nilai_create']);
    $routes->post('insert', 'Nilai::insert', ['as' => 'nilai_insert']);
    $routes->get('destroy/(:num)', 'Nilai::destroy/$1', ['as' => 'nilai_destroy']);
    $routes->post('datatables', 'Nilai::datatables', ['as' => 'nilai_datatables']);
    $routes->post('update', 'Nilai::update', ['as' => 'update_nilai']);
    $routes->get('filter', 'Nilai::indexOrtu', ['as' => 'nilai_filter']);
});

$routes->group('prestasi', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Prestasi::index', ['as' => 'prestasi_index']);
    $routes->get('(:num)/edit', 'Prestasi::edit/$1', ['as' => 'prestasi_edit']);
    $routes->patch('update/(:num)', 'Prestasi::update/$1', ['as' => 'prestasi_update']);
    $routes->get('create', 'Prestasi::create', ['as' => 'prestasi_create']);
    $routes->get('detail/(:num)', 'Prestasi::detail/$1', ['as' => 'prestasi_detail']);
    $routes->post('insert', 'Prestasi::insert', ['as' => 'prestasi_insert']);
    $routes->get('destroy/(:num)', 'Prestasi::destroy/$1', ['as' => 'prestasi_destroy']);
    $routes->post('datatables', 'Prestasi::datatables', ['as' => 'prestasi_datatables']);
});

$routes->group('agenda', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Agenda::index', ['as' => 'agenda_index']);
    $routes->get('(:num)/edit', 'Agenda::edit/$1', ['as' => 'agenda_edit']);
    $routes->patch('update/(:num)', 'Agenda::update/$1', ['as' => 'agenda_update']);
    $routes->get('(:num)/active', 'Agenda::setActive/$1', ['as' => 'agenda_set_active']);
    $routes->get('create', 'Agenda::create', ['as' => 'agenda_create']);
    $routes->get('detail/(:num)', 'Agenda::detail/$1', ['as' => 'agenda_detail']);
    $routes->post('insert', 'Agenda::insert', ['as' => 'agenda_insert']);
    $routes->get('destroy/(:num)', 'Agenda::destroy/$1', ['as' => 'agenda_destroy']);
    $routes->post('datatables', 'Agenda::datatables', ['as' => 'agenda_datatables']);
});

$routes->group('history', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'HistoryNilai::index', ['as' => 'nilai_history']);
});

$routes->group('tiny-upload', ['filter' => 'auth'], function ($routes) {
    $routes->post('/', 'TinyUpload::upload', ['as' => 'tiny_upload']);
});

$routes->group('akademik', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Akademik::index', ['as' => 'akademik_index']);
    $routes->post('search-tahun', 'Akademik::index', ['as' => 'akademik_search_tahun']);
    $routes->get('(:num)/(:num)/show-student', 'Akademik::showStudent/$1/$2', ['as' => 'akademik_show_student']);
    $routes->get('(:num)/(:num)/show-absensi', 'Akademik::showAbsensi/$1/$2', ['as' => 'akademik_show_absensi']);
    $routes->get('(:num)/(:num)/show-schedule', 'Akademik::showSchedule/$1/$2', ['as' => 'akademik_show_schedule']);
    $routes->patch('update', 'Akademik::update', ['as' => 'akademik_update_schedule']);
    $routes->get('delete/(:num)/(:num)/(:num)', 'Akademik::set_status/$1/$2/$3', ['as' => 'akademik_delete_schedule']);
    $routes->post('datatables', 'Akademik::datatables', ['as' => 'akademik_datatables']);
    $routes->post('(:num)/(:num)/siswa_datatables', 'AnggotaKelas::datatables/$1/$2', ['as' => 'siswa_datatables']);
    $routes->post('waliperkelas/(:num)/(:num)', 'Akademik::waliPerkelas/$1/$2', ['as' => 'show_wali']);
    $routes->post('insert/(:num)/(:num)', 'Akademik::insertWaliPerkelas/$1/$2', ['as' => 'akademik_save_wali']);
    $routes->get('destroy/(:num)/(:num)/(:num)', 'Akademik::destroyWali/$1/$2/$3', ['as' => 'akademik_destroy_wali']);
    $routes->post('update_wali/(:num)', 'Akademik::updateWali/$1', ['as' => 'akademik_update_wali']);
    $routes->get('(:num)/(:num)/insert-anggota-page', 'Akademik::insertAnggotaPage/$1/$2', ['as' => 'akademik_insert_anggota_page']);
    $routes->get('search-anggota-kelas', 'Akademik::searchAnggota', ['as' => 'akademik_search_anggota_kelas']);
    $routes->post('add-anggota-kelas/(:num)/(:num)', 'Akademik::insertAnggota/$1/$2', ['as' => 'akademik_add_anggota_kelas']);
});

$routes->group('anggota_kelas', ['filter' => 'auth'], function ($routes) {
    $routes->get('(:num)/update-status', 'AnggotaKelas::updateStatus/$1', ['as' => 'anggota_kelas_update_status']);
});

$routes->group('history-data', ['filter' => 'auth'], function ($routes) {
    $routes->get('(:segment)/', 'History::index/$1', ['as' => 'history_data_index']);
    $routes->get('(:num)/(:num)/show-student', 'History::showStudent/$1/$2', ['as' => 'history_akademik_show_student']);
    $routes->post('(:num)/(:num)/history_siswa_datatables', 'AnggotaKelas::datatables/$1/$2', ['as' => 'history_anggota_kelas_datatables']);
    $routes->get('(:num)/(:any)/nilai', 'History::nilai/$1/$2', ['as' => 'history_nilai_ganjil']);
    $routes->get('(:num)/(:any)/nilai', 'History::nilai/$1/$2', ['as' => 'history_nilai_genap']);
    $routes->get('(:num)/(:num)/schedule', 'History::jadwal/$1/$2', ['as' => 'history_akademik_schedule']);
    $routes->get('(:num)/(:num)/wali', 'History::wali/$1/$2', ['as' => 'history_akademik_wali']);
    $routes->get('(:num)/(:num)/absensi', 'History::absensi/$1/$2', ['as' => 'history_akademik_absensi']);
    $routes->get('(:segment)/user', 'History::user/$1', ['as' => 'history_user']);
    $routes->get('(:segment)/(:num)/profil', 'History::userProfil/$1/$2', ['as' => 'history_user_profil']);
    $routes->post('datatables/(:segment)', 'History::datatables/$1', ['as' => 'history_user_datatables']);
    $routes->get('prestasi-detail/(:num)', 'History::prestasiDetail/$1', ['as' => 'history_prestasi_detail']);
    $routes->get('pindah-masuk', 'History::pindahMasuk', ['as' => 'history_pindah_masuk']);
    $routes->get('nilai/(:num)', 'HistoryNilai::indexHistory/$1', ['as' => 'nilai_history_by_id']);
    $routes->get('pindah-keluar', 'History::pindahKeluar', ['as' => 'history_pindah_keluar']);
    // $routes->get('/', 'History::prestasiIndex', ['as' => 'history_prestasi_index']);
});

$routes->get('test/(:any)', 'Test::index/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
