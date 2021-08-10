<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_relationships', function (Blueprint $table) {
            $table->id();
            $table->morphs('subject');
            $table->integer('attribute_id');
            $table->unsignedBigInteger('attribute_value_id');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**ssh
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_relationships');
    }
}
