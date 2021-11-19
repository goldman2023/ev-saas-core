<?php

use App\Models\Product;
use App\Models\Upload;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProperlyReattachUploadsToProductsViaIntermediateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uploads_content_relationships', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->nullable(true)->change();
            if (!Schema::hasColumn('uploads_content_relationships', 'order')) {
                $table->integer('order')->after('type')->default(0)->nullable();
            }
        });
        /* TODO: Fix when creating new tenant and running migrations on the first initialization */
        // Reattach uploads from `products` columns to uploads_content_relationships table
        /* $products = Product::get();
        $uploads = [];
        foreach($products as $product) {

            if(!empty($product->thumbnail_img) && Upload::where('id', $product->thumbnail_img)->exists()) {
                $product->uploads()->attach($product->thumbnail_img, ['type' => 'thumbnail']);
                $product->uploads()->attach($product->thumbnail_img, ['type' => 'meta_img']);
            }

            $gallery = collect(explode(',', $product->photos))->filter(function($item, $key) {
                return ctype_digit($item);
            })->map(function ($item, $key) {
                return [
                    'id' => (int) $item,
                    'type' => 'gallery',
                    'order' => $key
                ];
            })->keyBy('id')->forget('id')->transform(function ($item, $key) {
                unset($item['id']);
                return $item;
            });

            foreach($gallery as $upload_id => $pivotData) {
                if(Upload::where('id', $upload_id)->exists()) { // skip uploads that don't exist
                    $product->uploads()->attach($upload_id, $pivotData);
                }
            }

            if(!empty($product->pdf) && Upload::where('id', $product->pdf)->exists()) {
                $product->uploads()->attach($product->pdf, ['type' => 'pdf']);
            }
        } */

        // Remove unnecessary columns from `products` (thumbnail_img, photos, meta_img, pdf)
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'thumbnail_img')) {
                $table->dropColumn('thumbnail_img');
            }

            if (Schema::hasColumn('products', 'photos')) {
                $table->dropColumn('photos');
            }

            if (Schema::hasColumn('products', 'meta_img')) {
                $table->dropColumn('meta_img');
            }

            if (Schema::hasColumn('products', 'pdf')) {
                $table->dropColumn('pdf');
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
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
