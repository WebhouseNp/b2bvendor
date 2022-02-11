<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('transactions', function (Blueprint $table) {
            $table->id()->from(20000);
            $table->unsignedBigInteger('vendor_user_id')->nullable();
            $table->tinyInteger('type')->index();
            $table->double('amount', 8, 2);
            $table->double('running_balance', 8, 2);
            $table->text('remarks')->nullable();
            $table->boolean('is_cod')->nullable();
            $table->dateTime('settled_at')->nullable();
            $table->timestamps();
        });
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
