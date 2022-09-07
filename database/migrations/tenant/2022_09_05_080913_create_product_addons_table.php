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
        Schema::create('product_addons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('type', 100)->default('standard');
            $table->string('slug', 255)->unique();
            $table->integer('shop_id');
            $table->unsignedInteger('user_id');
            $table->string('status', 50)->default('draft')->index();
            $table->double('unit_price')->nullable();
            $table->string('base_currency', 10)->default('EUR');
            $table->double('discount')->nullable();
            $table->string('discount_type', 10)->nullable();
            $table->string('unit')->default('pc')->nullable();
            $table->string('excerpt', 500)->nullable();
            $table->longText('description')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();


            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_addons');
    }
};
