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
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            // $table->integer('quantity')->nullable();
            $table->double('amount', 15,8)->nullable();
            $table->text('order_note')->nullable();
            $table->text('track_no')->nullable();
            $table->enum('payment_type', ['esewa', 'paypal', 'cash_on_delivery', 'tt'] );
            $table->enum('status', ['New', 'Verified', 'Cancel', 'Process', 'Delivered'] )->default('New');

            $table->string('payment_status')->nullable();

            // //BILLING DETAIL
            // $table->string('first_name')->nullable();
            // $table->string('last_name')->nullable();
            // $table->string('company_name')->nullable();
            // $table->string('vat')->nullable();
            // $table->string('phone')->nullable();
            // $table->string('email')->nullable();

            // //ADDRESS
            // $table->string('country')->nullable();
            // $table->string('street_address')->nullable();
            // $table->string('nearest_landmark')->nullable();
            // $table->string('town')->nullable();

            // //SHIP TO DIFFERENT ADDRESS
            // $table->string('ship_first_name')->nullable();
            // $table->string('ship_last_name')->nullable();
            // $table->string('ship_company_name')->nullable();
            // $table->string('ship_vat')->nullable();
            // $table->string('ship_phone')->nullable();
            // $table->string('ship_email')->nullable();

            //SHIPPING ADDRESS
            // $table->string('ship_country')->nullable();
            // $table->string('ship_street_address')->nullable();
            // $table->string('ship_nearest_landmark')->nullable();
            // $table->string('ship_town')->nullable();

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
