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
        Schema::table('shops', function (Blueprint $table) {
            // Remove columns
            $table->dropColumn('sliders');
            $table->dropColumn('logo');
            $table->dropColumn('address');
            $table->dropColumn('facebook');
            $table->dropColumn('google');
            $table->dropColumn('twitter');
            $table->dropColumn('youtube');
            $table->dropColumn('pick_up_point_id');

            $table->string('excerpt', 255)->nullable()->after('slug');
            $table->text('content')->nullable()->after('excerpt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
        });
    }
};
