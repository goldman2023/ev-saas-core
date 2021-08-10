<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('address_id')->default(0);
            $table->integer('product_id')->nullable();
            $table->text('variation')->nullable();
            $table->double('price', 8, 2)->nullable()->default(0.00);
            $table->double('tax', 8, 2)->nullable()->default(0.00);
            $table->double('shipping_cost', 8, 2)->nullable()->default(0.00);
            $table->double('discount', 10, 2)->default(0.00);
            $table->string('coupon_code', 255);
            $table->tinyInteger('coupon_applied')->default(0);
            $table->integer('quantity')->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
