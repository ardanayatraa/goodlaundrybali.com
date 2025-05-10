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
    { Schema::create('detail_transaksis', function (Blueprint $table) {
        $table->id('id_detail_transaksi');
        $table->foreignId('id_transaksi');
        $table->dateTime('tanggal_ambil');
        $table->time('jam_ambil');
        $table->integer('jumlah'); 
        $table->decimal('total_diskon', 12, 2);
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
