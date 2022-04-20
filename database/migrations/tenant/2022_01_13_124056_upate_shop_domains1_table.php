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
        Schema::table('shop_domains', function (Blueprint $table) {
            $table->string('theme', 250)->after('domain')->nullable(true);
            $table->string('language', 50)->after('theme')->default('en')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_domains', function (Blueprint $table) {
            $table->dropColumn('theme');
            $table->dropColumn('language');
        });
    }
};
