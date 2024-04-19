<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuangDiskusiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruang_diskusi', function (Blueprint $table) {
            $table->id('rd_id');
            $table->string('rd_noreg');
            $table->text('rd_pesan');
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
        Schema::dropIfExists('ruang_diskusi');
    }
}
