<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('seller_packages')) return;
        Schema::create('seller_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->double('amount', 11, 2)->nullable(false)->default(0.00);
            $table->integer('product_upload')->nullable(false)->default(0);
            $table->integer('digital_product_upload')->nullable(false)->default(0);
            $table->string('logo')->nullable(true);
            $table->integer('duration')->nullable(false)->default(0);
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
        Schema::dropIfExists('seller_packages');
    }
}
