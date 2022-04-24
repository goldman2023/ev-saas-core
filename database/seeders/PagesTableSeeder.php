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

            \DB::table('pages')->insert([
                0 => [
                    'id' => 1,
                    'type' => 'home_page',
                    'name' => 'Home',
                    'slug' => 'home',
                    'content' => null,
                    'meta_title' => null,
                    'meta_description' => null,
                    'keywords' => null,
                    'meta_image' => null,
                    'created_at' => '2020-11-04 12:13:20',
                    'updated_at' => '2020-11-04 12:13:20',
                ],
                1 => [
                    'id' => 2,
                    'type' => 'seller_policy_page',
                    'name' => 'Seller Policy Pages',
                    'slug' => 'seller_policy',
                    'content' => null,
                    'meta_title' => null,
                    'meta_description' => null,
                    'keywords' => null,
                    'meta_image' => null,
                    'created_at' => '2020-11-04 12:14:41',
                    'updated_at' => '2020-11-04 14:19:30',
                ],
                2 => [
                    'id' => 3,
                    'type' => 'return_policy_page',
                    'name' => 'Return Policy Page',
                    'slug' => 'return_policy',
                    'content' => null,
                    'meta_title' => null,
                    'meta_description' => null,
                    'keywords' => null,
                    'meta_image' => null,
                    'created_at' => '2020-11-04 12:14:41',
                    'updated_at' => '2020-11-04 12:14:41',
                ],
                3 => [
                    'id' => 4,
                    'type' => 'support_policy_page',
                    'name' => 'Support Policy Page',
                    'slug' => 'support_policy',
                    'content' => null,
                    'meta_title' => null,
                    'meta_description' => null,
                    'keywords' => null,
                    'meta_image' => null,
                    'created_at' => '2020-11-04 12:14:59',
                    'updated_at' => '2020-11-04 12:14:59',
                ],
                4 => [
                    'id' => 5,
                    'type' => 'terms_conditions_page',
                    'name' => 'Term and Conditions Page',
                    'slug' => 'terms_and_conditions',
                    'content' => null,
                    'meta_title' => null,
                    'meta_description' => null,
                    'keywords' => null,
                    'meta_image' => null,
                    'created_at' => '2020-11-04 12:15:29',
                    'updated_at' => '2020-11-04 12:15:29',
                ],
                5 => [
                    'id' => 6,
                    'type' => 'privacy_policy_page',
                    'name' => 'Privacy Policy Page',
                    'slug' => 'privacy_policy',
                    'content' => null,
                    'meta_title' => null,
                    'meta_description' => null,
                    'keywords' => null,
                    'meta_image' => null,
                    'created_at' => '2020-11-04 12:15:55',
                    'updated_at' => '2020-11-04 12:15:55',
                ],
            ]);
        }
    }
}
