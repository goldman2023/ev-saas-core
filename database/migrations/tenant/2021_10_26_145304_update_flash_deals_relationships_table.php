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
        Schema::table('flash_deal_relationships', function (Blueprint $table) {
            $table->tinyInteger('include_variations')->default(0)->after('subject_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flash_deal_relationships', function (Blueprint $table) {
            $table->dropColumn('include_variations');
        });
    }
};
