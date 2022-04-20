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
        Schema::table('invoices', function (Blueprint $table) {
            $table->json('meta')->nullable(true)->change();
            $table->string('note', 500)->nullable(true)->change();
            $table->integer('grace_period')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->json('meta')->nullable(false)->change();
            $table->string('note', 500)->nullable(false)->change();
            $table->string('grace_period', 191)->change();
        });
    }
};
