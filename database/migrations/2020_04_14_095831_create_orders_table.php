<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('hull_code')->unsigned();
            $table->bigInteger('sparepart_id')->unsigned();
            $table->enum('type',['new','second']);
            $table->date('date');
            $table->integer('quantity');
            $table->string('unit_name');   
            $table->enum('status',['0','1','2'])->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('hull_code')->references('hull_code')->on('buses');
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
        Schema::dropIfExists('orders');
    }
}
