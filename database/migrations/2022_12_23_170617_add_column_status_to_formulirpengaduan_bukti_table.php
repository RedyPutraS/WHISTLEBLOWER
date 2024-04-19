<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusToFormulirpengaduanBuktiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulirpengaduan_bukti', function (Blueprint $table) {
            $table->string('fb_status')->default('Bukti Awal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formulirpengaduan_bukti', function (Blueprint $table) {
            $table->dropColumn('fb_status');
        });
    }
}
