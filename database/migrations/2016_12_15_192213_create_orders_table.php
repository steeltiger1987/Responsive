<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            /* This used for initial creation, default value necessary only for user_id, because it is not created */

            $table->increments('id');
            $table->integer('user_id')->unsigned()->default(0);
            $table->text('pickup_address');
            $table->text('pickup_street');
            $table->text('pickup_house_number');
            $table->text('pickup_city');
            $table->text('pickup_zip');
            $table->text('pickup_country');
            $table->text('pickup_lat');
            $table->text('pickup_long');
            $table->text('pickup_administrative_area');
            $table->integer('pickup_floor');
            $table->text('pickup_elevator');
            $table->text('drop_off_address');
            $table->text('drop_off_street');
            $table->text('drop_off_house_number');
            $table->text('drop_off_city');
            $table->text('drop_off_zip');
            $table->text('drop_off_country');
            $table->text('drop_off_lat');
            $table->text('drop_off_long');
            $table->text('drop_off_administrative_area');
            $table->integer('drop_off_floor');
            $table->text('drop_off_elevator');

            $table->integer('helper_count')->default(0);
            $table->boolean('will_help')->default(false);
            $table->text('move_comments')->nullable();

            $table->text('time_pick_up')->nullable();
            $table->text('time_pick_up_interval')->nullable();

            $table->text('time_drop_off')->nullable();
            $table->text('time_drop_off_interval')->nullable();

            $table->text('pick_up_dates')->nullable();
            $table->text('drop_off_dates')->nullable();

            $table->text('expiration_date')->nullable();
            $table->text('distance')->nullable();
            $table->text('old_time')->nullable();
            $table->text('note')->default('');
            $table->string('status')->default('active');

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
