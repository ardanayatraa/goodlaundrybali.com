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
        Schema::create('points', function (Blueprint $table) {
            $table->id('id_point');
            $table->string('no_telp', 50);
            $table->foreign('no_telp')->references('no_telp')->on('pelanggans')->cascadeOnDelete();
            $table->date('tanggal');
            $table->integer('jumlah_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
