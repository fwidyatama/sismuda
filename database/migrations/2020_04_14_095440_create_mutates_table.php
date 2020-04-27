<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('sparepart_id')->unsigned();
            $table->enum('type',['entry','out']);
            $table->date('entry_date')->nullable();
            $table->date('out_date')->nullable();
            $table->integer('quantity');
            $table->string('unit_name');   
            $table->integer('price');
            $table->foreign('user_id')->references('id')->on('users');    
            $table->foreign('sparepart_id')->references('id')->on('spareparts');    
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
        Schema::dropIfExists('mutates');
    }
}
