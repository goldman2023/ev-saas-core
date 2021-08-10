<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductStocksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('product_stocks')->delete();

        \DB::table('product_stocks')->insert(array (
            0 =>
            array (
                'id' => 3,
                'product_id' => 1,
                'variant' => 'Amethyst-Labas',
                'sku' => 'Amethyst-Labas',
                'price' => 33.0,
                'qty' => 10,
                'image' => NULL,
                'created_at' => '2021-04-08 13:37:30',
                'updated_at' => '2021-04-08 13:37:30',
            ),
            1 =>
            array (
                'id' => 5,
                'product_id' => 4,
                'variant' => NULL,
                'sku' => NULL,
                'price' => 1.0,
                'qty' => 100,
                'image' => NULL,
                'created_at' => '2021-04-08 14:03:03',
                'updated_at' => '2021-04-08 14:03:03',
            ),
        ));


    }
}
