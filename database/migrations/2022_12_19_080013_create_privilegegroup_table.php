<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivilegeGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privilegegroup', function (Blueprint $table) {
            $table->id('pg_id');
            $table->string('pg_nama');
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
        Schema::dropIfExists('privilege_group');
    }
}
