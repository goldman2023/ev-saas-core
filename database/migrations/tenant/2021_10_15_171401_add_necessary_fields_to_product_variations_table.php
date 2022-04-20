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
            if (! Schema::hasColumn('product_variations', 'num_of_sales')) {
                $table->integer('num_of_sales')->after('price')->default(0);
            }

            if (! Schema::hasColumn('product_variations', 'deleted_at')) {
                $table->timestamp('deleted_at', 0)->nullable(true)->after('updated_at');
            }

            if (Schema::hasColumn('product_variations', 'variant')) {
                $table->string('variant', 300)->change();
                $table->unique(['product_id', 'variant']);
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
        Schema::table('product_variations', function (Blueprint $table) {
            if (Schema::hasColumn('product_variations', 'num_of_sales')) {
                $table->dropColumn('num_of_sales');
            }

            if (Schema::hasColumn('product_variations', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }

            // $table->dropUnique('product_variations_product_id_variant_index');
        });
    }
}
