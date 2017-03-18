<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_infos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unasigned();

            $table->text('billing_name');
            $table->text('company_name');
            $table->text('business_id');
            $table->text('tax_number');
            $table->text('address');
            $table->text('city');
            $table->text('country');
            $table->text('email_invoice');
            $table->text('bank_account');

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
        Schema::dropIfExists('billing_infos');
    }
}
