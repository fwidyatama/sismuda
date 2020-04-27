<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_permits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('hull_code')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('status');
            $table->string('note');
            $table->date('date');
            $table->foreign('hull_code')->references('hull_code')->on('buses');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('bus_permits');
    }
}
