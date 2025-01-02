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
        Schema::create('trx_barang_masuk', function (Blueprint $table) {
            $table->id('id_trx_brgmasuk');
            $table->foreignId('id_barang')->constrained('barangs', 'id_barang');
            $table->date('tanggal_masuk');
            $table->string('nama_admin');
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_barang_masuk');
    }
};
