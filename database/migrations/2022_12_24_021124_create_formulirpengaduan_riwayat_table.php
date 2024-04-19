<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulirpengaduanRiwayatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulirpengaduan_riwayat', function (Blueprint $table) {
            $table->id('fr_id');
            $table->unsignedBigInteger('f_id');
            $table->foreign('f_id')->references('f_id')->on('formulirpengaduan')->onDelete('cascade');
            $table->string('fr_tanggal');
            $table->string('fr_status');
            $table->string('fr_keterangan')->nullable();
            $table->string('fr_file_bukti_investigasi')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('created_by')->default('Sistem');
            $table->string('updated_by')->default('Sistem');
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
        Schema::dropIfExists('formulirpengaduan_riwayat');
    }
}
