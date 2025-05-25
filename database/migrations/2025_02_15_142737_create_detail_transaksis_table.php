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
            $table->foreignId('id_transaksi')
                  ->constrained('transaksis', 'id_transaksi')
                  ->cascadeOnDelete();
            $table->foreignId('id_paket')
                  ->constrained('pakets', 'id_paket')
                  ->restrictOnDelete();
            $table->date('tanggal_ambil');
            $table->time('jam_ambil');
            $table->integer('jumlah')->default(1);
            $table->decimal('sub_total', 12, 2);
            $table->decimal('total_diskon', 12, 2)->default(0);
            $table->text('keterangan')->nullable();
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
