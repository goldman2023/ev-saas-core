<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerPackageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('seller_package_translations')) return;
        Schema::create('seller_package_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seller_package_id');
            $table->string('name',50);
            $table->string('lang',100);
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
        Schema::dropIfExists('seller_package_translations');
    }
}
