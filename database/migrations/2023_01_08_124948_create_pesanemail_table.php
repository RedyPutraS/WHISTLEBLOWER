<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanemailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanemail', function (Blueprint $table) {
            $table->id('pe_id');
            $table->text('pe_subject');
            $table->text('pe_toaddress');
            $table->text('pe_fromaddress');
            $table->string('pe_msgno');
            $table->string('pe_date');
            $table->string('pe_udate');
            $table->text('pe_attachment');
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
        Schema::dropIfExists('pesanemail');
    }
}
