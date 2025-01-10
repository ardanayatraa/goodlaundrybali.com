<?php // routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
 
    $trail->push('', route('dashboard'));
});

// Home > Stok Barang
Breadcrumbs::for('stok-barang', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Stok Barang', route('stok-barang'));
});

// Home > Stok Barang > Data Barang
Breadcrumbs::for('data-barang', function (BreadcrumbTrail $trail) {
    $trail->parent('stok-barang');
    $trail->push('Data Barang', route('data-barang'));
});

// Home > Stok Barang > Barang Masuk
Breadcrumbs::for('barang-masuk', function (BreadcrumbTrail $trail) {
    $trail->parent('stok-barang');
    $trail->push('Barang Masuk', route('barang-masuk'));
});

// Home > Stok Barang > Barang Keluar
Breadcrumbs::for('barang-keluar', function (BreadcrumbTrail $trail) {
    $trail->parent('stok-barang');
    $trail->push('Barang Keluar', route('barang-keluar'));
});


// Home > Transaksi
Breadcrumbs::for('transasksi', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Transaksi', route('transasksi'));
});

// Home > Paket
Breadcrumbs::for('paket', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Paket', route('paket'));
});

// Home > Pelanggan
Breadcrumbs::for('pelanggan', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Pelanggan', route('pelanggan'));
});

// Home > Barang
Breadcrumbs::for('barang', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Barang', route('barang'));
});

// Home > Report
Breadcrumbs::for('report', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Report', route('report'));
});

