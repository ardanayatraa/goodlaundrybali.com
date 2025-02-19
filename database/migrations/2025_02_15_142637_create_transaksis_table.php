<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_pelanggan');
            $table->foreignId('id_point')->nullable();
            $table->foreignId('id_paket');
            $table->date('tanggal_transaksi');
            $table->decimal('total_harga', 12, 2);
            $table->string('metode_pembayaran', 50);
            $table->string('status_pembayaran', 50);
            $table->string('status_transaksi', 50);
            $table->integer('jumlah_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
