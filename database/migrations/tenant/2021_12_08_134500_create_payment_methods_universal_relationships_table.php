<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods_universal_relationships', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id');
            $table->unsignedBigInteger('upm_id')->comment('Universal payment method ID');
            $table->tinyInteger('enabled');

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('upm_id')->references('id')->on('payment_methods_universal')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods_universal_relationships');
    }
};
