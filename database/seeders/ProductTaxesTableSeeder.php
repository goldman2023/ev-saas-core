<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductTaxesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('product_taxes')->count() == 0) {
            \DB::table('product_taxes')->delete();

        }

    }
}
