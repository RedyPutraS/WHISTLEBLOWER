<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToRuangDiskusiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ruang_diskusi', function (Blueprint $table) {
            $table->unsignedBigInteger('d_id');
            $table->foreign('d_id')->references('d_id')->on('diskusi')->onDelete('cascade');
            $table->string('rd_tipe_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ruang_diskusi', function (Blueprint $table) {
            //
        });
    }
}
