<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id');
            $table->string('address', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zip_code', 255)->nullable();
            $table->json('phones')->nullable();
            $table->json('features')->nullable();
            $table->json('location')->nullable();
            $table->tinyInteger('is_primary')->default(0);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_addresses');
    }
}
