<?php

use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Client;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportBarangController;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Transaksi;
use App\Http\Controllers\ReportController;
use Spatie\Browsershot\Browsershot;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('dashboard');
    }
    return view('login-admin');
});
Route::get('/login', function () {
    abort(404);
});
Route::get('/register', function () {
    abort(404);
});


Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware('admin')->group(function () {
    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Barang
    Route::get('/barang', function () {
        return view('page.barang.index');
    })->name('barang');
    Route::get('/barang/add', function () {
        return view('page.barang.add');
    })->name('barang.add');
    Route::get('/barang/edit/{id}', function ($id) {
        return view('page.barang.edit', compact('id'));
    })->name('barang.edit');



    // Paket
    Route::get('/paket', function () {
        return view('page.paket.index');
    })->name('paket');
    Route::get('/paket/add', function () {
        return view('page.paket.add');
    })->name('paket.add');
    Route::get('/paket/edit/{id}', function ($id) {
        return view('page.paket.edit', compact('id'));
    })->name('paket.edit');

    // Pelanggan
    Route::get('/pelanggan', function () {
        return view('page.pelanggan.index');
    })->name('pelanggan');
    Route::get('/pelanggan/add', function () {
        return view('page.pelanggan.add');
    })->name('pelanggan.add');
    Route::get('/pelanggan/edit/{id}', function ($id) {
        return view('page.pelanggan.edit', compact('id'));
    })->name('pelanggan.edit');



    // Transaksi
    Route::get('/transaksi', function () {
        return view('page.transaksi.index');
    })->name('transaksi');
    Route::get('/transaksi/add', function () {
        return view('page.transaksi.add');
    })->name('transaksi.add');
    Route::get('/transaksi/edit/{id}', function ($id) {
        return view('page.transaksi.edit', compact('id'));
    })->name('transaksi.edit');
    Route::get('/transaksi/detail/{id}', function ($id) {
        return view('page.transaksi.detail', compact('id'));
    })->name('transaksi.detail');


    // Trx Barang Keluar
    Route::get('/trx-barang-keluar', function () {
        return view('page.trx-barang-keluar.index');
    })->name('trx-barang-keluar');
    Route::get('/trx-barang-keluar/add', function () {
        return view('page.trx-barang-keluar.add');
    })->name('trx-barang-keluar.add');
    Route::get('/trx-barang-keluar/edit/{id}', function ($id) {
        return view('page.trx-barang-keluar.edit', compact('id'));
    })->name('trx-barang-keluar.edit');

    Route::get('/trx-barang-keluar/detail/{id}', function ($id) {
        return view('page.trx-barang-keluar.detail', compact('id'));
    })->name('trx-barang-keluar.detail');


    // Trx Barang Masuk
    Route::get('/trx-barang-masuk', function () {
        return view('page.trx-barang-masuk.index');
    })->name('trx-barang-masuk');
    Route::get('/trx-barang-masuk/add', function () {
        return view('page.trx-barang-masuk.add');
    })->name('trx-barang-masuk.add');
    Route::get('/trx-barang-masuk/edit/{id}', function ($id) {
        return view('page.trx-barang-masuk.edit', compact('id'));
    })->name('trx-barang-masuk.edit');
    Route::get('/trx-barang-masuk/detail/{id}', function ($id) {
        return view('page.trx-barang-masuk.detail', compact('id'));
    })->name('trx-barang-masuk.detail');

    Route::get('/trx-barang-masuk/date/{tanggal}', function ($tanggal) {
    return view('page.trx-barang-masuk.detail-by-date', compact('tanggal'));
})->name('trx-barang-masuk.by-date');


// Detail per-Tanggal Barang Keluar
Route::get('/trx-barang-keluar/date/{tanggal}', function ($tanggal) {
    return view('page.trx-barang-keluar.detail-by-date', compact('tanggal'));
})->name('trx-barang-keluar.by-date');

    // Unit
    Route::get('/unit', function () {
        return view('page.unit.index');
    })->name('unit');
    Route::get('/unit/add', function () {
        return view('page.unit.add');
    })->name('unit.add');
    Route::get('/unit/edit/{id}', function ($id) {
        return view('page.unit.edit', compact('id'));
    })->name('unit.edit');

    // Laporan
    Route::get('report-barang', function () {
        return view('page.report-barang.index');
    })->name('laporan-stok-barang');
    Route::get('report-transaksi', function () {
        return view('page.report.index');
    })->name('laporan-transaksi');
    Route::get('report-pelanggan', function () {
        return view('page.report.pelanggan');
    })->name('laporan-pelanggan');

    // Cetak Member
    Route::get('/pelanggan/cetak/{id}', [ActionController::class, 'printMember'])
        ->name('pelanggan.cetak');

        Route::get('/transaksi/cetak/{id}', [ActionController::class, 'cetakTransaksi'])
        ->name('transaksi.cetak');


// Cetak Barang Keluar
Route::get('/trx-barang-keluar/cetak/{id}', [ActionController::class, 'cetakBarangKeluar'])
->name('trx-barang-keluar.cetak');

Route::get('/trx-barang-masuk/cetak/date/{tanggal}', [ActionController::class, 'cetakBarangMasukByDate'])
     ->name('trx-barang-masuk.print-by-date');


Route::get('/trx-barang-keluar/cetak/date/{tanggal}', [ActionController::class, 'cetakBarangKeluarByDate'])
     ->name('trx-barang-keluar.print-by-date');

// Cetak Barang Masuk
Route::get('/trx-barang-masuk/cetak/{id}', [ActionController::class, 'cetakBarangMasuk'])
->name('trx-barang-masuk.cetak');

    // Generate Reports
    Route::get('/report-transaksi/generate', [ReportController::class, 'generate'])
        ->name('report.generate');
    Route::get('/report-barang/generate', [ReportBarangController::class, 'generate'])
        ->name('report-barang.generate');

        Route::get('/report/pelanggan/generate', [ReportController::class, 'generatePelanggan'])->name('report-pelanggan.generate');

});





