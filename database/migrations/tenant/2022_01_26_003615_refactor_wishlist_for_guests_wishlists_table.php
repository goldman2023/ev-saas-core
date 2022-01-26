<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorWishlistForGuestsWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->string('session_id', 1000)->change();
            $table->unsignedInteger('user_id')->nullable()->change();
            $table->renameColumn('session_id', 'guest_id');
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
            $table->unsignedInteger('user_id')->nullable(false)->change();
            $table->string('guest_id', 191)->change();
            $table->renameColumn('guest_id', 'session_id');
        });
    }
}
