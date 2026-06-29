<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::doLogin');
$routes->get('logout', 'AuthController::logout');

// Admin routes
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // Tenants
    $routes->get('tenants', 'Admin\TenantController::index');
    $routes->get('tenants/new', 'Admin\TenantController::create');
    $routes->post('tenants/new', 'Admin\TenantController::store');
    $routes->get('tenants/(:num)/edit', 'Admin\TenantController::edit/$1');
    $routes->post('tenants/(:num)/edit', 'Admin\TenantController::update/$1');
    $routes->post('tenants/(:num)/delete', 'Admin\TenantController::delete/$1');

    // Subscription Packages
    $routes->get('packages', 'Admin\SubscriptionPackageController::index');
    $routes->get('packages/new', 'Admin\SubscriptionPackageController::create');
    $routes->post('packages/new', 'Admin\SubscriptionPackageController::store');
    $routes->get('packages/(:num)/edit', 'Admin\SubscriptionPackageController::edit/$1');
    $routes->post('packages/(:num)/edit', 'Admin\SubscriptionPackageController::update/$1');
    $routes->post('packages/(:num)/delete', 'Admin\SubscriptionPackageController::delete/$1');

    // Subscription Orders
    $routes->get('subscriptions', 'Admin\SubscriptionOrderController::index');
    $routes->post('subscriptions/(:num)/verify', 'Admin\SubscriptionOrderController::verify/$1');
    $routes->post('subscriptions/(:num)/reject', 'Admin\SubscriptionOrderController::reject/$1');
    $routes->get('subscriptions/(:num)/proof', 'Admin\SubscriptionOrderController::proof/$1');
});

// Owner routes
$routes->group('owner', ['filter' => 'role:owner'], function ($routes) {
    $routes->get('dashboard', 'Owner\DashboardController::index');
    $routes->get('report/sales', 'Owner\ReportSalesController::index');
    $routes->get('report/sales/export', 'Owner\ReportSalesController::exportPdf');
    $routes->get('report/stock', 'Owner\ReportStockController::index');
    $routes->get('report/stock/export', 'Owner\ReportStockController::exportPdf');
    $routes->get('subscription', 'Owner\SubscriptionController::index');
    $routes->post('subscription/order', 'Owner\SubscriptionController::order');

    // Kasir accounts
    $routes->get('kasir', 'Owner\KasirController::index');
    $routes->get('kasir/new', 'Owner\KasirController::create');
    $routes->post('kasir/new', 'Owner\KasirController::store');
    $routes->get('kasir/(:num)/edit', 'Owner\KasirController::edit/$1');
    $routes->post('kasir/(:num)/edit', 'Owner\KasirController::update/$1');
    $routes->post('kasir/(:num)/delete', 'Owner\KasirController::delete/$1');
});

// Kasir routes
$routes->group('kasir', ['filter' => 'role:kasir'], function ($routes) {
    $routes->get('dashboard', 'Kasir\DashboardController::index');

    // Transactions
    $routes->get('transaction', 'Kasir\TransactionController::index');
    $routes->post('transaction', 'Kasir\TransactionController::store');
    $routes->get('transaction/history', 'Kasir\TransactionController::history');
    $routes->get('transaction/(:num)', 'Kasir\TransactionController::show/$1');
    $routes->get('transaction/(:num)/print', 'Kasir\TransactionController::printStruk/$1');

    // Products
    $routes->get('products', 'Kasir\ProductController::index');
    $routes->get('products/new', 'Kasir\ProductController::create');
    $routes->post('products/new', 'Kasir\ProductController::store');
    $routes->get('products/(:num)/edit', 'Kasir\ProductController::edit/$1');
    $routes->post('products/(:num)/edit', 'Kasir\ProductController::update/$1');
    $routes->post('products/(:num)/delete', 'Kasir\ProductController::delete/$1');
    $routes->get('products/(:num)/barcode', 'Kasir\ProductController::barcode/$1');
    $routes->get('products/search', 'Kasir\ProductController::search');

    // Categories
    $routes->get('categories', 'Kasir\CategoryController::index');
    $routes->get('categories/new', 'Kasir\CategoryController::create');
    $routes->post('categories/new', 'Kasir\CategoryController::store');
    $routes->get('categories/(:num)/edit', 'Kasir\CategoryController::edit/$1');
    $routes->post('categories/(:num)/edit', 'Kasir\CategoryController::update/$1');
    $routes->post('categories/(:num)/delete', 'Kasir\CategoryController::delete/$1');

    // Stock
    $routes->get('stock', 'Kasir\StockController::index');
});
