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
        Schema::create('trx_barang_keluars', function (Blueprint $table) {
            $table->id('id_trx_brgkeluar');
            $table->foreignId('id_admin');
            $table->foreignId('id_barang');
            $table->date('tanggal_keluar');
            $table->string('unit', 50);
            $table->integer('jumlah_brgkeluar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_barang_keluars');
    }
};
