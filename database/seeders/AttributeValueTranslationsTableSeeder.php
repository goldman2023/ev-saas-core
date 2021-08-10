<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeValueTranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('attribute_value_translations')->count() == 0) {
            \DB::table('attribute_value_translations')->delete();

            \DB::table('attribute_value_translations')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'attribute_value_id' => 1,
                        'name' => 'Private',
                        'lang' => 'en',
                        'created_at' => '2021-05-19 12:09:10',
                        'updated_at' => '2021-06-01 15:27:05',
                    ),
                1 =>
                    array(
                        'id' => 4,
                        'attribute_value_id' => 4,
                        'name' => 'Individual entrepreneur',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:28:41',
                        'updated_at' => '2021-06-01 15:28:41',
                    ),
                2 =>
                    array(
                        'id' => 5,
                        'attribute_value_id' => 5,
                        'name' => 'Public',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:28:54',
                        'updated_at' => '2021-06-01 15:28:54',
                    ),
                3 =>
                    array(
                        'id' => 6,
                        'attribute_value_id' => 6,
                        'name' => 'Other',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:29:04',
                        'updated_at' => '2021-06-01 15:29:04',
                    ),
                4 =>
                    array(
                        'id' => 7,
                        'attribute_value_id' => 7,
                        'name' => 'State',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:29:20',
                        'updated_at' => '2021-06-01 15:29:20',
                    ),
                5 =>
                    array(
                        'id' => 8,
                        'attribute_value_id' => 8,
                        'name' => 'Manufacturer',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:30:13',
                        'updated_at' => '2021-06-01 15:30:13',
                    ),
                6 =>
                    array(
                        'id' => 9,
                        'attribute_value_id' => 9,
                        'name' => 'Consumer',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:31:17',
                        'updated_at' => '2021-06-01 15:31:17',
                    ),
                7 =>
                    array(
                        'id' => 10,
                        'attribute_value_id' => 10,
                        'name' => 'Services',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:31:27',
                        'updated_at' => '2021-06-01 15:31:27',
                    ),
                8 =>
                    array(
                        'id' => 11,
                        'attribute_value_id' => 12,
                        'name' => 'Technical support',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:32:27',
                        'updated_at' => '2021-06-01 15:32:27',
                    ),
                9 =>
                    array(
                        'id' => 12,
                        'attribute_value_id' => 13,
                        'name' => 'Nonprofit',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:32:52',
                        'updated_at' => '2021-06-01 15:32:52',
                    ),
                10 =>
                    array(
                        'id' => 13,
                        'attribute_value_id' => 14,
                        'name' => 'Services',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:32:59',
                        'updated_at' => '2021-06-01 15:32:59',
                    ),
                11 =>
                    array(
                        'id' => 14,
                        'attribute_value_id' => 15,
                        'name' => 'Other',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:33:05',
                        'updated_at' => '2021-06-01 15:33:05',
                    ),
                12 =>
                    array(
                        'id' => 15,
                        'attribute_value_id' => 16,
                        'name' => 'Micro (<9)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:35:45',
                        'updated_at' => '2021-06-01 15:35:45',
                    ),
                13 =>
                    array(
                        'id' => 16,
                        'attribute_value_id' => 17,
                        'name' => 'Small (10 - 49)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:35:51',
                        'updated_at' => '2021-06-01 15:35:51',
                    ),
                14 =>
                    array(
                        'id' => 17,
                        'attribute_value_id' => 18,
                        'name' => 'Medium (50 - 249)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:35:57',
                        'updated_at' => '2021-06-01 15:35:57',
                    ),
                15 =>
                    array(
                        'id' => 18,
                        'attribute_value_id' => 19,
                        'name' => 'Large (249-999)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:36:06',
                        'updated_at' => '2021-06-01 15:36:06',
                    ),
                16 =>
                    array(
                        'id' => 19,
                        'attribute_value_id' => 20,
                        'name' => 'Huge (1000+)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:36:15',
                        'updated_at' => '2021-06-01 15:36:15',
                    ),
                17 =>
                    array(
                        'id' => 20,
                        'attribute_value_id' => 21,
                        'name' => 'Micro (<9.000)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:37:12',
                        'updated_at' => '2021-06-01 15:37:12',
                    ),
                18 =>
                    array(
                        'id' => 21,
                        'attribute_value_id' => 22,
                        'name' => 'Small (10 - 49.000)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:37:18',
                        'updated_at' => '2021-06-01 15:37:18',
                    ),
                19 =>
                    array(
                        'id' => 22,
                        'attribute_value_id' => 23,
                        'name' => 'Medium (50 - 249.000)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:37:47',
                        'updated_at' => '2021-06-01 15:37:47',
                    ),
                20 =>
                    array(
                        'id' => 23,
                        'attribute_value_id' => 24,
                        'name' => 'Large (249-999.000)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:37:52',
                        'updated_at' => '2021-06-01 15:37:52',
                    ),
                21 =>
                    array(
                        'id' => 24,
                        'attribute_value_id' => 25,
                        'name' => 'Huge (1.000.000+)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:37:58',
                        'updated_at' => '2021-06-01 15:37:58',
                    ),
                22 =>
                    array(
                        'id' => 25,
                        'attribute_value_id' => 26,
                        'name' => 'A',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:38:42',
                        'updated_at' => '2021-06-01 15:38:42',
                    ),
                23 =>
                    array(
                        'id' => 26,
                        'attribute_value_id' => 27,
                        'name' => 'B',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:40:06',
                        'updated_at' => '2021-06-01 15:40:06',
                    ),
                24 =>
                    array(
                        'id' => 27,
                        'attribute_value_id' => 28,
                        'name' => 'C',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:40:12',
                        'updated_at' => '2021-06-01 15:40:12',
                    ),
                25 =>
                    array(
                        'id' => 28,
                        'attribute_value_id' => 29,
                        'name' => 'D',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:40:18',
                        'updated_at' => '2021-06-01 15:40:18',
                    ),
                26 =>
                    array(
                        'id' => 29,
                        'attribute_value_id' => 30,
                        'name' => 'E',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:40:24',
                        'updated_at' => '2021-06-01 15:40:24',
                    ),
                27 =>
                    array(
                        'id' => 30,
                        'attribute_value_id' => 31,
                        'name' => 'FSC',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:40:50',
                        'updated_at' => '2021-06-01 15:40:50',
                    ),
                28 =>
                    array(
                        'id' => 31,
                        'attribute_value_id' => 32,
                        'name' => 'ISO (9000 or 14001)',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:40:57',
                        'updated_at' => '2021-06-01 15:40:57',
                    ),
                29 =>
                    array(
                        'id' => 32,
                        'attribute_value_id' => 33,
                        'name' => 'CE',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:41:05',
                        'updated_at' => '2021-06-01 15:41:05',
                    ),
                30 =>
                    array(
                        'id' => 33,
                        'attribute_value_id' => 34,
                        'name' => 'ENplus',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:41:11',
                        'updated_at' => '2021-06-01 15:41:11',
                    ),
                31 =>
                    array(
                        'id' => 34,
                        'attribute_value_id' => 35,
                        'name' => 'PEFC',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:41:22',
                        'updated_at' => '2021-06-01 15:41:22',
                    ),
                32 =>
                    array(
                        'id' => 35,
                        'attribute_value_id' => 36,
                        'name' => 'ISPM 15',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:41:28',
                        'updated_at' => '2021-06-01 15:41:28',
                    ),
                33 =>
                    array(
                        'id' => 36,
                        'attribute_value_id' => 37,
                        'name' => 'CARB',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:41:36',
                        'updated_at' => '2021-06-01 15:41:36',
                    ),
                34 =>
                    array(
                        'id' => 37,
                        'attribute_value_id' => 38,
                        'name' => 'EN+',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:41:42',
                        'updated_at' => '2021-06-01 15:41:42',
                    ),
                35 =>
                    array(
                        'id' => 38,
                        'attribute_value_id' => 39,
                        'name' => 'GOST',
                        'lang' => 'en',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
            ));
        }

    }
}
