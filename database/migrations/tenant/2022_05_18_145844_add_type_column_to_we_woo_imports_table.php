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
        Schema::table('we_woo_imports', function (Blueprint $table) {
            //
            $table->string('type')->default('product');
            $table->string('status')->default('imported');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('we_woo_imports', function (Blueprint $table) {
            //
        });
    }
};
