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
        Schema::table('product_translations', function (Blueprint $table) {
            $table->string('excerpt', 320)->after('description');
            $table->string('meta_title', 255)->after('excerpt');
            $table->string('meta_description', 500)->after('meta_title');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('meta_title', 255)->change();
            $table->string('meta_description', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_translations', function (Blueprint $table) {
            $table->dropColumn('excerpt');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->mediumText('meta_title', 255)->change();
            $table->longText('meta_description', 500)->change();
        });
    }
};
