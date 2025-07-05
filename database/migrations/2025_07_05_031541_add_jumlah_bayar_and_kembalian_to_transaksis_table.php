<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations: tambah field jumlah_bayar dan kembalian.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // setelah total_harga
            $table->decimal('jumlah_bayar', 12, 2)
                  ->default(0)
                  ->after('total_harga');
            // setelah jumlah_bayar
            $table->decimal('kembalian', 12, 2)
                  ->default(0)
                  ->after('jumlah_bayar');
        });
    }

    /**
     * Reverse the migrations: hapus kedua field.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['jumlah_bayar', 'kembalian']);
        });
    }
};
