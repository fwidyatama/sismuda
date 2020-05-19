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
            $table->integer('workshop_number');
            $table->string('note');
            $table->date('date');
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
