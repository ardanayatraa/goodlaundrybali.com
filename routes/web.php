<?php

use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Client;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Auth;

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

    // Dashboard Routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');
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
        'UnitPaket'
    ];
    
    foreach ($models as $model) {
        $routeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $model)); 
    
        Route::get("/{$routeName}", function () use ($routeName) {
            return view("page.{$routeName}.index");
        })->name("{$routeName}");
    
        Route::get("/{$routeName}/add", function () use ($routeName) {
            return view("page.{$routeName}.add");
        })->name("{$routeName}.add");
    
        Route::get("/{$routeName}/edit/{id}", function ($id) use ($routeName) {
            return view("page.{$routeName}.edit", compact('id'));
        })->name("{$routeName}.edit");
    }


    // Report Routes
    Route::get('report', function () {
        return 1;
    })->name('report');
});


Route::get('/send-wa', function () {
    $sid    = env('TWILIO_SID');               // SID Twilio
    $token  = env('TWILIO_TOKEN');            // Token Twilio
    $from   = env('TWILIO_WHATSAPP_FROM');    // Nomor WhatsApp Twilio
    $to     = "whatsapp:+6285172003970";      // Nomor tujuan
    $twilio = new Client($sid, $token);

    // Data untuk pesan
    $data = [
        'title'       => 'Good Laundry',
        'nota'        => '#Z495A/11060',
        'tanggal'     => '2024-12-23 17:03:00',
        'pembayaran'  => 'belum_bayar',
        'status'      => 'Proses',
        'nama'        => 'Kak ardana (085179799415)',
        'estimasi'    => '1 Hari 2024-12-24',
        'catatan'     => '',
        'detail'      => 'Express (Rp7.000 x 3Kg)',
        'subtotal'    => 'Rp21.000',
        'total'       => 'Rp21.000',
        'footer'      => 'Terimakasih',
    ];

    // Format pesan
    $messageBody = "{$data['title']}
------------------------------
No Nota : {$data['nota']}
Tanggal : {$data['tanggal']}
Pembayaran : {$data['pembayaran']}
Status : {$data['status']}
Nama : {$data['nama']}
Est : {$data['estimasi']}
Note : {$data['catatan']}
----------------------------
{$data['detail']}
{$data['subtotal']}
------------------------------
SubTotal : {$data['subtotal']}
Total : {$data['total']}

------------------------------
{$data['footer']}
------------------------------";

    try {
        // Kirim pesan WhatsApp
        $message = $twilio->messages->create(
            $to,
            [
                "from" => $from,
                "body" => $messageBody,
            ]
        );

        return response()->json(['success' => true, 'messageSid' => $message->sid]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
});
