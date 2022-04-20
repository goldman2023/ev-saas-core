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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->nullable();
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->string('excerpt', 300)->nullable();
            $table->longText('content')->nullable();
            $table->string('status', 50)->default('draft')->index(); // can be: published, draft, private, pending

            $table->json('features')->nullable();
            $table->double('price');
            $table->double('discount')->default(0)->nullable();
            $table->string('discount_type')->nullable();
            $table->double('tax')->default(0)->nullable();
            $table->string('tax_type')->nullable();
            $table->integer('num_of_sales')->default(0);

            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
            $table->index('updated_at');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
