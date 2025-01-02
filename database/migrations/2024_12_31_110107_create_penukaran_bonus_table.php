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
      
        Schema::create('penukaran_bonus', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('id_pelanggan')->constrained('pelanggans', 'id_pelanggan');
            $table->integer('jumlah_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penukaran_bonus');
    }
};
