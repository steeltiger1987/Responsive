<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("bids", function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->integer('car_id');
            $table->float('bid');
            $table->boolean('ride_along')->default(0);
            $table->integer('ride_along_client')->default(0);
            $table->boolean('movers')->default(0);
            $table->integer('movers_count')->default(0);
            $table->boolean('spolumoving')->default(0);
            $table->unique(['user_id', 'order_id']);
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
        Schema::dropIfExists('bids');
    }
}
