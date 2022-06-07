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
        Schema::table('course_items', function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->nullable()->after('type');
            $table->string('subject_type')->nullable()->after('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_items', function (Blueprint $table) {
            $table->dropColumn('subject_id');
            $table->dropColumn('subject_type');
        });
    }
};
