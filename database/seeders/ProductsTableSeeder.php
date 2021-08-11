<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('products')->count() == 0) {
            \DB::table('products')->delete();

            \DB::table('products')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'name' => 'Demo Product',
                        'added_by' => 'admin',
                        'user_id' => 1,
                        'category_id' => 5,
                        'subcategory_id' => NULL,
                        'subsubcategory_id' => NULL,
                        'brand_id' => 1,
                        'photos' => '5,7,6,3',
                        'thumbnail_img' => '1',
                        'video_provider' => 'vimeo',
                        'video_link' => 'https://google.com',
                        'tags' => 'tag-example',
                        'description' => '<p>Lorem Ipsum, Lorem Ipsum, Lorem Ipsum, Lorem Ipsum, Lorem Ipsum, Lorem Ipsum<br></p>',
                        'unit_price' => 33.0,
                        'purchase_price' => 98.0,
                        'variant_product' => 1,
                        'attributes' => '["2"]',
                        'choice_options' => '[{"attribute_id":"2","values":["Labas"]}]',
                        'colors' => '["#9966CC"]',
                        'variations' => NULL,
                        'todays_deal' => 1,
                        'published' => 1,
                        'stock_visibility_state' => 'quantity',
                        'cash_on_delivery' => 1,
                        'featured' => 1,
                        'seller_featured' => 0,
                        'current_stock' => 23,
                        'unit' => 'Officia laborum Aut',
                        'min_qty' => 79,
                        'low_stock_quantity' => 954,
                        'discount' => 89.0,
                        'discount_type' => 'percent',
                        'tax' => NULL,
                        'tax_type' => NULL,
                        'shipping_type' => 'free',
                        'shipping_cost' => '0',
                        'is_quantity_multiplied' => 0,
                        'est_shipping_days' => 28,
                        'num_of_sale' => 0,
                        'meta_title' => 'Saepe eum quo modi a',
                        'meta_description' => 'Sed quia quia perfer',
                        'meta_img' => '1',
                        'pdf' => NULL,
                        'slug' => 'serena-mccarty-y0hjy',
                        'rating' => 0.0,
                        'barcode' => NULL,
                        'digital' => 0,
                        'file_name' => NULL,
                        'file_path' => NULL,
                        'created_at' => '2021-04-08 12:23:15',
                        'updated_at' => '2021-04-08 13:37:30',
                    ),
            ));

        }
    }
}
