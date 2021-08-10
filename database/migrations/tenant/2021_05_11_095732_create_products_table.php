<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 200)->index('name');
            $table->string('added_by', 6)->default('admin');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('subcategory_id')->nullable();
            $table->integer('subsubcategory_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('photos', 2000)->nullable();
            $table->string('thumbnail_img', 100)->nullable();
            $table->string('video_provider', 20)->nullable();
            $table->string('video_link', 100)->nullable();
            $table->string('tags', 1000)->nullable()->index('tags');
            $table->longText('description')->nullable();
            $table->double('unit_price', 20, 2);
            $table->double('purchase_price', 20, 2);
            $table->integer('variant_product')->default(0);
            $table->string('attributes', 1000)->default('[]');
            $table->mediumText('choice_options')->nullable();
            $table->mediumText('colors')->nullable();
            $table->text('variations')->nullable();
            $table->integer('todays_deal')->default(0);
            $table->integer('published')->default(1);
            $table->string('stock_visibility_state', 10)->default('quantity');
            $table->tinyInteger('cash_on_delivery')->default(1)->comment('1 = On, 0 = Off');
            $table->integer('featured')->default(0);
            $table->integer('seller_featured')->default(0);
            $table->integer('current_stock')->default(0);
            $table->string('unit', 20)->nullable();
            $table->integer('min_qty')->default(1);
            $table->integer('low_stock_quantity')->nullable();
            $table->double('discount', 20, 2)->nullable();
            $table->string('discount_type', 10)->nullable();
            $table->double('tax', 20, 2)->nullable();
            $table->string('tax_type', 10)->nullable();
            $table->string('shipping_type', 20)->nullable()->default('flat_rate');
            $table->text('shipping_cost')->nullable();
            $table->tinyInteger('is_quantity_multiplied')->default(0)->comment('1 = Mutiplied with shipping cost');
            $table->integer('est_shipping_days')->nullable();
            $table->integer('num_of_sale')->default(0);
            $table->mediumText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_img', 255)->nullable();
            $table->string('pdf', 255)->nullable();
            $table->mediumText('slug');
            $table->double('rating', 8, 2)->default(0.00);
            $table->string('barcode', 255)->nullable();
            $table->integer('digital')->default(0);
            $table->string('file_name', 255)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
