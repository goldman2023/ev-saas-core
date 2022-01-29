<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorCategoriesTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->index('featured');
            $table->index('level');
            $table->dropColumn('banner');
            $table->dropColumn('icon');
        });

        Schema::table('category_translations', function (Blueprint $table) {
            $table->integer('category_id')->change();
            $table->string('meta_title', 255)->after('lang')->nullable();
            $table->text('meta_description')->after('meta_title')->nullable();

            $table->index('lang');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
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
