<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HomeCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('home_categories')->count() == 0) {
            \DB::table('home_categories')->delete();

            \DB::table('home_categories')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'category_id' => 1,
                        'subsubcategories' => '["1"]',
                        'status' => 1,
                        'created_at' => '2019-03-12 08:38:23',
                        'updated_at' => '2019-03-12 08:38:23',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'category_id' => 2,
                        'subsubcategories' => '["10"]',
                        'status' => 1,
                        'created_at' => '2019-03-12 08:44:54',
                        'updated_at' => '2019-03-12 08:44:54',
                    ),
            ));

        }
    }
}
