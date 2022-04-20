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
            $table->integer('start_date')->after('payment_status')->nullable();
            $table->integer('due_date')->nullable()->change();
            $table->integer('grace_period')->nullable()->change();
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
            $table->dropColumn('start_date');
            $table->timestamp('due_date')->nullable(false)->change();
            $table->integer('grace_period')->nullable(false)->change();
        });
    }
};
