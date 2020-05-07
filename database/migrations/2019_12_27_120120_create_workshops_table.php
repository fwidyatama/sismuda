<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('hull_code')->unsigned()->default(null)->onDelete('cascade');   
            $table->bigInteger('user_id')->unsigned()->default(null)->onDelete('cascade');
            $table->date('order_date');
            $table->integer('workshop_number')->default(1);
            $table->string('note');
            $table->string('work_type');
            $table->boolean('status')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('hull_code')->references('hull_code')->on('buses');
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
        Schema::dropIfExists('workshops');
    }
}
