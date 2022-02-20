<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnDeleteCascadeAttributeRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('attribute_value_translations', function (Blueprint $table) {
            $table->dropForeign(['attribute_value_id']);
            $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onDelete('cascade')->onUpdate('cascade');
        });


        Schema::table('attribute_relationships', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
            $table->dropForeign(['attribute_value_id']);
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('attribute_translations', function (Blueprint $table) {
            // $table->dropForeign(['attribute_value_id']);
            $table->integer('attribute_id')->change();
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
