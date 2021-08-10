<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeTranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('attribute_translations')->count() == 0) {

            \DB::table('attribute_translations')->delete();

            \DB::table('attribute_translations')->insert(array(
                0 =>
                    array(
                        'id' => 3,
                        'attribute_id' => 1,
                        'name' => 'Company Size',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:29:26',
                        'updated_at' => '2021-06-01 15:29:26',
                    ),
                1 =>
                    array(
                        'id' => 4,
                        'attribute_id' => 9,
                        'name' => 'Activity type',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:29:55',
                        'updated_at' => '2021-06-01 15:29:55',
                    ),
                2 =>
                    array(
                        'id' => 5,
                        'attribute_id' => 10,
                        'name' => 'Creation date',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:34:05',
                        'updated_at' => '2021-06-01 15:34:05',
                    ),
                3 =>
                    array(
                        'id' => 6,
                        'attribute_id' => 11,
                        'name' => 'Country',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:34:34',
                        'updated_at' => '2021-06-01 15:34:34',
                    ),
                4 =>
                    array(
                        'id' => 7,
                        'attribute_id' => 12,
                        'name' => 'Country',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:34:35',
                        'updated_at' => '2021-06-01 15:34:35',
                    ),
                5 =>
                    array(
                        'id' => 8,
                        'attribute_id' => 12,
                        'name' => 'Šalis',
                        'lang' => 'lt',
                        'created_at' => '2021-06-01 15:34:48',
                        'updated_at' => '2021-06-01 15:34:48',
                    ),
                6 =>
                    array(
                        'id' => 10,
                        'attribute_id' => 14,
                        'name' => 'Number Of Employees',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:35:10',
                        'updated_at' => '2021-06-01 15:35:10',
                    ),
                7 =>
                    array(
                        'id' => 11,
                        'attribute_id' => 15,
                        'name' => 'Capacity (Manufacturing, consumption, purchasing, ',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:36:32',
                        'updated_at' => '2021-06-01 15:36:32',
                    ),
                8 =>
                    array(
                        'id' => 12,
                        'attribute_id' => 16,
                        'name' => 'Turnover',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:36:55',
                        'updated_at' => '2021-06-01 15:36:55',
                    ),
                9 =>
                    array(
                        'id' => 13,
                        'attribute_id' => 17,
                        'name' => 'Credit Rating',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:38:21',
                        'updated_at' => '2021-06-01 15:38:21',
                    ),
                10 =>
                    array(
                        'id' => 14,
                        'attribute_id' => 18,
                        'name' => 'Certification',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:40:39',
                        'updated_at' => '2021-06-01 15:40:39',
                    ),
            ));

        }
    }
}
