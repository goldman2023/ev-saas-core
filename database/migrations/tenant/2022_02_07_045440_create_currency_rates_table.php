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
        if (! Schema::hasTable('currency_rates')) {
            Schema::create('currency_rates', function (Blueprint $table) {
                $table->id();
                $table->integer('base_currency_id');
                $table->string('base', 10);
                $table->string('target', 10);
                $table->double('fx_rate');
                $table->timestamps();

                $table->index(['base', 'target']);
                $table->foreign('base_currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            });
        }

        Schema::table('currencies', function (Blueprint $table) {
            if (Schema::hasColumn('currencies', 'exchange_rate')) {
                $table->dropColumn('exchange_rate');
            }

            $unique_index_exists = collect(DB::select('SHOW INDEXES FROM currencies'))->pluck('Key_name')->contains('currencies_code_unique');
            if (! $unique_index_exists) {
                $table->unique('code');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_rates');
    }
};
