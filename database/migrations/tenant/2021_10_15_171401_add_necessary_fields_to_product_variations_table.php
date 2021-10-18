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
            if (Schema::hasColumn('product_variations', 'num_of_sales')) {
                $table->dropColumn('num_of_sales');
            }
            if (!Schema::hasColumn('product_variations', 'deleted_at')) {
                $table->timestamp('deleted_at', 0)->nullable(true)->after('updated_at');
            }
            // Add lenght to text field because , text field with no lenght can't be unique key index
            $table->text('variant', 65535)->change();
            /* TODO: Fix this, removed it beause text field has an issue for creating this index */
            // $table->unique(['product_id', 'variant']);
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
