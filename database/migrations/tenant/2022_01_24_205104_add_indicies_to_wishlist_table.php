<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndiciesToWishlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('subject_id')->change();

            /* TODO: set this to nullable and enable foreign key then, right now guests have user_id 0 and this migration breaks */
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->index(['subject_id', 'subject_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->integer('subject_id')->change();
            $table->string('user_id')->nullable(true)->change();
        });
    }
}
