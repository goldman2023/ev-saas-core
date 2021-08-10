<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValueTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_value_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_value_id');
            $table->string('name', 50);
            $table->string('lang', 100);
            $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('attribute_value_translations');
    }
}
