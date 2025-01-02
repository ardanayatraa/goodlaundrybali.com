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
            $table->string('nama_pelanggan');
            $table->date('tanggal_transaksi');
            $table->decimal('total_harga', 10, 2);
            $table->string('metode_pembayaran');
            $table->string('status_pembayaran');
            $table->string('status_transaksi');
            $table->integer('jumlah_point')->default(0);
            $table->string('status_bonus')->nullable();
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
