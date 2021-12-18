<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
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
    $routes->get('destroy/(:num)', 'User::destroy/$1', ['as' => 'user_destroy']);
    $routes->post('datatables/(:segment)', 'User::datatables/$1', ['as' => 'user_datatables']);
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
    $routes->get('create', 'Jadwal::create', ['as' => 'jadwal_create']);
    $routes->post('insert', 'Jadwal::insert', ['as' => 'jadwal_insert']);
    $routes->get('destroy/(:num)', 'Jadwal::destroy/$1', ['as' => 'jadwal_destroy']);
    $routes->post('datatables', 'Jadwal::datatables', ['as' => 'jadwal_datatables']);
});

$routes->group('nilai', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Nilai::index', ['as' => 'nilai_index']);
    $routes->get('(:num)/edit', 'Nilai::edit/$1', ['as' => 'nilai_edit']);
    $routes->patch('update/(:num)', 'Nilai::update/$1', ['as' => 'nilai_update']);
    $routes->get('create', 'Nilai::create', ['as' => 'nilai_create']);
    $routes->post('insert', 'Nilai::insert', ['as' => 'nilai_insert']);
    $routes->get('destroy/(:num)', 'Nilai::destroy/$1', ['as' => 'nilai_destroy']);
    $routes->post('datatables', 'Nilai::datatables', ['as' => 'nilai_datatables']);
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

$routes->group('history', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Nilai::history', ['as' => 'nilai_history']);
});

$routes->group('akademik', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Akademik::index', ['as' => 'akademik_index']);
    $routes->post('search-tahun', 'Akademik::index', ['as' => 'akademik_search_tahun']);
    $routes->get('(:num)/(:num)/show-student', 'Akademik::showStudent/$1/$2', ['as' => 'akademik_show_student']);
    $routes->get('(:num)/show-schedule', 'Akademik::showSchedule/$1', ['as' => 'akademik_show_schedule']);
    $routes->post('datatables', 'Akademik::datatables', ['as' => 'akademik_datatables']);
    $routes->post('(:num)/(:num)/siswa_datatables', 'AnggotaKelas::datatables/$1/$2', ['as' => 'siswa_datatables']);
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
