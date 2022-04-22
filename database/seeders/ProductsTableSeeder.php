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

            /* TODO: Create reasonable product table seeder */
        }
    }
}
