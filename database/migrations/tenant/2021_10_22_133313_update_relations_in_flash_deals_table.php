<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRelationsInFlashDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flash_deal_relationships', function (Blueprint $table) {
            if (Schema::hasColumn('flash_deal_relationships', 'category_id')) {
                $table->dropForeign('flash_deal_relationships_category_id_foreign');
                $table->dropColumn('category_id');
            }

            if (Schema::hasColumn('flash_deal_relationships', 'brand_id')) {
                $table->dropForeign('flash_deal_relationships_brand_id_foreign');
                $table->dropColumn('brand_id');
            }
        });

        Schema::table('flash_deals', function (Blueprint $table) {
            $table->integer('category_id')->after('business_id')->nullable(true);
            $table->integer('brand_id')->after('category_id')->nullable(true);

            // create foreign keys for category_id and brand_id
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flash_deals', function (Blueprint $table) {
        });
    }
}
