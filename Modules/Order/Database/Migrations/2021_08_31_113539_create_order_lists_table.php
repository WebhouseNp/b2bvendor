<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_user_id')->nullable();
            $table->unsignedBigInteger('product_id');
            // $table->unsignedBigInteger('customer_id');
            $table->integer('quantity')->nullable();
            $table->double('unit_price', 15, 8);
            $table->double('subtotal_price', 15, 8);
            // $table->string('phone')->nullable();
            $table->enum('order_status', ['New', 'Verified', 'Cancel', 'Process', 'Delivered'])->default('New');
            $table->string('order_id')->nullable();
            $table->text('track_no')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
            $table->foreign('vendor_user_id')->references('id')->on('users')->onDelete('SET NULL');
            // $table->foreign('customer_id')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('order_lists');
    }
}
