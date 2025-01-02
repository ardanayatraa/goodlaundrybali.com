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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id('id_detail_transaksi');
            $table->foreignId('id_transaksi')->constrained('transaksis', 'id_transaksi')->onDelete('cascade');
            $table->date('tanggal_transaksi');
            $table->string('nama_pelanggan');
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('metode_pembayaran');
            $table->string('status_pembayaran');
            $table->string('status_transaksi');
            $table->date('tanggal_ambil');
            $table->string('jenis_paket');
            $table->decimal('berat', 8, 2);
            $table->decimal('harga', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->decimal('total_diskon', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
