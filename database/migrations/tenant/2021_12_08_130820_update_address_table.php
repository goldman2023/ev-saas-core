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
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->change();
            $table->string('address_2', 255);
            $table->string('state', 255);
            $table->json('phone')->change();
            $table->renameColumn('postal_code', 'zip_code');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('address_2');
            $table->dropColumn('state');
            $table->renameColumn('zip_code', 'postal_code');
            $table->string('phone', 255)->change();
        });
    }
};
