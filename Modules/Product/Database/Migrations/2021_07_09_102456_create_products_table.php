<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->double('shipping_charge', 15, 8)->nullable();
            $table->text('highlight')->nullable();
            $table->text('description')->nullable();
            $table->string('video_link')->nullable();
            // $table->unsignedBigInteger('category_id')->nullable();
            // $table->unsignedBigInteger('subcategory_id')->nullable();
            // $table->unsignedBigInteger('offer_id')->nullable();
            // $table->unsignedBigInteger('brand_id')->nullable();
            // $table->float('discount')->nullable();
            // $table->double('price', 15, 8)->nullable();
            // $table->unsignedInteger('moq')->nullable();
            // $table->unsignedInteger('delivery_charge')->nullable();
            // $table->boolean('essential', [0, 1])->default(0);
            // $table->boolean('best_seller', [0, 1])->default(0);
            $table->string('image')->nullable();
            // $table->string('quantity')->nullable();
            $table->text('non_approval_note')->nullable();
            // $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('status')->default(true);          
            $table->boolean('is_top')->default(false);
            $table->boolean('is_new_arrival')->default(false);

            //Quick Details
            $table->json('overview')->nullable();

            //SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyphrase')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('CASCADE');
            // $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('CASCADE');
            // $table->foreign('offer_id')->references('id')->on('offers')->onDelete('CASCADE');
            // $table->foreign('brand_id')->references('id')->on('brands')->onDelete('CASCADE');

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
        Schema::dropIfExists('products');
    }
}
