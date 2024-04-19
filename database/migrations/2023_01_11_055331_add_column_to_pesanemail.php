<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPesanemail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pesanemail', function (Blueprint $table) {
            $table->text('pe_messagebody');
            $table->text('pe_fromname');
            $table->dropColumn('pe_toaddress');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pesanemail', function (Blueprint $table) {
            $table->dropColumn('pe_messagebody');
            $table->dropColumn('pe_fromname');
        });
    }
}
