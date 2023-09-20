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

// Login Form
$routes->get('login', 'UserController::index', ['filter' => 'redirectIfAuthenticated']);
$routes->get('register', 'UserController::register', ['filter' => 'redirectIfAuthenticated']);
$routes->post('doLogin', 'UserController::doLogin');
$routes->post('doRegister', 'UserController::doRegister');
$routes->match(['get', 'post'], 'UserController/doRegister', 'FormController::doRegister');
$routes->get('logout', 'UserController::logout');

// user
$routes->get('profile', 'UserController::profile');
$routes->post('updateProfile', 'UserController::updateProfile');
$routes->post('getUser', 'UserController::getUser');

// Dashboard
$routes->get('/', 'Home::index', ['filter' => 'authenticate']);
$routes->get('orderProduct', 'OrderProductController::index', ['filter' => 'authenticate']);
$routes->get('listInventory', 'InventoryController::index', ['filter' => 'authenticate']);
$routes->get('transactionCustomer', 'TransactionCustomerController::index', ['filter' => 'authenticate']);
$routes->get('listProduct', 'ProductController::index', ['filter' => 'authenticate']);
$routes->get('sellProduct', 'SellProductController::index', ['filter' => 'authenticate']);
$routes->get('userManagement', 'UserManagementController::index', ['filter' => 'authenticate']);
$routes->get('reportTransaction', 'ReportController::index', ['filter' => 'authenticate']);
$routes->get('pickUpOrder', 'PickUpOrderController::index', ['filter' => 'authenticate']);
$routes->get('pickUpHistory', 'PickUpHistoryController::index', ['filter' => 'authenticate']);
$routes->get('transactionSuplier', 'TransactionSuplierController::index', ['filter' => 'authenticate']);

// Ajax Controller
$routes->get('getListCart', 'OrderProductController::getListCart');
$routes->post('addToCart', 'OrderProductController::addToCart');
$routes->post('removeFromCart', 'OrderProductController::removeFromCart');
$routes->post('updateCart', 'OrderProductController::updateCart');
$routes->post('updateProduct', 'ProductController::updateProduct');
$routes->post('receiveOrder', 'TransactionCustomerController::receiveOrder');
$routes->post('deleteProduct', 'ProductController::deleteProduct');
$routes->post('addProduct', 'ProductController::addProduct');
$routes->get('getListUser', 'UserManagementController::getListUser');
$routes->post('updateStatusUser', 'UserManagementController::updateStatusUser');
$routes->post('addUser', 'UserManagementController::addUser');
$routes->post('deleteUser', 'UserManagementController::deleteUser');
$routes->post('updateUser', 'UserManagementController::updateUser');
$routes->get('getListPickUpOrder', 'PickUpOrderController::getListPickUpOrder');
$routes->post('updateProductOut', 'PickUpOrderController::updateProductOut');
$routes->post('getOrderDetail', 'OrderProductController::getOrderDetail');
$routes->get('getListPickUp', 'PickUpHistoryController::getListPickUp');
$routes->post('updatePickupStatus', 'PickUpHistoryController::updatePickupStatus');
$routes->post('getTransactionCustomer', 'TransactionCustomerController::getTransactionCustomer');
$routes->post('getTransactionSuplier', 'TransactionSuplierController::getTransactionSuplier');
$routes->post('getListPickUpDetail', 'TransactionSuplierController::getListPickUpDetail');
$routes->get('getInventory', 'InventoryController::getInventory');
$routes->get('getListProduct', 'ProductController::getListProduct');
$routes->post('orderProduct', 'OrderProductController::orderProduct');
$routes->post('getProduct', 'ProductController::getProduct');

// Export
$routes->post('exportTransaction', 'ReportController::exportTransaction');

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