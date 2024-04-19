<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToFormulirpengaduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulirpengaduan', function (Blueprint $table) {
            $table->string('f_sumber')->default('FORM');
            $table->dropColumn('f_status');
            $table->unsignedBigInteger('s_id');
            $table->foreign('s_id')->references('s_id')->on('status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formulirpengaduan', function (Blueprint $table) {
            $table->dropColumn('f_sumber');
            $table->dropColumn('s_id');
        });
    }
}
