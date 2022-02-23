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
            $table->string('order_id')->nullable();
            $table->foreignId('package_id')->nullable()->constrained('packages')->cascadeOnDelete();
            $table->unsignedBigInteger('vendor_user_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name');
            $table->integer('quantity');
            $table->string('unit')->nullable();
            $table->double('unit_price', 8, 2);
            $table->double('subtotal_price', 15, 2);
            $table->double('shipping_charge', 8, 2);
            $table->double('total_price', 15, 2);
            // $table->enum('order_status', ['New', 'Verified', 'Cancel', 'Process', 'Delivered'])->default('New');
            $table->string('order_status')->nullable();
            $table->text('track_no')->nullable();
            
            // $table->foreign('vendor_user_id')->references('id')->on('users')->onDelete('SET NULL');
            // $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();

            $table->softDeletes();
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
