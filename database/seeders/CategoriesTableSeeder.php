<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('categories')->count() == 0) {
            \DB::table('categories')->delete();

            \DB::table('categories')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'parent_id' => 0,
                        'level' => 0,
                        'name' => 'Logistics And Transport',
                        'order_level' => 0,
                        'commision_rate' => 0.0,
                        'banner' => '16',
                        'icon' => '20',
                        'featured' => 1,
                        'top' => 1,
                        'digital' => 0,
                        'slug' => 'logistics-and-transport-csesb',
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'created_at' => '2021-04-08 17:25:04',
                        'updated_at' => '2021-04-08 14:25:04',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'parent_id' => 0,
                        'level' => 0,
                        'name' => 'Paper and Cardboard',
                        'order_level' => 0,
                        'commision_rate' => 0.0,
                        'banner' => '13',
                        'icon' => '23',
                        'featured' => 1,
                        'top' => 0,
                        'digital' => 0,
                        'slug' => 'Paper-and-Cardboard-3bf7m',
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'created_at' => '2021-04-08 17:31:35',
                        'updated_at' => '2021-04-08 14:31:35',
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'parent_id' => 0,
                        'level' => 0,
                        'name' => 'IT and Digital Solutions',
                        'order_level' => 0,
                        'commision_rate' => 0.0,
                        'banner' => '14',
                        'icon' => '22',
                        'featured' => 1,
                        'top' => 1,
                        'digital' => 0,
                        'slug' => 'IT-and-Digital-Solutions-zzLzx',
                        'meta_title' => 'IT and Digital Solutions',
                        'meta_description' => NULL,
                        'created_at' => '2021-04-08 17:30:15',
                        'updated_at' => '2021-04-08 14:30:15',
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'parent_id' => 0,
                        'level' => 0,
                        'name' => 'Forestry',
                        'order_level' => 0,
                        'commision_rate' => 0.0,
                        'banner' => '15',
                        'icon' => '19',
                        'featured' => 1,
                        'top' => 0,
                        'digital' => 0,
                        'slug' => 'forestryo-rucah',
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'created_at' => '2021-04-08 17:23:43',
                        'updated_at' => '2021-04-08 14:23:43',
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'parent_id' => 4,
                        'level' => 1,
                        'name' => 'Woodland Owners',
                        'order_level' => 0,
                        'commision_rate' => 0.0,
                        'banner' => NULL,
                        'icon' => NULL,
                        'featured' => 1,
                        'top' => 0,
                        'digital' => 0,
                        'slug' => 'Woodland-Owners-eH2G9',
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'created_at' => '2021-04-08 17:31:53',
                        'updated_at' => '2021-04-08 14:31:53',
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'parent_id' => 0,
                        'level' => 0,
                        'name' => 'Banking, Finance & Insurance',
                        'order_level' => 0,
                        'commision_rate' => 0.0,
                        'banner' => '12',
                        'icon' => '21',
                        'featured' => 1,
                        'top' => 0,
                        'digital' => 0,
                        'slug' => 'banking-finance--insurance-2oo1i',
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'created_at' => '2021-04-08 17:31:51',
                        'updated_at' => '2021-04-08 14:31:51',
                    ),
            ));
        }

    }
}
