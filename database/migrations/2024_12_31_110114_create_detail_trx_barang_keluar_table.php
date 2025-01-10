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
        Schema::create('detail_trx_barang_keluar', function (Blueprint $table) {
            $table->id('id_detail_trx_brgkeluar');
            $table->unsignedBigInteger('id_trx_brgkeluar');
            $table->date('tanggal_keluar');
            $table->string('nama_admin');
            $table->string('nama_barang')->nullable();
            $table->integer('jumlah_brgkeluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_trx_barang_keluar');
    }
};
