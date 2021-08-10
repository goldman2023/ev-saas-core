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

            \DB::table('product_taxes')->insert(array(
                0 =>
                    array(
                        'id' => 3,
                        'product_id' => 2,
                        'tax_id' => 3,
                        'tax' => 49.0,
                        'tax_type' => 'percent',
                        'created_at' => '2021-04-08 12:32:35',
                        'updated_at' => '2021-04-08 12:32:35',
                    ),
                1 =>
                    array(
                        'id' => 4,
                        'product_id' => 3,
                        'tax_id' => 3,
                        'tax' => 60.0,
                        'tax_type' => 'amount',
                        'created_at' => '2021-04-08 12:45:38',
                        'updated_at' => '2021-04-08 12:45:38',
                    ),
                2 =>
                    array(
                        'id' => 5,
                        'product_id' => 1,
                        'tax_id' => 3,
                        'tax' => 20.0,
                        'tax_type' => 'amount',
                        'created_at' => '2021-04-08 13:37:30',
                        'updated_at' => '2021-04-08 13:37:30',
                    ),
                3 =>
                    array(
                        'id' => 7,
                        'product_id' => 4,
                        'tax_id' => 3,
                        'tax' => 0.0,
                        'tax_type' => 'amount',
                        'created_at' => '2021-04-08 14:03:03',
                        'updated_at' => '2021-04-08 14:03:03',
                    ),
            ));
        }

    }
}
