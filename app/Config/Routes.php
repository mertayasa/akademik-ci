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
$routes->get('/', function(){
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
    $routes->get('/', 'User::index', ['as' => 'user_index']);
    $routes->get('edit/(:num)', 'User::edit/$1', ['as' => 'user_edit']);
    $routes->patch('update/(:num)', 'User::update/$1', ['as' => 'user_update']);
    $routes->get('create', 'User::create', ['as' => 'user_create']);
    $routes->post('insert', 'User::insert', ['as' => 'user_insert']);
    $routes->get('datatables', 'User::datatables', ['as' => 'user_datatable']);
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
