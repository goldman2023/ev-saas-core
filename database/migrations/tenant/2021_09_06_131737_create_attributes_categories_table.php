<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->index('category_id');
            $table->index('attribute_id');

            $table->integer('attribute_id');
            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes')->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('attributes_categories');
    }
};
