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

        \DB::table('product_stocks')->insert([
            // TODO : DO we need any demo data for this?
        ]);
    }
}
