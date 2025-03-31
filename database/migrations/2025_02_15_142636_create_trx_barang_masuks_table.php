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
        Schema::create('trx_barang_masuks', function (Blueprint $table) {
            $table->id('id_trx_brgmasuk');
            $table->foreignId('id_admin');
            $table->foreignId('id_barang');
            $table->date('tanggal_masuk');
            $table->decimal('harga', 12, 2);
            $table->decimal('total_harga', 12, 2);
            $table->integer('jumlah_brgmasuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_barang_masuks');
    }
};
