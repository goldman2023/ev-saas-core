<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('shops')->count() == 0) {
            \DB::table('shops')->delete();

            \DB::table('shops')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'name' => 'Demo Shop',
                        'logo' => NULL,
                        'sliders' => NULL,
                        'address' => 'House : Demo, Road : Demo, Section : Demo',
                        'facebook' => 'www.facebook.com',
                        'google' => 'www.google.com',
                        'twitter' => 'www.twitter.com',
                        'youtube' => 'www.youtube.com',
                        'slug' => 'Demo-Seller-Shop-1',
                        'meta_title' => 'Demo Shop',
                        'meta_description' => 'Demo description',
                        'pick_up_point_id' => NULL,
                    ),
            ));

            \DB::table('user_relationships')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'user_id' => 1,
                        'subject_id' => 1,
                        'subject_type' => 'App\\Models\\Shop',
                    ),
            ));

        }
    }
}
