<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unasigned();
            $table->text('name');
            $table->text('size')->nullable();
            $table->text('length')->nullable();
            $table->text('width')->nullable();
            $table->text('height')->nullable();
            $table->integer('amount')->default(1);
            $table->text('description')->nullable();
            $table->text('type');
            $table->boolean('assemb_dissasemb_need')->default(false);
            $table->boolean('fit_to_elevator')->default(false);
            $table->boolean('packaking_need')->default(false);
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
        Schema::dropIfExists('items');
    }
}
