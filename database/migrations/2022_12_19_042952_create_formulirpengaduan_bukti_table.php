<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulirpengaduanBuktiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulirpengaduan_bukti', function (Blueprint $table) {
            $table->id('fb_id');
            $table->unsignedBigInteger('f_id');
            $table->foreign('f_id')->references('f_id')->on('formulirpengaduan')->onDelete('cascade');
            $table->string('fb_file_bukti')->nullable();
            $table->string('fb_keterangan')->nullable();
            $table->string('created_by')->default('Sistem');
            $table->string('updated_by')->default('Sistem');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulirpengaduan_bukti');
    }
}
