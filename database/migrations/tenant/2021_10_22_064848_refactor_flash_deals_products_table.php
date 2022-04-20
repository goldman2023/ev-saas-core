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
        Schema::table('flash_deals', function (Blueprint $table) {
            $table->enum('discount_type', ['amount', 'percent'])->after('end_date');
            $table->float('discount')->after('discount_type');
        });

        Schema::rename('flash_deal_products', 'flash_deal_relationships');
        Schema::table('flash_deal_relationships', function (Blueprint $table) {
            $table->renameColumn('product_id', 'subject_id');
        });

        Schema::table('flash_deal_relationships', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
            $table->unsignedBigInteger('flash_deal_id')->change();

            if (Schema::hasColumn('flash_deal_relationships', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable(true)->change();
            }

            if (! Schema::hasColumn('flash_deal_relationships', 'subject_type')) {
                $table->string('subject_type')->nullable(true)->after('subject_id');
            }

            // Create index for subject_id and subject_type
            $table->index(['subject_id', 'subject_type']);

            if (Schema::hasColumn('flash_deal_relationships', 'discount_type')) {
                $table->dropColumn('discount_type');
            }

            if (Schema::hasColumn('flash_deal_relationships', 'discount')) {
                $table->dropColumn('discount');
            }

            $table->integer('category_id')->after('subject_type')->nullable(true);
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
        //
    }
};
