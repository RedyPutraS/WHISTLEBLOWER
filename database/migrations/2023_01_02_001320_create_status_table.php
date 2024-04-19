<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id('s_id');
            $table->string('s_nama');
            $table->string('s_warna_background');
            $table->string('s_warna_teks');
            $table->string('s_label')->default('Global');
            $table->string('s_keterangan')->nullable();
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
        Schema::dropIfExists('status');
    }
}
