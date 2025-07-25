<?php // routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Carbon;
// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

$models = [
    'Barang',
    'DetailTransaksi',
    'Paket',
    'Pelanggan',
    'Point',
    'Transaksi',
    'TrxBarangKeluar',
    'TrxBarangMasuk',
    'Unit',
];

foreach ($models as $model) {
    $routeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $model));

    // Home > Model
    Breadcrumbs::for($routeName, function (BreadcrumbTrail $trail) use ($routeName) {
        $trail->parent('home');
        $trail->push(ucwords(str_replace('-', ' ', $routeName)), route($routeName));
    });

    // Home > Model > Add
    Breadcrumbs::for("{$routeName}.add", function (BreadcrumbTrail $trail) use ($routeName) {
        $trail->parent($routeName);
        $trail->push('Tambah', route("{$routeName}.add"));
    });

    // Home > Model > Edit
    Breadcrumbs::for("{$routeName}.edit", function (BreadcrumbTrail $trail, $id) use ($routeName) {
        $trail->parent($routeName);
        $trail->push('Edit', route("{$routeName}.edit", $id));
    });

}

    // Home > Report
    Breadcrumbs::for('report.barang', function (BreadcrumbTrail $trail) {
        $trail->parent('home');
        $trail->push('Laporan Barang', route('laporan-stok-barang'));
    });

    // routes/breadcrumbs.php

Breadcrumbs::for('report.pelanggan', function ($trail) {
    $trail->parent('home'); // ganti sesuai struktur kamu
    $trail->push('Laporan Pelanggan Member', route('laporan-pelanggan'));
});


    // Home > Transaksi > Detail
Breadcrumbs::for('transaksi.detail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('transaksi');
    $trail->push('Detail Transaksi', route('transaksi.detail', $id));
});

// Home > Trx Barang Keluar > Detail
Breadcrumbs::for('trx-barang-keluar.detail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('trx-barang-keluar');
    $trail->push("Detail #{$id}", route('trx-barang-keluar.detail', $id));
});


// Home > Trx Barang Keluar > Detail By Date
Breadcrumbs::for('trx-barang-keluar.by-date', function (BreadcrumbTrail $trail, $tanggal) {
    $trail->parent('trx-barang-keluar');
    $trail->push(
        'Detail ' . Carbon::parse($tanggal)->isoFormat('D MMMM YYYY'),
        route('trx-barang-keluar.by-date', $tanggal)
    );
});
// Home > Trx Barang Masuk > Detail
Breadcrumbs::for('trx-barang-masuk.detail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('trx-barang-masuk');
    $trail->push("Detail #{$id}", route('trx-barang-masuk.detail', $id));
});

Breadcrumbs::for('trx-barang-masuk.by-date', function (\Diglactic\Breadcrumbs\Generator $trail, $tanggal) {
    $trail->parent('trx-barang-masuk');
    $trail->push(
        'Detail ' . Carbon::parse($tanggal)->isoFormat('D MMMM YYYY'),
        route('trx-barang-masuk.by-date', $tanggal)
    );
});
    Breadcrumbs::for('report.transaksi', function (BreadcrumbTrail $trail) {
        $trail->parent('home');
        $trail->push('Laporan Transaksi', route('laporan-transaksi'));
    });

