<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('pelanggans', function (Blueprint $table) {
                $table->timestamp('member_start_at')
                      ->nullable()
                      ->comment('Tanggal mulai jadi member');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
         $table->dropColumn('member_start_at');
        });
    }
};
