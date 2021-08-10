<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_relationships', function (Blueprint $table) {
            $table->id();
            $table->morphs('subject');
            $table->integer('review_id');
            $table->foreign('review_id')->references('id')->on('reviews')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->unsignedInteger('creator_id')->default(1);
            $table->foreign('creator_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('review_relationships');
    }
}
