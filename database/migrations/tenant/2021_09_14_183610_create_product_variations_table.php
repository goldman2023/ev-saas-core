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
        /* PRODUCT ID MUST BE BIGINT AUTO_INCREMENT!!!! */
        Schema::table('products', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement()->change();
        });

        if (Schema::hasTable('product_variations')) {
            Schema::drop('product_variations');
            Schema::create('product_variations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('product_id')
                    ->constrained('products')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->text('variant');
                $table->string('image');
                $table->double('price');
                $table->timestamps();

                $table->index('product_id');
            });
        } else {
            Schema::create('product_variations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('product_id')
                    ->constrained('products')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->text('variant');
                $table->string('image');
                $table->double('price');
                $table->timestamps();

                $table->index('product_id');
            });
        }

        Schema::table('product_stocks', function (Blueprint $table) {
            if (Schema::hasColumn('product_stocks', 'variation_id')) {
                $table->dropColumn('variation_id');
            }
            if (Schema::hasColumn('product_stocks', 'product_id') && ! Schema::hasColumn('product_stocks', 'subject_id')) {
                $table->renameColumn('product_id', 'subject_id');
            }

            if (Schema::hasColumn('product_stocks', 'variant') && ! Schema::hasColumn('product_stocks', 'subject_type')) {
                $table->renameColumn('variant', 'subject_type');
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
        Schema::dropIfExists('product_variations');

        Schema::table('product_stocks', function (Blueprint $table) {
            $table->bigInteger('variation_id');
            $table->renameColumn('subject_id', 'product_id');
            $table->renameColumn('subject_type', 'variant');
        });
    }
};
