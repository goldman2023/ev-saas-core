<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNecessaryFieldsToProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->integer('num_of_sales')->after('price')->default(0);
            $table->timestamp('deleted_at', 0)->nullable(true)->after('updated_at');

            $table->unique(['product_id', 'variant']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropColumn('num_of_sales');
            $table->dropColumn('deleted_at');

            $table->dropUnique('product_variations_product_id_variant_index');
        });
    }
}
