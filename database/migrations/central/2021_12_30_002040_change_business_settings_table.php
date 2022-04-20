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
        Schema::rename('business_settings', 'central_settings');

        Schema::table('central_settings', function (Blueprint $table) {
            $table->renameColumn('type', 'setting');
            $table->index('setting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('central_settings', function (Blueprint $table) {
            $table->dropIndex(['setting']);
            $table->renameColumn('setting', 'type');
        });

        Schema::rename('central_settings', 'business_settings');
    }
};