Route::get('/transaksi/{id}/image', function ($id) {
    $transaksi = Transaksi::with([
        'pelanggan',

        'detailTransaksi.paket.unitPaket'  // load paket & unit
    ])->findOrFail($id);

    return view('transaksi.template', compact('transaksi'));
})->name('transaksi.image');

Route::get('/g', function () {
    // Dummy data untuk transaksi
    $transaksi = (object)[
        'id_transaksi' => '123456',
        'tanggal_transaksi' => now(),
        'metode_pembayaran' => 'Qris',
        'status_pembayaran' => 'lunas',
        'point' => (object)[
            'jumlah' => 10
        ],
        'keterangan' => 'Pembayaran berhasil',
        'total_harga' => 150000,
        'detailTransaksi' => [
            (object)[
                'jumlah' => 2,
                'total_diskon' => 10000
            ]
        ]
    ];

    // Render HTML dari view Blade
    $htmlContent = view('transaksi.test', ['transaksi' => 1])->render();

    // Tentukan path untuk menyimpan gambar
    $filePath = storage_path('app/public/struk-laundry.jpg');

    // Konversi HTML ke JPG
    Browsershot::html($htmlContent)
        ->setOption('width', 768) // Tentukan lebar gambar
        ->setOption('height', 1024) // Tentukan tinggi gambar
        ->setOption('fullPage', true) // Tangkap seluruh halaman
        ->save($filePath);


});




Route::get('/send-test', function () {
    // Data yang akan dikirim ke bot
    $payload = [
        'number'  => '6285172003970',           // ganti dengan nomor tujuan
        'message' => 'Ini pesan test dari Laravel',
         'mediaUrl' =>"http://127.0.0.1:8000/storage/transaksi_10.png"
    ];

    // Panggil API WhatsApp Bot
    $response = Http::post('http://13.211.150.196/send-message', $payload);

    // Cek apakah sukses
    if ($response->successful()) {
        return response()->json([
            'status'  => 'ok',
            'message' => 'Pesan terkirim',
            'data'    => $response->json()
        ]);
    }

    // Kalau error
    return response()->json([
        'status'  => 'error',
        'message' => 'Gagal kirim pesan',
        'error'   => $response->body()
    ], $response->status());
});
