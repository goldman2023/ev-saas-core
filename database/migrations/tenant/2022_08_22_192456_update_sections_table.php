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
        Schema::table('sections', function (Blueprint $table) {
            $table->string('slug', 500)->after('title')->unique();
            $table->longText('content')->after('order')->nullable();
            $table->string('type')->after('section_id')->default('twig')->index();
            $table->string('status', 50)->after('type')->default('draft')->index();

            // $table->dropColumn('thumbnail');
            $table->unsignedInteger('group_id')->nullable()->default(1)->change();
            $table->unsignedInteger('order')->nullable()->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('type');
            $table->dropColumn('slug');
        });
    }
};
