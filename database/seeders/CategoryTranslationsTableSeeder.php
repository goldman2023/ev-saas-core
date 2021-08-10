<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryTranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('category_translations')->count() == 0) {
            \DB::table('category_translations')->delete();

            \DB::table('category_translations')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'category_id' => 4,
                        'name' => 'Forestry',
                        'lang' => 'en',
                        'created_at' => '2021-04-08 12:43:25',
                        'updated_at' => '2021-04-08 12:43:32',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'category_id' => 5,
                        'name' => 'Woodland Owners',
                        'lang' => 'en',
                        'created_at' => '2021-04-08 12:43:52',
                        'updated_at' => '2021-04-08 12:43:52',
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'category_id' => 1,
                        'name' => 'Logistics And Transport',
                        'lang' => 'en',
                        'created_at' => '2021-04-08 13:48:38',
                        'updated_at' => '2021-04-08 13:48:38',
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'category_id' => 2,
                        'name' => 'Paper and Cardboard',
                        'lang' => 'en',
                        'created_at' => '2021-04-08 13:51:17',
                        'updated_at' => '2021-04-08 13:51:17',
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'category_id' => 3,
                        'name' => 'IT and Digital Solutions',
                        'lang' => 'en',
                        'created_at' => '2021-04-08 13:51:54',
                        'updated_at' => '2021-04-08 13:51:54',
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'category_id' => 6,
                        'name' => 'Banking, Finance & Insurance',
                        'lang' => 'en',
                        'created_at' => '2021-04-08 13:52:30',
                        'updated_at' => '2021-04-08 13:52:30',
                    ),
            ));

        }
    }
}
