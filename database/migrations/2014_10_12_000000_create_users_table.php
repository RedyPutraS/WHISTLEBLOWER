<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('u_id');
            $table->string('u_nama');
            $table->string('u_username');
            $table->string('u_email')->nullable();
            $table->string('u_password');
            $table->string('u_password_raw');
            $table->timestamp('u_last_login')->useCurrent();
            $table->unsignedBigInteger('r_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('created_by')->default('Sistem');
            $table->string('updated_by')->default('Sistem');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
