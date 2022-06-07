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
        // TODO: Syntax error: name too long
        // Schema::table('blog_post_relationships', function (Blueprint $table) {
        //     $table->unique(['blog_post_id', 'subject_id', 'subject_type']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('blog_post_relationships', function (Blueprint $table) {
        //     $table->dropUnique(['blog_post_id', 'subject_id', 'subject_type']);
        // });
    }
};
