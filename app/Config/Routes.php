<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->add('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->add('register', 'Auth::register');
$routes->get('logout', 'Auth::logout');
$routes->get('shop', 'Shop::index');
$routes->get('shop/category/(:segment)', 'Shop::category/$1');
$routes->get('shop/product/(:segment)', 'Shop::product/$1');
$routes->get('cart', 'Shop::cart_show', ['filter' => 'auth']);
$routes->get('shop/cart', 'Shop::cart_show', ['filter' => 'auth']);
$routes->add('shop/add', 'Shop::cart_add', ['filter' => 'auth']);
$routes->add('shop/edit', 'Shop::cart_edit', ['filter' => 'auth']);
$routes->get('shop/delete/(:any)', 'Shop::cart_delete/$1', ['filter' => 'auth']);
$routes->get('shop/clear', 'Shop::cart_clear', ['filter' => 'auth']);
$routes->get('shop/checkout', 'Shop::cart_checkout', ['filter' => 'auth']);
$routes->get('shop/getcity', 'Shop::getcity', ['filter' => 'auth']);
$routes->get('shop/getcost', 'Shop::getcost', ['filter' => 'auth']);
$routes->get('transaction', 'Transaksi::index', ['filter' => 'auth']);
$routes->get('invoice/(:segment)', 'Transaksi::invoice', ['filter' => 'auth']);
$routes->add('buy', 'Transaksi::buy', ['filter' => 'auth']);
$routes->add('komentar/create', 'Komentar::create', ['filter' => 'auth']);
$routes->get('contact', 'Home::contact');
$routes->get('barang', 'BarangController::index');
$routes->get('barang/tambah', 'BarangController::tambah');
$routes->post('barang/tambah', 'BarangController::tambah');
$routes->get('barang/edit/(:segment)', 'BarangController::edit/$1');
$routes->post('barang/edit/(:segment)', 'BarangController::edit/$1');
$routes->get('barang/delete/(:segment)', 'BarangController::delete/$1');


$routes->group('kategori', function ($routes) {
    $routes->get('tambah', 'KategoriController::tambah');
    $routes->get('index', 'KategoriController::index');
    $routes->post('tambah', 'KategoriController::tambah');
});






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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
