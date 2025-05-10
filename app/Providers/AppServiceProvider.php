<?php

namespace App\Providers;

use App\Models\Transaksi;
use Illuminate\Support\ServiceProvider;
use App\Models\TrxBarangKeluar;
use App\Observers\TrxBarangKeluarObserver;
use App\Models\TrxBarangMasuk;
use App\Observers\TransaksiObserver;
use App\Observers\TrxBarangMasukObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // TrxBarangKeluar::observe(TrxBarangKeluarObserver::class);
        // TrxBarangMasuk::observe(TrxBarangMasukObserver::class);
        Transaksi::observe(TransaksiObserver::class);
    }
}
