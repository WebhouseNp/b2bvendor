<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Category
            $table->enum('category',['local_seller','international_seller']);
            

            // Plan
            $table->enum('plan',['basic_plan','standard_plan','premium_plan']);
            

            // General Information
            $table->string('shop_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('representative_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('product_category')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();

            //country
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            // Main Contact
            $table->string('name_on_card')->nullable();
            $table->string('id_card_number')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('mobile_number')->nullable();

            // Commission rate
            $table->string('category_commission')->nullable();
            $table->string('percentage')->nullable();

            // Payment Information
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('name_on_bank_acc')->nullable();
            $table->string('paypal_id')->nullable();

            // Operation Information
            $table->string('store_location')->nullable();
            $table->string('store_contact_number')->nullable();

            $table->enum('status',[1,0])->default(1);

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
        Schema::dropIfExists('vendors');
    }
}
