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
                        'user_id' => 2,
                        'name' => 'Demo Seller Shop',
                        'logo' => NULL,
                        'sliders' => NULL,
                        'address' => 'House : Demo, Road : Demo, Section : Demo',
                        'facebook' => 'www.facebook.com',
                        'google' => 'www.google.com',
                        'twitter' => 'www.twitter.com',
                        'youtube' => 'www.youtube.com',
                        'slug' => 'Demo-Seller-Shop-1',
                        'meta_title' => 'Demo Seller Shop Title',
                        'meta_description' => 'Demo description',
                        'pick_up_point_id' => NULL,
                        'shipping_cost' => 0.0,
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'user_id' => 1,
                        'name' => 'EIM Solutions',
                        'logo' => '25',
                        'sliders' => '8',
                        'address' => 'https://eim.solutions',
                        'facebook' => 'http://eim.solutions/',
                        'google' => 'http://eim.solutions/',
                        'twitter' => 'http://eim.solutions/',
                        'youtube' => 'http://eim.solutions/',
                        'slug' => 'EIM-Solutions-3',
                        'meta_title' => 'EIM Solutions',
                        'meta_description' => 'Web Development agency based in Lithuania.

We focus on:
* E-Commerce/Marketplace applications
* SaaS applications
* Mobile app development - Flutter
* Laravel Development
* Headache-free website maintenance',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0,
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'user_id' => 4,
                        'name' => 'Shop Example 1',
                        'logo' => '24',
                        'sliders' => 8,
                        'address' => 'House : Demo, Road : Demo, Section : Demo',
                        'facebook' => 'www.facebook.com/shop1',
                        'google' => 'www.google.com/shop1',
                        'twitter' => 'www.twitter.com/shop1',
                        'youtube' => 'www.youtube.com/shop1',
                        'slug' => 'shop-example-1',
                        'meta_title' => 'Shope Example 1 Title',
                        'meta_description' => 'This is a Test purpose shop example 1.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'user_id' => 5,
                        'name' => 'Shop Example 2',
                        'logo' => '23',
                        'sliders' => 7,
                        'address' => 'House : Demo2, Road : Demo2, Section : Demo2',
                        'facebook' => 'www.facebook.com/shop2',
                        'google' => 'www.google.com/shop2',
                        'twitter' => 'www.twitter.com/shop2',
                        'youtube' => 'www.youtube.com/shop2',
                        'slug' => 'shop-example-2',
                        'meta_title' => 'Shope Example 2 Title',
                        'meta_description' => 'This is a Test purpose shop example 2.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'user_id' => 6,
                        'name' => 'Shop Example 3',
                        'logo' => '22',
                        'sliders' => 7,
                        'address' => 'House : Demo3, Road : Demo3, Section : Demo3',
                        'facebook' => 'www.facebook.com/shop3',
                        'google' => 'www.google.com/shop3',
                        'twitter' => 'www.twitter.com/shop3',
                        'youtube' => 'www.youtube.com/shop3',
                        'slug' => 'shop-example-3',
                        'meta_title' => 'Shope Example 3 Title',
                        'meta_description' => 'This is a Test purpose shop example 3.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 1.0
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'user_id' => 7,
                        'name' => 'Shop Example 4',
                        'logo' => '21',
                        'sliders' => 5,
                        'address' => 'House : Demo4, Road : Demo4, Section : Demo4',
                        'facebook' => 'www.facebook.com/shop4',
                        'google' => 'www.google.com/shop4',
                        'twitter' => 'www.twitter.com/shop4',
                        'youtube' => 'www.youtube.com/shop4',
                        'slug' => 'shop-example-4',
                        'meta_title' => 'Shope Example 4 Title',
                        'meta_description' => 'This is a Test purpose shop example 4.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.8
                    ),
                6 =>
                    array(
                        'id' => 7,
                        'user_id' => 8,
                        'name' => 'Shop Example 5',
                        'logo' => '20',
                        'sliders' => 7,
                        'address' => 'House : Demo5, Road : Demo5, Section : Demo5',
                        'facebook' => 'www.facebook.com/shop5',
                        'google' => 'www.google.com/shop5',
                        'twitter' => 'www.twitter.com/shop5',
                        'youtube' => 'www.youtube.com/shop5',
                        'slug' => 'shop-example-5',
                        'meta_title' => 'Shope Example 5 Title',
                        'meta_description' => 'This is a Test purpose shop example 5.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                7 =>
                    array(
                        'id' => 8,
                        'user_id' => 9,
                        'name' => 'Shop Example 6',
                        'logo' => '20',
                        'sliders' => 7,
                        'address' => 'House : Demo6, Road : Demo6, Section : Demo6',
                        'facebook' => 'www.facebook.com/shop6',
                        'google' => 'www.google.com/shop6',
                        'twitter' => 'www.twitter.com/shop6',
                        'youtube' => 'www.youtube.com/shop6',
                        'slug' => 'shop-example-6',
                        'meta_title' => 'Shope Example 6 Title',
                        'meta_description' => 'This is a Test purpose shop example 6.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                8 =>
                    array(
                        'id' => 9,
                        'user_id' => 10,
                        'name' => 'Shop Example 7',
                        'logo' => '19',
                        'sliders' => 7,
                        'address' => 'House : Demo7, Road : Demo7, Section : Demo7',
                        'facebook' => 'www.facebook.com/shop7',
                        'google' => 'www.google.com/shop7',
                        'twitter' => 'www.twitter.com/shop7',
                        'youtube' => 'www.youtube.com/shop7',
                        'slug' => 'shop-example-7',
                        'meta_title' => 'Shope Example 7 Title',
                        'meta_description' => 'This is a Test purpose shop example 7.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                9 =>
                    array(
                        'id' => 10,
                        'user_id' => 11,
                        'name' => 'Shop Example 8',
                        'logo' => '18',
                        'sliders' => 5,
                        'address' => 'House : Demo8, Road : Demo8, Section : Demo8',
                        'facebook' => 'www.facebook.com/shop8',
                        'google' => 'www.google.com/shop8',
                        'twitter' => 'www.twitter.com/shop8',
                        'youtube' => 'www.youtube.com/shop8',
                        'slug' => 'shop-example-8',
                        'meta_title' => 'Shope Example 8 Title',
                        'meta_description' => 'This is a Test purpose shop example 8.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                10 =>
                    array(
                        'id' => 11,
                        'user_id' => 12,
                        'name' => 'Shop Example 9',
                        'logo' => '17',
                        'sliders' => 9,
                        'address' => 'House : Demo9, Road : Demo9, Section : Demo9',
                        'facebook' => 'www.facebook.com/shop9',
                        'google' => 'www.google.com/shop9',
                        'twitter' => 'www.twitter.com/shop9',
                        'youtube' => 'www.youtube.com/shop9',
                        'slug' => 'shop-example-9',
                        'meta_title' => 'Shope Example 9 Title',
                        'meta_description' => 'This is a Test purpose shop example 9.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                11 =>
                    array(
                        'id' => 12,
                        'user_id' => 13,
                        'name' => 'Shop Example 10',
                        'logo' => '18',
                        'sliders' => 7,
                        'address' => 'House : Demo10, Road : Demo10, Section : Demo10',
                        'facebook' => 'www.facebook.com/shop10',
                        'google' => 'www.google.com/shop10',
                        'twitter' => 'www.twitter.com/shop10',
                        'youtube' => 'www.youtube.com/shop10',
                        'slug' => 'shop-example-10',
                        'meta_title' => 'Shope Example 10 Title',
                        'meta_description' => 'This is a Test purpose shop example 10.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                12 =>
                    array(
                        'id' => 13,
                        'user_id' => 14,
                        'name' => 'Shop Example 11',
                        'logo' => '14',
                        'sliders' => 7,
                        'address' => 'House : Demo11, Road : Demo11, Section : Demo11',
                        'facebook' => 'www.facebook.com/shop11',
                        'google' => 'www.google.com/shop11',
                        'twitter' => 'www.twitter.com/shop11',
                        'youtube' => 'www.youtube.com/shop11',
                        'slug' => 'shop-example-11',
                        'meta_title' => 'Shope Example 11 Title',
                        'meta_description' => 'This is a Test purpose shop example 11.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                13 =>
                    array(
                        'id' => 14,
                        'user_id' => 15,
                        'name' => 'Shop Example 12',
                        'logo' => '15',
                        'sliders' => 7,
                        'address' => 'House : Demo12, Road : Demo12, Section : Demo12',
                        'facebook' => 'www.facebook.com/shop12',
                        'google' => 'www.google.com/shop12',
                        'twitter' => 'www.twitter.com/shop12',
                        'youtube' => 'www.youtube.com/shop12',
                        'slug' => 'shop-example-12',
                        'meta_title' => 'Shope Example 12 Title',
                        'meta_description' => 'This is a Test purpose shop example 12.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                14 =>
                    array(
                        'id' => 15,
                        'user_id' => 16,
                        'name' => 'Shop Example 13',
                        'logo' => '13',
                        'sliders' => 7,
                        'address' => 'House : Demo13, Road : Demo13, Section : Demo13',
                        'facebook' => 'www.facebook.com/shop13',
                        'google' => 'www.google.com/shop13',
                        'twitter' => 'www.twitter.com/shop13',
                        'youtube' => 'www.youtube.com/shop13',
                        'slug' => 'shop-example-13',
                        'meta_title' => 'Shope Example 13 Title',
                        'meta_description' => 'This is a Test purpose shop example 13.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                15 =>
                    array(
                        'id' => 16,
                        'user_id' => 17,
                        'name' => 'Shop Example 14',
                        'logo' => '12',
                        'sliders' => 7,
                        'address' => 'House : Demo14, Road : Demo14, Section : Demo14',
                        'facebook' => 'www.facebook.com/shop14',
                        'google' => 'www.google.com/shop14',
                        'twitter' => 'www.twitter.com/shop14',
                        'youtube' => 'www.youtube.com/shop14',
                        'slug' => 'shop-example-14',
                        'meta_title' => 'Shope Example 14 Title',
                        'meta_description' => 'This is a Test purpose shop example 14.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                16 =>
                    array(
                        'id' => 17,
                        'user_id' => 18,
                        'name' => 'Shop Example 15',
                        'logo' => '11',
                        'sliders' => 9,
                        'address' => 'House : Demo15, Road : Demo15, Section : Demo15',
                        'facebook' => 'www.facebook.com/shop15',
                        'google' => 'www.google.com/shop15',
                        'twitter' => 'www.twitter.com/shop15',
                        'youtube' => 'www.youtube.com/shop15',
                        'slug' => 'shop-example-15',
                        'meta_title' => 'Shope Example 15 Title',
                        'meta_description' => 'This is a Test purpose shop example 15.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                17 =>
                    array(
                        'id' => 18,
                        'user_id' => 19,
                        'name' => 'Shop Example 16',
                        'logo' => '10',
                        'sliders' => 7,
                        'address' => 'House : Demo16, Road : Demo16, Section : Demo16',
                        'facebook' => 'www.facebook.com/shop16',
                        'google' => 'www.google.com/shop16',
                        'twitter' => 'www.twitter.com/shop16',
                        'youtube' => 'www.youtube.com/shop16',
                        'slug' => 'shop-example-16',
                        'meta_title' => 'Shope Example 16 Title',
                        'meta_description' => 'This is a Test purpose shop example 16.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                18 =>
                    array(
                        'id' => 19,
                        'user_id' => 20,
                        'name' => 'Shop Example 17',
                        'logo' => '09',
                        'sliders' => 7,
                        'address' => 'House : Demo17, Road : Demo17, Section : Demo17',
                        'facebook' => 'www.facebook.com/shop17',
                        'google' => 'www.google.com/shop17',
                        'twitter' => 'www.twitter.com/shop17',
                        'youtube' => 'www.youtube.com/shop17',
                        'slug' => 'shop-example-17',
                        'meta_title' => 'Shope Example 17 Title',
                        'meta_description' => 'This is a Test purpose shop example 17.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                19 =>
                    array(
                        'id' => 20,
                        'user_id' => 21,
                        'name' => 'Shop Example 18',
                        'logo' => '08',
                        'sliders' => 7,
                        'address' => 'House : Demo18, Road : Demo18, Section : Demo18',
                        'facebook' => 'www.facebook.com/shop18',
                        'google' => 'www.google.com/shop18',
                        'twitter' => 'www.twitter.com/shop18',
                        'youtube' => 'www.youtube.com/shop18',
                        'slug' => 'shop-example-18',
                        'meta_title' => 'Shope Example 18 Title',
                        'meta_description' => 'This is a Test purpose shop example 18.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                20 =>
                    array(
                        'id' => 21,
                        'user_id' => 22,
                        'name' => 'Shop Example 19',
                        'logo' => '07',
                        'sliders' => 7,
                        'address' => 'House : Demo19, Road : Demo19, Section : Demo19',
                        'facebook' => 'www.facebook.com/shop19',
                        'google' => 'www.google.com/shop19',
                        'twitter' => 'www.twitter.com/shop19',
                        'youtube' => 'www.youtube.com/shop19',
                        'slug' => 'shop-example-19',
                        'meta_title' => 'Shope Example 19 Title',
                        'meta_description' => 'This is a Test purpose shop example 19.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
                21 =>
                    array(
                        'id' => 22,
                        'user_id' => 23,
                        'name' => 'Shop Example 20',
                        'logo' => '20',
                        'sliders' => 8,
                        'address' => 'House : Demo20, Road : Demo20, Section : Demo20',
                        'facebook' => 'www.facebook.com/shop20',
                        'google' => 'www.google.com/shop20',
                        'twitter' => 'www.twitter.com/shop20',
                        'youtube' => 'www.youtube.com/shop20',
                        'slug' => 'shop-example-20',
                        'meta_title' => 'Shope Example 20 Title',
                        'meta_description' => 'This is a Test purpose shop example 20.',
                        'pick_up_point_id' => '[]',
                        'shipping_cost' => 0.0
                    ),
            ));

        }
    }
}
