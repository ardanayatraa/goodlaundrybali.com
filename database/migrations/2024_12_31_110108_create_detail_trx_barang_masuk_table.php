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
        Schema::create('detail_trx_barang_masuk', function (Blueprint $table) {
            $table->id('id_detail_trx_brgmasuk');
            $table->unsignedBigInteger('id_trx_brgmasuk');
            $table->date('tanggal_masuk');
            $table->string('nama_admin');
            $table->string('nama_barang')->nullable();
            $table->integer('jumlah_brgmasuk')->nullable();
            $table->decimal('harga', 10, 2)->nullable();
            $table->decimal('total_harga', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_trx_barang_masuk');
    }
};
