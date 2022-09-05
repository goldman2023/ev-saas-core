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
        Schema::create('product_addon_relationships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_addon_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('subject_type', 200);

            $table->index(['subject_id', 'subject_type']);
            $table->foreign('product_addon_id')->references('id')->on('product_addons')->onUpdate('cascade')->onDelete('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_addon_relationships');
    }
};
