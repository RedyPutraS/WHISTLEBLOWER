<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulirpengaduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulirpengaduan', function (Blueprint $table) {
            $table->id('f_id');
            $table->string('f_noreg')->nullable();
            $table->string('f_token')->nullable();
            $table->string('f_tanggal_masuk');
            $table->string('f_nama')->nullable();
            $table->string('f_no_telepon')->nullable();
            $table->string('f_email')->nullable();
            $table->string('f_waktu_kejadian');
            $table->string('f_tempat_kejadian');
            $table->text('f_kronologi');
            $table->string('f_status')->default('Diterima');
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
        Schema::dropIfExists('formulirpengaduan');
    }
}
