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
            $table->unsignedBigInteger('real_invoice_number')->nullable();
            $table->string('real_invoice_prefix')->nullable()->default('AA')->index();
            $table->string('source')->nullable()->index();
            $table->string('source_id')->nullable();

            $table->index(['real_invoice_number', 'real_invoice_prefix']);
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
            try {
                $table->dropIndex(['real_invoice_number', 'real_invoice_prefix']);
                $table->dropColumn('real_invoice_number');
                $table->dropColumn('real_invoice_prefix');
                $table->dropColumn('source');
                $table->dropColumn('source_id');
            } catch(\Throwable $e) {

            }
        });
    }
};
