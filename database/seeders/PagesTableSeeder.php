<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('pages')->count() == 0) {
            \DB::table('pages')->delete();

            \DB::table('pages')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'type' => 'home_page',
                        'title' => 'Home Page',
                        'slug' => 'home',
                        'content' => NULL,
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'keywords' => NULL,
                        'meta_image' => NULL,
                        'created_at' => '2020-11-04 12:13:20',
                        'updated_at' => '2020-11-04 12:13:20',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'type' => 'seller_policy_page',
                        'title' => 'Seller Policy Pages',
                        'slug' => 'sellerpolicy',
                        'content' => NULL,
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'keywords' => NULL,
                        'meta_image' => NULL,
                        'created_at' => '2020-11-04 12:14:41',
                        'updated_at' => '2020-11-04 14:19:30',
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'type' => 'return_policy_page',
                        'title' => 'Return Policy Page',
                        'slug' => 'returnpolicy',
                        'content' => NULL,
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'keywords' => NULL,
                        'meta_image' => NULL,
                        'created_at' => '2020-11-04 12:14:41',
                        'updated_at' => '2020-11-04 12:14:41',
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'type' => 'support_policy_page',
                        'title' => 'Support Policy Page',
                        'slug' => 'supportpolicy',
                        'content' => NULL,
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'keywords' => NULL,
                        'meta_image' => NULL,
                        'created_at' => '2020-11-04 12:14:59',
                        'updated_at' => '2020-11-04 12:14:59',
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'type' => 'terms_conditions_page',
                        'title' => 'Term Conditions Page',
                        'slug' => 'terms',
                        'content' => NULL,
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'keywords' => NULL,
                        'meta_image' => NULL,
                        'created_at' => '2020-11-04 12:15:29',
                        'updated_at' => '2020-11-04 12:15:29',
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'type' => 'privacy_policy_page',
                        'title' => 'Privacy Policy Page',
                        'slug' => 'privacypolicy',
                        'content' => NULL,
                        'meta_title' => NULL,
                        'meta_description' => NULL,
                        'keywords' => NULL,
                        'meta_image' => NULL,
                        'created_at' => '2020-11-04 12:15:55',
                        'updated_at' => '2020-11-04 12:15:55',
                    ),
            ));

        }
    }
}
