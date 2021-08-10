<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('translations')->count() == 0) {
            \DB::table('translations')->delete();

            \DB::table('translations')->insert(array(
                0 =>
                    array(
                        'id' => 3,
                        'lang' => 'en',
                        'lang_key' => 'All Category',
                        'lang_value' => 'All Category',
                        'created_at' => '2020-11-02 09:40:38',
                        'updated_at' => '2020-11-02 09:40:38',
                    ),
                1 =>
                    array(
                        'id' => 4,
                        'lang' => 'en',
                        'lang_key' => 'All',
                        'lang_value' => 'All',
                        'created_at' => '2020-11-02 09:40:38',
                        'updated_at' => '2020-11-02 09:40:38',
                    ),
                2 =>
                    array(
                        'id' => 5,
                        'lang' => 'en',
                        'lang_key' => 'Flash Sale',
                        'lang_value' => 'Flash Sale',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                3 =>
                    array(
                        'id' => 6,
                        'lang' => 'en',
                        'lang_key' => 'View More',
                        'lang_value' => 'View More',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                4 =>
                    array(
                        'id' => 7,
                        'lang' => 'en',
                        'lang_key' => 'Add to wishlist',
                        'lang_value' => 'Add to wishlist',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                5 =>
                    array(
                        'id' => 8,
                        'lang' => 'en',
                        'lang_key' => 'Add to compare',
                        'lang_value' => 'Add to compare',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                6 =>
                    array(
                        'id' => 9,
                        'lang' => 'en',
                        'lang_key' => 'Add to cart',
                        'lang_value' => 'Add to cart',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                7 =>
                    array(
                        'id' => 10,
                        'lang' => 'en',
                        'lang_key' => 'Club Point',
                        'lang_value' => 'Club Point',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                8 =>
                    array(
                        'id' => 11,
                        'lang' => 'en',
                        'lang_key' => 'Classified Ads',
                        'lang_value' => 'Classified Ads',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                9 =>
                    array(
                        'id' => 13,
                        'lang' => 'en',
                        'lang_key' => 'Used',
                        'lang_value' => 'Used',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                10 =>
                    array(
                        'id' => 14,
                        'lang' => 'en',
                        'lang_key' => 'Top 10 Categories',
                        'lang_value' => 'Top 10 Categories',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                11 =>
                    array(
                        'id' => 15,
                        'lang' => 'en',
                        'lang_key' => 'View All Categories',
                        'lang_value' => 'View All Categories',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                12 =>
                    array(
                        'id' => 16,
                        'lang' => 'en',
                        'lang_key' => 'Top 10 Brands',
                        'lang_value' => 'Top 10 Brands',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                13 =>
                    array(
                        'id' => 17,
                        'lang' => 'en',
                        'lang_key' => 'View All Brands',
                        'lang_value' => 'View All Brands',
                        'created_at' => '2020-11-02 09:40:40',
                        'updated_at' => '2020-11-02 09:40:40',
                    ),
                14 =>
                    array(
                        'id' => 43,
                        'lang' => 'en',
                        'lang_key' => 'Terms & conditions',
                        'lang_value' => 'Terms & conditions',
                        'created_at' => '2020-11-02 09:40:41',
                        'updated_at' => '2020-11-02 09:40:41',
                    ),
                15 =>
                    array(
                        'id' => 51,
                        'lang' => 'en',
                        'lang_key' => 'Best Selling',
                        'lang_value' => 'Best Selling',
                        'created_at' => '2020-11-02 09:40:42',
                        'updated_at' => '2020-11-02 09:40:42',
                    ),
                16 =>
                    array(
                        'id' => 53,
                        'lang' => 'en',
                        'lang_key' => 'Top 20',
                        'lang_value' => 'Top 20',
                        'created_at' => '2020-11-02 09:40:42',
                        'updated_at' => '2020-11-02 09:40:42',
                    ),
                17 =>
                    array(
                        'id' => 55,
                        'lang' => 'en',
                        'lang_key' => 'Featured Products',
                        'lang_value' => 'Featured Products',
                        'created_at' => '2020-11-02 09:40:42',
                        'updated_at' => '2020-11-02 09:40:42',
                    ),
                18 =>
                    array(
                        'id' => 56,
                        'lang' => 'en',
                        'lang_key' => 'Best Sellers',
                        'lang_value' => 'Best Sellers',
                        'created_at' => '2020-11-02 09:40:43',
                        'updated_at' => '2020-11-02 09:40:43',
                    ),
                19 =>
                    array(
                        'id' => 57,
                        'lang' => 'en',
                        'lang_key' => 'Visit Store',
                        'lang_value' => 'Visit Store',
                        'created_at' => '2020-11-02 09:40:43',
                        'updated_at' => '2020-11-02 09:40:43',
                    ),
                20 =>
                    array(
                        'id' => 58,
                        'lang' => 'en',
                        'lang_key' => 'Popular Suggestions',
                        'lang_value' => 'Popular Suggestions',
                        'created_at' => '2020-11-02 09:46:59',
                        'updated_at' => '2020-11-02 09:46:59',
                    ),
                21 =>
                    array(
                        'id' => 59,
                        'lang' => 'en',
                        'lang_key' => 'Category Suggestions',
                        'lang_value' => 'Category Suggestions',
                        'created_at' => '2020-11-02 09:46:59',
                        'updated_at' => '2020-11-02 09:46:59',
                    ),
                22 =>
                    array(
                        'id' => 62,
                        'lang' => 'en',
                        'lang_key' => 'Automobile & Motorcycle',
                        'lang_value' => 'Automobile & Motorcycle',
                        'created_at' => '2020-11-02 09:47:01',
                        'updated_at' => '2020-11-02 09:47:01',
                    ),
                23 =>
                    array(
                        'id' => 63,
                        'lang' => 'en',
                        'lang_key' => 'Price range',
                        'lang_value' => 'Price range',
                        'created_at' => '2020-11-02 09:47:01',
                        'updated_at' => '2020-11-02 09:47:01',
                    ),
                24 =>
                    array(
                        'id' => 64,
                        'lang' => 'en',
                        'lang_key' => 'Filter by color',
                        'lang_value' => 'Filter by color',
                        'created_at' => '2020-11-02 09:47:02',
                        'updated_at' => '2020-11-02 09:47:02',
                    ),
                25 =>
                    array(
                        'id' => 65,
                        'lang' => 'en',
                        'lang_key' => 'Home',
                        'lang_value' => 'Home',
                        'created_at' => '2020-11-02 09:47:02',
                        'updated_at' => '2020-11-02 09:47:02',
                    ),
                26 =>
                    array(
                        'id' => 67,
                        'lang' => 'en',
                        'lang_key' => 'Newest',
                        'lang_value' => 'Newest',
                        'created_at' => '2020-11-02 09:47:02',
                        'updated_at' => '2020-11-02 09:47:02',
                    ),
                27 =>
                    array(
                        'id' => 68,
                        'lang' => 'en',
                        'lang_key' => 'Oldest',
                        'lang_value' => 'Oldest',
                        'created_at' => '2020-11-02 09:47:02',
                        'updated_at' => '2020-11-02 09:47:02',
                    ),
                28 =>
                    array(
                        'id' => 69,
                        'lang' => 'en',
                        'lang_key' => 'Price low to high',
                        'lang_value' => 'Price low to high',
                        'created_at' => '2020-11-02 09:47:02',
                        'updated_at' => '2020-11-02 09:47:02',
                    ),
                29 =>
                    array(
                        'id' => 70,
                        'lang' => 'en',
                        'lang_key' => 'Price high to low',
                        'lang_value' => 'Price high to low',
                        'created_at' => '2020-11-02 09:47:02',
                        'updated_at' => '2020-11-02 09:47:02',
                    ),
                30 =>
                    array(
                        'id' => 71,
                        'lang' => 'en',
                        'lang_key' => 'Brands',
                        'lang_value' => 'Brands',
                        'created_at' => '2020-11-02 09:47:02',
                        'updated_at' => '2020-11-02 09:47:02',
                    ),
                31 =>
                    array(
                        'id' => 72,
                        'lang' => 'en',
                        'lang_key' => 'All Brands',
                        'lang_value' => 'All Brands',
                        'created_at' => '2020-11-02 09:47:02',
                        'updated_at' => '2020-11-02 09:47:02',
                    ),
                32 =>
                    array(
                        'id' => 74,
                        'lang' => 'en',
                        'lang_key' => 'All Sellers',
                        'lang_value' => 'All Sellers',
                        'created_at' => '2020-11-02 09:47:02',
                        'updated_at' => '2020-11-02 09:47:02',
                    ),
                33 =>
                    array(
                        'id' => 78,
                        'lang' => 'en',
                        'lang_key' => 'Inhouse product',
                        'lang_value' => 'Inhouse product',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                34 =>
                    array(
                        'id' => 79,
                        'lang' => 'en',
                        'lang_key' => 'Message Seller',
                        'lang_value' => 'Message Seller',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                35 =>
                    array(
                        'id' => 80,
                        'lang' => 'en',
                        'lang_key' => 'Price',
                        'lang_value' => 'Price',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                36 =>
                    array(
                        'id' => 81,
                        'lang' => 'en',
                        'lang_key' => 'Discount Price',
                        'lang_value' => 'Discount Price',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                37 =>
                    array(
                        'id' => 82,
                        'lang' => 'en',
                        'lang_key' => 'Color',
                        'lang_value' => 'Color',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                38 =>
                    array(
                        'id' => 83,
                        'lang' => 'en',
                        'lang_key' => 'Quantity',
                        'lang_value' => 'Quantity',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                39 =>
                    array(
                        'id' => 84,
                        'lang' => 'en',
                        'lang_key' => 'available',
                        'lang_value' => 'available',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                40 =>
                    array(
                        'id' => 85,
                        'lang' => 'en',
                        'lang_key' => 'Total Price',
                        'lang_value' => 'Total Price',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                41 =>
                    array(
                        'id' => 86,
                        'lang' => 'en',
                        'lang_key' => 'Out of Stock',
                        'lang_value' => 'Out of Stock',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                42 =>
                    array(
                        'id' => 87,
                        'lang' => 'en',
                        'lang_key' => 'Refund',
                        'lang_value' => 'Refund',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                43 =>
                    array(
                        'id' => 88,
                        'lang' => 'en',
                        'lang_key' => 'Share',
                        'lang_value' => 'Share',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                44 =>
                    array(
                        'id' => 89,
                        'lang' => 'en',
                        'lang_key' => 'Sold By',
                        'lang_value' => 'Sold By',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                45 =>
                    array(
                        'id' => 90,
                        'lang' => 'en',
                        'lang_key' => 'customer reviews',
                        'lang_value' => 'customer reviews',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                46 =>
                    array(
                        'id' => 91,
                        'lang' => 'en',
                        'lang_key' => 'Top Selling Products',
                        'lang_value' => 'Top Selling Products',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                47 =>
                    array(
                        'id' => 92,
                        'lang' => 'en',
                        'lang_key' => 'Description',
                        'lang_value' => 'Description',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                48 =>
                    array(
                        'id' => 93,
                        'lang' => 'en',
                        'lang_key' => 'Video',
                        'lang_value' => 'Video',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                49 =>
                    array(
                        'id' => 94,
                        'lang' => 'en',
                        'lang_key' => 'Reviews',
                        'lang_value' => 'Reviews',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                50 =>
                    array(
                        'id' => 95,
                        'lang' => 'en',
                        'lang_key' => 'Download',
                        'lang_value' => 'Download',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                51 =>
                    array(
                        'id' => 96,
                        'lang' => 'en',
                        'lang_key' => 'There have been no reviews for this product yet.',
                        'lang_value' => 'There have been no reviews for this product yet.',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                52 =>
                    array(
                        'id' => 97,
                        'lang' => 'en',
                        'lang_key' => 'Related products',
                        'lang_value' => 'Related products',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                53 =>
                    array(
                        'id' => 98,
                        'lang' => 'en',
                        'lang_key' => 'Any query about this product',
                        'lang_value' => 'Any query about this product',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                54 =>
                    array(
                        'id' => 99,
                        'lang' => 'en',
                        'lang_key' => 'Product Name',
                        'lang_value' => 'Product Name',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                55 =>
                    array(
                        'id' => 100,
                        'lang' => 'en',
                        'lang_key' => 'Your Question',
                        'lang_value' => 'Your Question',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                56 =>
                    array(
                        'id' => 101,
                        'lang' => 'en',
                        'lang_key' => 'Send',
                        'lang_value' => 'Send',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                57 =>
                    array(
                        'id' => 103,
                        'lang' => 'en',
                        'lang_key' => 'Use country code before number',
                        'lang_value' => 'Use country code before number',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                58 =>
                    array(
                        'id' => 105,
                        'lang' => 'en',
                        'lang_key' => 'Remember Me',
                        'lang_value' => 'Remember Me',
                        'created_at' => '2020-11-02 10:18:03',
                        'updated_at' => '2020-11-02 10:18:03',
                    ),
                59 =>
                    array(
                        'id' => 107,
                        'lang' => 'en',
                        'lang_key' => 'Dont have an account?',
                        'lang_value' => 'Dont have an account?',
                        'created_at' => '2020-11-02 10:18:04',
                        'updated_at' => '2020-11-02 10:18:04',
                    ),
                60 =>
                    array(
                        'id' => 108,
                        'lang' => 'en',
                        'lang_key' => 'Register Now',
                        'lang_value' => 'Register Now',
                        'created_at' => '2020-11-02 10:18:04',
                        'updated_at' => '2020-11-02 10:18:04',
                    ),
                61 =>
                    array(
                        'id' => 109,
                        'lang' => 'en',
                        'lang_key' => 'Or Login With',
                        'lang_value' => 'Or Login With',
                        'created_at' => '2020-11-02 10:18:04',
                        'updated_at' => '2020-11-02 10:18:04',
                    ),
                62 =>
                    array(
                        'id' => 110,
                        'lang' => 'en',
                        'lang_key' => 'oops..',
                        'lang_value' => 'oops..',
                        'created_at' => '2020-11-02 12:29:04',
                        'updated_at' => '2020-11-02 12:29:04',
                    ),
                63 =>
                    array(
                        'id' => 111,
                        'lang' => 'en',
                        'lang_key' => 'This item is out of stock!',
                        'lang_value' => 'This item is out of stock!',
                        'created_at' => '2020-11-02 12:29:04',
                        'updated_at' => '2020-11-02 12:29:04',
                    ),
                64 =>
                    array(
                        'id' => 112,
                        'lang' => 'en',
                        'lang_key' => 'Back to shopping',
                        'lang_value' => 'Back to shopping',
                        'created_at' => '2020-11-02 12:29:04',
                        'updated_at' => '2020-11-02 12:29:04',
                    ),
                65 =>
                    array(
                        'id' => 113,
                        'lang' => 'en',
                        'lang_key' => 'Login to your account.',
                        'lang_value' => 'Login to your account.',
                        'created_at' => '2020-11-02 13:27:41',
                        'updated_at' => '2020-11-02 13:27:41',
                    ),
                66 =>
                    array(
                        'id' => 115,
                        'lang' => 'en',
                        'lang_key' => 'Purchase History',
                        'lang_value' => 'Purchase History',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                67 =>
                    array(
                        'id' => 116,
                        'lang' => 'en',
                        'lang_key' => 'New',
                        'lang_value' => 'New',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                68 =>
                    array(
                        'id' => 117,
                        'lang' => 'en',
                        'lang_key' => 'Downloads',
                        'lang_value' => 'Downloads',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                69 =>
                    array(
                        'id' => 118,
                        'lang' => 'en',
                        'lang_key' => 'Sent Refund Request',
                        'lang_value' => 'Sent Refund Request',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                70 =>
                    array(
                        'id' => 119,
                        'lang' => 'en',
                        'lang_key' => 'Product Bulk Upload',
                        'lang_value' => 'Product Bulk Upload',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                71 =>
                    array(
                        'id' => 123,
                        'lang' => 'en',
                        'lang_key' => 'Orders',
                        'lang_value' => 'Orders',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                72 =>
                    array(
                        'id' => 124,
                        'lang' => 'en',
                        'lang_key' => 'Recieved Refund Request',
                        'lang_value' => 'Recieved Refund Request',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                73 =>
                    array(
                        'id' => 126,
                        'lang' => 'en',
                        'lang_key' => 'Shop Setting',
                        'lang_value' => 'Shop Setting',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                74 =>
                    array(
                        'id' => 127,
                        'lang' => 'en',
                        'lang_key' => 'Payment History',
                        'lang_value' => 'Payment History',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                75 =>
                    array(
                        'id' => 128,
                        'lang' => 'en',
                        'lang_key' => 'Money Withdraw',
                        'lang_value' => 'Money Withdraw',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                76 =>
                    array(
                        'id' => 129,
                        'lang' => 'en',
                        'lang_key' => 'Conversations',
                        'lang_value' => 'Conversations',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                77 =>
                    array(
                        'id' => 130,
                        'lang' => 'en',
                        'lang_key' => 'My Wallet',
                        'lang_value' => 'My Wallet',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                78 =>
                    array(
                        'id' => 131,
                        'lang' => 'en',
                        'lang_key' => 'Earning Points',
                        'lang_value' => 'Earning Points',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                79 =>
                    array(
                        'id' => 132,
                        'lang' => 'en',
                        'lang_key' => 'Support Ticket',
                        'lang_value' => 'Support Ticket',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                80 =>
                    array(
                        'id' => 133,
                        'lang' => 'en',
                        'lang_key' => 'Manage Profile',
                        'lang_value' => 'Manage Profile',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                81 =>
                    array(
                        'id' => 134,
                        'lang' => 'en',
                        'lang_key' => 'Sold Amount',
                        'lang_value' => 'Sold Amount',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                82 =>
                    array(
                        'id' => 135,
                        'lang' => 'en',
                        'lang_key' => 'Your sold amount (current month)',
                        'lang_value' => 'Your sold amount (current month)',
                        'created_at' => '2020-11-02 13:27:53',
                        'updated_at' => '2020-11-02 13:27:53',
                    ),
                83 =>
                    array(
                        'id' => 136,
                        'lang' => 'en',
                        'lang_key' => 'Total Sold',
                        'lang_value' => 'Total Sold',
                        'created_at' => '2020-11-02 13:27:54',
                        'updated_at' => '2020-11-02 13:27:54',
                    ),
                84 =>
                    array(
                        'id' => 137,
                        'lang' => 'en',
                        'lang_key' => 'Last Month Sold',
                        'lang_value' => 'Last Month Sold',
                        'created_at' => '2020-11-02 13:27:54',
                        'updated_at' => '2020-11-02 13:27:54',
                    ),
                85 =>
                    array(
                        'id' => 138,
                        'lang' => 'en',
                        'lang_key' => 'Total sale',
                        'lang_value' => 'Total sale',
                        'created_at' => '2020-11-02 13:27:54',
                        'updated_at' => '2020-11-02 13:27:54',
                    ),
                86 =>
                    array(
                        'id' => 139,
                        'lang' => 'en',
                        'lang_key' => 'Total earnings',
                        'lang_value' => 'Total earnings',
                        'created_at' => '2020-11-02 13:27:54',
                        'updated_at' => '2020-11-02 13:27:54',
                    ),
                87 =>
                    array(
                        'id' => 140,
                        'lang' => 'en',
                        'lang_key' => 'Successful orders',
                        'lang_value' => 'Successful orders',
                        'created_at' => '2020-11-02 13:27:54',
                        'updated_at' => '2020-11-02 13:27:54',
                    ),
                88 =>
                    array(
                        'id' => 141,
                        'lang' => 'en',
                        'lang_key' => 'Total orders',
                        'lang_value' => 'Total orders',
                        'created_at' => '2020-11-02 13:27:54',
                        'updated_at' => '2020-11-02 13:27:54',
                    ),
                89 =>
                    array(
                        'id' => 142,
                        'lang' => 'en',
                        'lang_key' => 'Pending orders',
                        'lang_value' => 'Pending orders',
                        'created_at' => '2020-11-02 13:27:54',
                        'updated_at' => '2020-11-02 13:27:54',
                    ),
                90 =>
                    array(
                        'id' => 143,
                        'lang' => 'en',
                        'lang_key' => 'Cancelled orders',
                        'lang_value' => 'Cancelled orders',
                        'created_at' => '2020-11-02 13:27:54',
                        'updated_at' => '2020-11-02 13:27:54',
                    ),
                91 =>
                    array(
                        'id' => 145,
                        'lang' => 'en',
                        'lang_key' => 'Product',
                        'lang_value' => 'Product',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                92 =>
                    array(
                        'id' => 147,
                        'lang' => 'en',
                        'lang_key' => 'Purchased Package',
                        'lang_value' => 'Purchased Package',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                93 =>
                    array(
                        'id' => 148,
                        'lang' => 'en',
                        'lang_key' => 'Package Not Found',
                        'lang_value' => 'Package Not Found',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                94 =>
                    array(
                        'id' => 149,
                        'lang' => 'en',
                        'lang_key' => 'Upgrade Package',
                        'lang_value' => 'Upgrade Package',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                95 =>
                    array(
                        'id' => 150,
                        'lang' => 'en',
                        'lang_key' => 'Shop',
                        'lang_value' => 'Shop',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                96 =>
                    array(
                        'id' => 151,
                        'lang' => 'en',
                        'lang_key' => 'Manage & organize your shop',
                        'lang_value' => 'Manage & organize your shop',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                97 =>
                    array(
                        'id' => 152,
                        'lang' => 'en',
                        'lang_key' => 'Go to setting',
                        'lang_value' => 'Go to setting',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                98 =>
                    array(
                        'id' => 153,
                        'lang' => 'en',
                        'lang_key' => 'Payment',
                        'lang_value' => 'Payment',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                99 =>
                    array(
                        'id' => 154,
                        'lang' => 'en',
                        'lang_key' => 'Configure your payment method',
                        'lang_value' => 'Configure your payment method',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                100 =>
                    array(
                        'id' => 156,
                        'lang' => 'en',
                        'lang_key' => 'My Panel',
                        'lang_value' => 'My Panel',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                101 =>
                    array(
                        'id' => 158,
                        'lang' => 'en',
                        'lang_key' => 'Item has been added to wishlist',
                        'lang_value' => 'Item has been added to wishlist',
                        'created_at' => '2020-11-02 13:27:55',
                        'updated_at' => '2020-11-02 13:27:55',
                    ),
                102 =>
                    array(
                        'id' => 159,
                        'lang' => 'en',
                        'lang_key' => 'My Points',
                        'lang_value' => 'My Points',
                        'created_at' => '2020-11-02 13:28:15',
                        'updated_at' => '2020-11-02 13:28:15',
                    ),
                103 =>
                    array(
                        'id' => 160,
                        'lang' => 'en',
                        'lang_key' => ' Points',
                        'lang_value' => ' Points',
                        'created_at' => '2020-11-02 13:28:15',
                        'updated_at' => '2020-11-02 13:28:15',
                    ),
                104 =>
                    array(
                        'id' => 161,
                        'lang' => 'en',
                        'lang_key' => 'Wallet Money',
                        'lang_value' => 'Wallet Money',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                105 =>
                    array(
                        'id' => 162,
                        'lang' => 'en',
                        'lang_key' => 'Exchange Rate',
                        'lang_value' => 'Exchange Rate',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                106 =>
                    array(
                        'id' => 163,
                        'lang' => 'en',
                        'lang_key' => 'Point Earning history',
                        'lang_value' => 'Point Earning history',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                107 =>
                    array(
                        'id' => 164,
                        'lang' => 'en',
                        'lang_key' => 'Date',
                        'lang_value' => 'Date',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                108 =>
                    array(
                        'id' => 165,
                        'lang' => 'en',
                        'lang_key' => 'Points',
                        'lang_value' => 'Points',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                109 =>
                    array(
                        'id' => 166,
                        'lang' => 'en',
                        'lang_key' => 'Converted',
                        'lang_value' => 'Converted',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                110 =>
                    array(
                        'id' => 167,
                        'lang' => 'en',
                        'lang_key' => 'Action',
                        'lang_value' => 'Action',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                111 =>
                    array(
                        'id' => 168,
                        'lang' => 'en',
                        'lang_key' => 'No history found.',
                        'lang_value' => 'No history found.',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                112 =>
                    array(
                        'id' => 169,
                        'lang' => 'en',
                        'lang_key' => 'Convert has been done successfully Check your Wallets',
                        'lang_value' => 'Convert has been done successfully Check your Wallets',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                113 =>
                    array(
                        'id' => 170,
                        'lang' => 'en',
                        'lang_key' => 'Something went wrong',
                        'lang_value' => 'Something went wrong',
                        'created_at' => '2020-11-02 13:28:16',
                        'updated_at' => '2020-11-02 13:28:16',
                    ),
                114 =>
                    array(
                        'id' => 171,
                        'lang' => 'en',
                        'lang_key' => 'Remaining Uploads',
                        'lang_value' => 'Remaining Uploads',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                115 =>
                    array(
                        'id' => 172,
                        'lang' => 'en',
                        'lang_key' => 'No Package Found',
                        'lang_value' => 'No Package Found',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                116 =>
                    array(
                        'id' => 173,
                        'lang' => 'en',
                        'lang_key' => 'Search product',
                        'lang_value' => 'Search product',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                117 =>
                    array(
                        'id' => 174,
                        'lang' => 'en',
                        'lang_key' => 'Name',
                        'lang_value' => 'Name',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                118 =>
                    array(
                        'id' => 176,
                        'lang' => 'en',
                        'lang_key' => 'Current Qty',
                        'lang_value' => 'Current Qty',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                119 =>
                    array(
                        'id' => 177,
                        'lang' => 'en',
                        'lang_key' => 'Base Price',
                        'lang_value' => 'Base Price',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                120 =>
                    array(
                        'id' => 178,
                        'lang' => 'en',
                        'lang_key' => 'Published',
                        'lang_value' => 'Published',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                121 =>
                    array(
                        'id' => 179,
                        'lang' => 'en',
                        'lang_key' => 'Featured',
                        'lang_value' => 'Featured',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                122 =>
                    array(
                        'id' => 180,
                        'lang' => 'en',
                        'lang_key' => 'Options',
                        'lang_value' => 'Options',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                123 =>
                    array(
                        'id' => 181,
                        'lang' => 'en',
                        'lang_key' => 'Edit',
                        'lang_value' => 'Edit',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                124 =>
                    array(
                        'id' => 182,
                        'lang' => 'en',
                        'lang_key' => 'Duplicate',
                        'lang_value' => 'Duplicate',
                        'created_at' => '2020-11-02 13:37:13',
                        'updated_at' => '2020-11-02 13:37:13',
                    ),
                125 =>
                    array(
                        'id' => 184,
                        'lang' => 'en',
                        'lang_key' => '1. Download the skeleton file and fill it with data.',
                        'lang_value' => '1. Download the skeleton file and fill it with data.',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                126 =>
                    array(
                        'id' => 185,
                        'lang' => 'en',
                        'lang_key' => '2. You can download the example file to understand how the data must be filled.',
                        'lang_value' => '2. You can download the example file to understand how the data must be filled.',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                127 =>
                    array(
                        'id' => 186,
                        'lang' => 'en',
                        'lang_key' => '3. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.',
                        'lang_value' => '3. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                128 =>
                    array(
                        'id' => 187,
                        'lang' => 'en',
                        'lang_key' => '4. After uploading products you need to edit them and set products images and choices.',
                        'lang_value' => '4. After uploading products you need to edit them and set products images and choices.',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                129 =>
                    array(
                        'id' => 188,
                        'lang' => 'en',
                        'lang_key' => 'Download CSV',
                        'lang_value' => 'Download CSV',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                130 =>
                    array(
                        'id' => 189,
                        'lang' => 'en',
                        'lang_key' => '1. Category,Sub category,Sub Sub category and Brand should be in numerical ids.',
                        'lang_value' => '1. Category,Sub category,Sub Sub category and Brand should be in numerical ids.',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                131 =>
                    array(
                        'id' => 190,
                        'lang' => 'en',
                        'lang_key' => '2. You can download the pdf to get Category,Sub category,Sub Sub category and Brand id.',
                        'lang_value' => '2. You can download the pdf to get Category,Sub category,Sub Sub category and Brand id.',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                132 =>
                    array(
                        'id' => 191,
                        'lang' => 'en',
                        'lang_key' => 'Download Category',
                        'lang_value' => 'Download Category',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                133 =>
                    array(
                        'id' => 192,
                        'lang' => 'en',
                        'lang_key' => 'Download Sub category',
                        'lang_value' => 'Download Sub category',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                134 =>
                    array(
                        'id' => 193,
                        'lang' => 'en',
                        'lang_key' => 'Download Sub Sub category',
                        'lang_value' => 'Download Sub Sub category',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                135 =>
                    array(
                        'id' => 194,
                        'lang' => 'en',
                        'lang_key' => 'Download Brand',
                        'lang_value' => 'Download Brand',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                136 =>
                    array(
                        'id' => 195,
                        'lang' => 'en',
                        'lang_key' => 'Upload CSV File',
                        'lang_value' => 'Upload CSV File',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                137 =>
                    array(
                        'id' => 196,
                        'lang' => 'en',
                        'lang_key' => 'CSV',
                        'lang_value' => 'CSV',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                138 =>
                    array(
                        'id' => 197,
                        'lang' => 'en',
                        'lang_key' => 'Choose CSV File',
                        'lang_value' => 'Choose CSV File',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                139 =>
                    array(
                        'id' => 198,
                        'lang' => 'en',
                        'lang_key' => 'Upload',
                        'lang_value' => 'Upload',
                        'created_at' => '2020-11-02 13:37:20',
                        'updated_at' => '2020-11-02 13:37:20',
                    ),
                140 =>
                    array(
                        'id' => 199,
                        'lang' => 'en',
                        'lang_key' => 'Add New Digital Product',
                        'lang_value' => 'Add New Digital Product',
                        'created_at' => '2020-11-02 13:37:25',
                        'updated_at' => '2020-11-02 13:37:25',
                    ),
                141 =>
                    array(
                        'id' => 200,
                        'lang' => 'en',
                        'lang_key' => 'Available Status',
                        'lang_value' => 'Available Status',
                        'created_at' => '2020-11-02 13:37:29',
                        'updated_at' => '2020-11-02 13:37:29',
                    ),
                142 =>
                    array(
                        'id' => 201,
                        'lang' => 'en',
                        'lang_key' => 'Admin Status',
                        'lang_value' => 'Admin Status',
                        'created_at' => '2020-11-02 13:37:29',
                        'updated_at' => '2020-11-02 13:37:29',
                    ),
                143 =>
                    array(
                        'id' => 202,
                        'lang' => 'en',
                        'lang_key' => 'Pending Balance',
                        'lang_value' => 'Pending Balance',
                        'created_at' => '2020-11-02 13:38:07',
                        'updated_at' => '2020-11-02 13:38:07',
                    ),
                144 =>
                    array(
                        'id' => 203,
                        'lang' => 'en',
                        'lang_key' => 'Send Withdraw Request',
                        'lang_value' => 'Send Withdraw Request',
                        'created_at' => '2020-11-02 13:38:07',
                        'updated_at' => '2020-11-02 13:38:07',
                    ),
                145 =>
                    array(
                        'id' => 204,
                        'lang' => 'en',
                        'lang_key' => 'Withdraw Request history',
                        'lang_value' => 'Withdraw Request history',
                        'created_at' => '2020-11-02 13:38:07',
                        'updated_at' => '2020-11-02 13:38:07',
                    ),
                146 =>
                    array(
                        'id' => 205,
                        'lang' => 'en',
                        'lang_key' => 'Amount',
                        'lang_value' => 'Amount',
                        'created_at' => '2020-11-02 13:38:07',
                        'updated_at' => '2020-11-02 13:38:07',
                    ),
                147 =>
                    array(
                        'id' => 206,
                        'lang' => 'en',
                        'lang_key' => 'Status',
                        'lang_value' => 'Status',
                        'created_at' => '2020-11-02 13:38:07',
                        'updated_at' => '2020-11-02 13:38:07',
                    ),
                148 =>
                    array(
                        'id' => 207,
                        'lang' => 'en',
                        'lang_key' => 'Message',
                        'lang_value' => 'Message',
                        'created_at' => '2020-11-02 13:38:07',
                        'updated_at' => '2020-11-02 13:38:07',
                    ),
                149 =>
                    array(
                        'id' => 208,
                        'lang' => 'en',
                        'lang_key' => 'Send A Withdraw Request',
                        'lang_value' => 'Send A Withdraw Request',
                        'created_at' => '2020-11-02 13:38:07',
                        'updated_at' => '2020-11-02 13:38:07',
                    ),
                150 =>
                    array(
                        'id' => 209,
                        'lang' => 'en',
                        'lang_key' => 'Basic Info',
                        'lang_value' => 'Basic Info',
                        'created_at' => '2020-11-02 13:38:13',
                        'updated_at' => '2020-11-02 13:38:13',
                    ),
                151 =>
                    array(
                        'id' => 211,
                        'lang' => 'en',
                        'lang_key' => 'Your Phone',
                        'lang_value' => 'Your Phone',
                        'created_at' => '2020-11-02 13:38:13',
                        'updated_at' => '2020-11-02 13:38:13',
                    ),
                152 =>
                    array(
                        'id' => 212,
                        'lang' => 'en',
                        'lang_key' => 'Photo',
                        'lang_value' => 'Photo',
                        'created_at' => '2020-11-02 13:38:13',
                        'updated_at' => '2020-11-02 13:38:13',
                    ),
                153 =>
                    array(
                        'id' => 213,
                        'lang' => 'en',
                        'lang_key' => 'Browse',
                        'lang_value' => 'Browse',
                        'created_at' => '2020-11-02 13:38:13',
                        'updated_at' => '2020-11-02 13:38:13',
                    ),
                154 =>
                    array(
                        'id' => 215,
                        'lang' => 'en',
                        'lang_key' => 'Your Password',
                        'lang_value' => 'Your Password',
                        'created_at' => '2020-11-02 13:38:13',
                        'updated_at' => '2020-11-02 13:38:13',
                    ),
                155 =>
                    array(
                        'id' => 216,
                        'lang' => 'en',
                        'lang_key' => 'New Password',
                        'lang_value' => 'New Password',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                156 =>
                    array(
                        'id' => 217,
                        'lang' => 'en',
                        'lang_key' => 'Confirm Password',
                        'lang_value' => 'Confirm Password',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                157 =>
                    array(
                        'id' => 218,
                        'lang' => 'en',
                        'lang_key' => 'Add New Address',
                        'lang_value' => 'Add New Address',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                158 =>
                    array(
                        'id' => 219,
                        'lang' => 'en',
                        'lang_key' => 'Payment Setting',
                        'lang_value' => 'Payment Setting',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                159 =>
                    array(
                        'id' => 220,
                        'lang' => 'en',
                        'lang_key' => 'Cash Payment',
                        'lang_value' => 'Cash Payment',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                160 =>
                    array(
                        'id' => 221,
                        'lang' => 'en',
                        'lang_key' => 'Bank Payment',
                        'lang_value' => 'Bank Payment',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                161 =>
                    array(
                        'id' => 222,
                        'lang' => 'en',
                        'lang_key' => 'Bank Name',
                        'lang_value' => 'Bank Name',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                162 =>
                    array(
                        'id' => 223,
                        'lang' => 'en',
                        'lang_key' => 'Bank Account Name',
                        'lang_value' => 'Bank Account Name',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                163 =>
                    array(
                        'id' => 224,
                        'lang' => 'en',
                        'lang_key' => 'Bank Account Number',
                        'lang_value' => 'Bank Account Number',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                164 =>
                    array(
                        'id' => 225,
                        'lang' => 'en',
                        'lang_key' => 'Bank Routing Number',
                        'lang_value' => 'Bank Routing Number',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                165 =>
                    array(
                        'id' => 226,
                        'lang' => 'en',
                        'lang_key' => 'Update Profile',
                        'lang_value' => 'Update Profile',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                166 =>
                    array(
                        'id' => 227,
                        'lang' => 'en',
                        'lang_key' => 'Change your email',
                        'lang_value' => 'Change your email',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                167 =>
                    array(
                        'id' => 228,
                        'lang' => 'en',
                        'lang_key' => 'Your Email',
                        'lang_value' => 'Your Email',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                168 =>
                    array(
                        'id' => 229,
                        'lang' => 'en',
                        'lang_key' => 'Sending Email...',
                        'lang_value' => 'Sending Email...',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                169 =>
                    array(
                        'id' => 230,
                        'lang' => 'en',
                        'lang_key' => 'Verify',
                        'lang_value' => 'Verify',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                170 =>
                    array(
                        'id' => 231,
                        'lang' => 'en',
                        'lang_key' => 'Update Email',
                        'lang_value' => 'Update Email',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                171 =>
                    array(
                        'id' => 232,
                        'lang' => 'en',
                        'lang_key' => 'New Address',
                        'lang_value' => 'New Address',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                172 =>
                    array(
                        'id' => 233,
                        'lang' => 'en',
                        'lang_key' => 'Your Address',
                        'lang_value' => 'Your Address',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                173 =>
                    array(
                        'id' => 234,
                        'lang' => 'en',
                        'lang_key' => 'Country',
                        'lang_value' => 'Country',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                174 =>
                    array(
                        'id' => 235,
                        'lang' => 'en',
                        'lang_key' => 'Select your country',
                        'lang_value' => 'Select your country',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                175 =>
                    array(
                        'id' => 236,
                        'lang' => 'en',
                        'lang_key' => 'City',
                        'lang_value' => 'City',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                176 =>
                    array(
                        'id' => 237,
                        'lang' => 'en',
                        'lang_key' => 'Your City',
                        'lang_value' => 'Your City',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                177 =>
                    array(
                        'id' => 239,
                        'lang' => 'en',
                        'lang_key' => 'Your Postal Code',
                        'lang_value' => 'Your Postal Code',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                178 =>
                    array(
                        'id' => 240,
                        'lang' => 'en',
                        'lang_key' => '+880',
                        'lang_value' => '+880',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                179 =>
                    array(
                        'id' => 241,
                        'lang' => 'en',
                        'lang_key' => 'Save',
                        'lang_value' => 'Save',
                        'created_at' => '2020-11-02 13:38:14',
                        'updated_at' => '2020-11-02 13:38:14',
                    ),
                180 =>
                    array(
                        'id' => 242,
                        'lang' => 'en',
                        'lang_key' => 'Received Refund Request',
                        'lang_value' => 'Received Refund Request',
                        'created_at' => '2020-11-02 13:56:20',
                        'updated_at' => '2020-11-02 13:56:20',
                    ),
                181 =>
                    array(
                        'id' => 244,
                        'lang' => 'en',
                        'lang_key' => 'Delete Confirmation',
                        'lang_value' => 'Delete Confirmation',
                        'created_at' => '2020-11-02 13:56:20',
                        'updated_at' => '2020-11-02 13:56:20',
                    ),
                182 =>
                    array(
                        'id' => 245,
                        'lang' => 'en',
                        'lang_key' => 'Are you sure to delete this?',
                        'lang_value' => 'Are you sure to delete this?',
                        'created_at' => '2020-11-02 13:56:21',
                        'updated_at' => '2020-11-02 13:56:21',
                    ),
                183 =>
                    array(
                        'id' => 246,
                        'lang' => 'en',
                        'lang_key' => 'Premium Packages for Sellers',
                        'lang_value' => 'Premium Packages for Sellers',
                        'created_at' => '2020-11-02 13:57:36',
                        'updated_at' => '2020-11-02 13:57:36',
                    ),
                184 =>
                    array(
                        'id' => 247,
                        'lang' => 'en',
                        'lang_key' => 'Product Upload',
                        'lang_value' => 'Product Upload',
                        'created_at' => '2020-11-02 13:57:36',
                        'updated_at' => '2020-11-02 13:57:36',
                    ),
                185 =>
                    array(
                        'id' => 248,
                        'lang' => 'en',
                        'lang_key' => 'Digital Product Upload',
                        'lang_value' => 'Digital Product Upload',
                        'created_at' => '2020-11-02 13:57:36',
                        'updated_at' => '2020-11-02 13:57:36',
                    ),
                186 =>
                    array(
                        'id' => 250,
                        'lang' => 'en',
                        'lang_key' => 'Purchase Package',
                        'lang_value' => 'Purchase Package',
                        'created_at' => '2020-11-02 13:57:36',
                        'updated_at' => '2020-11-02 13:57:36',
                    ),
                187 =>
                    array(
                        'id' => 251,
                        'lang' => 'en',
                        'lang_key' => 'Select Payment Type',
                        'lang_value' => 'Select Payment Type',
                        'created_at' => '2020-11-02 13:57:36',
                        'updated_at' => '2020-11-02 13:57:36',
                    ),
                188 =>
                    array(
                        'id' => 252,
                        'lang' => 'en',
                        'lang_key' => 'Payment Type',
                        'lang_value' => 'Payment Type',
                        'created_at' => '2020-11-02 13:57:36',
                        'updated_at' => '2020-11-02 13:57:36',
                    ),
                189 =>
                    array(
                        'id' => 253,
                        'lang' => 'en',
                        'lang_key' => 'Select One',
                        'lang_value' => 'Select One',
                        'created_at' => '2020-11-02 13:57:36',
                        'updated_at' => '2020-11-02 13:57:36',
                    ),
                190 =>
                    array(
                        'id' => 254,
                        'lang' => 'en',
                        'lang_key' => 'Online payment',
                        'lang_value' => 'Online payment',
                        'created_at' => '2020-11-02 13:57:37',
                        'updated_at' => '2020-11-02 13:57:37',
                    ),
                191 =>
                    array(
                        'id' => 255,
                        'lang' => 'en',
                        'lang_key' => 'Offline payment',
                        'lang_value' => 'Offline payment',
                        'created_at' => '2020-11-02 13:57:37',
                        'updated_at' => '2020-11-02 13:57:37',
                    ),
                192 =>
                    array(
                        'id' => 256,
                        'lang' => 'en',
                        'lang_key' => 'Purchase Your Package',
                        'lang_value' => 'Purchase Your Package',
                        'created_at' => '2020-11-02 13:57:37',
                        'updated_at' => '2020-11-02 13:57:37',
                    ),
                193 =>
                    array(
                        'id' => 258,
                        'lang' => 'en',
                        'lang_key' => 'Paypal',
                        'lang_value' => 'Paypal',
                        'created_at' => '2020-11-02 13:57:37',
                        'updated_at' => '2020-11-02 13:57:37',
                    ),
                194 =>
                    array(
                        'id' => 259,
                        'lang' => 'en',
                        'lang_key' => 'Stripe',
                        'lang_value' => 'Stripe',
                        'created_at' => '2020-11-02 13:57:37',
                        'updated_at' => '2020-11-02 13:57:37',
                    ),
                195 =>
                    array(
                        'id' => 260,
                        'lang' => 'en',
                        'lang_key' => 'sslcommerz',
                        'lang_value' => 'sslcommerz',
                        'created_at' => '2020-11-02 13:57:37',
                        'updated_at' => '2020-11-02 13:57:37',
                    ),
                196 =>
                    array(
                        'id' => 265,
                        'lang' => 'en',
                        'lang_key' => 'Confirm',
                        'lang_value' => 'Confirm',
                        'created_at' => '2020-11-02 13:57:37',
                        'updated_at' => '2020-11-02 13:57:37',
                    ),
                197 =>
                    array(
                        'id' => 266,
                        'lang' => 'en',
                        'lang_key' => 'Offline Package Payment',
                        'lang_value' => 'Offline Package Payment',
                        'created_at' => '2020-11-02 13:57:37',
                        'updated_at' => '2020-11-02 13:57:37',
                    ),
                198 =>
                    array(
                        'id' => 267,
                        'lang' => 'en',
                        'lang_key' => 'Transaction ID',
                        'lang_value' => 'Transaction ID',
                        'created_at' => '2020-11-02 14:30:12',
                        'updated_at' => '2020-11-02 14:30:12',
                    ),
                199 =>
                    array(
                        'id' => 268,
                        'lang' => 'en',
                        'lang_key' => 'Choose image',
                        'lang_value' => 'Choose image',
                        'created_at' => '2020-11-02 14:30:12',
                        'updated_at' => '2020-11-02 14:30:12',
                    ),
                200 =>
                    array(
                        'id' => 269,
                        'lang' => 'en',
                        'lang_key' => 'Code',
                        'lang_value' => 'Code',
                        'created_at' => '2020-11-02 14:42:00',
                        'updated_at' => '2020-11-02 14:42:00',
                    ),
                201 =>
                    array(
                        'id' => 270,
                        'lang' => 'en',
                        'lang_key' => 'Delivery Status',
                        'lang_value' => 'Delivery Status',
                        'created_at' => '2020-11-02 14:42:00',
                        'updated_at' => '2020-11-02 14:42:00',
                    ),
                202 =>
                    array(
                        'id' => 271,
                        'lang' => 'en',
                        'lang_key' => 'Payment Status',
                        'lang_value' => 'Payment Status',
                        'created_at' => '2020-11-02 14:42:00',
                        'updated_at' => '2020-11-02 14:42:00',
                    ),
                203 =>
                    array(
                        'id' => 272,
                        'lang' => 'en',
                        'lang_key' => 'Paid',
                        'lang_value' => 'Paid',
                        'created_at' => '2020-11-02 14:42:00',
                        'updated_at' => '2020-11-02 14:42:00',
                    ),
                204 =>
                    array(
                        'id' => 273,
                        'lang' => 'en',
                        'lang_key' => 'Order Details',
                        'lang_value' => 'Order Details',
                        'created_at' => '2020-11-02 14:42:00',
                        'updated_at' => '2020-11-02 14:42:00',
                    ),
                205 =>
                    array(
                        'id' => 274,
                        'lang' => 'en',
                        'lang_key' => 'Download Invoice',
                        'lang_value' => 'Download Invoice',
                        'created_at' => '2020-11-02 14:42:00',
                        'updated_at' => '2020-11-02 14:42:00',
                    ),
                206 =>
                    array(
                        'id' => 275,
                        'lang' => 'en',
                        'lang_key' => 'Unpaid',
                        'lang_value' => 'Unpaid',
                        'created_at' => '2020-11-02 14:42:00',
                        'updated_at' => '2020-11-02 14:42:00',
                    ),
                207 =>
                    array(
                        'id' => 277,
                        'lang' => 'en',
                        'lang_key' => 'Order placed',
                        'lang_value' => 'Order placed',
                        'created_at' => '2020-11-02 14:43:59',
                        'updated_at' => '2020-11-02 14:43:59',
                    ),
                208 =>
                    array(
                        'id' => 278,
                        'lang' => 'en',
                        'lang_key' => 'Confirmed',
                        'lang_value' => 'Confirmed',
                        'created_at' => '2020-11-02 14:43:59',
                        'updated_at' => '2020-11-02 14:43:59',
                    ),
                209 =>
                    array(
                        'id' => 279,
                        'lang' => 'en',
                        'lang_key' => 'On delivery',
                        'lang_value' => 'On delivery',
                        'created_at' => '2020-11-02 14:43:59',
                        'updated_at' => '2020-11-02 14:43:59',
                    ),
                210 =>
                    array(
                        'id' => 280,
                        'lang' => 'en',
                        'lang_key' => 'Delivered',
                        'lang_value' => 'Delivered',
                        'created_at' => '2020-11-02 14:43:59',
                        'updated_at' => '2020-11-02 14:43:59',
                    ),
                211 =>
                    array(
                        'id' => 281,
                        'lang' => 'en',
                        'lang_key' => 'Order Summary',
                        'lang_value' => 'Order Summary',
                        'created_at' => '2020-11-02 14:43:59',
                        'updated_at' => '2020-11-02 14:43:59',
                    ),
                212 =>
                    array(
                        'id' => 282,
                        'lang' => 'en',
                        'lang_key' => 'Order Code',
                        'lang_value' => 'Order Code',
                        'created_at' => '2020-11-02 14:43:59',
                        'updated_at' => '2020-11-02 14:43:59',
                    ),
                213 =>
                    array(
                        'id' => 283,
                        'lang' => 'en',
                        'lang_key' => 'Customer',
                        'lang_value' => 'Customer',
                        'created_at' => '2020-11-02 14:43:59',
                        'updated_at' => '2020-11-02 14:43:59',
                    ),
                214 =>
                    array(
                        'id' => 287,
                        'lang' => 'en',
                        'lang_key' => 'Total order amount',
                        'lang_value' => 'Total order amount',
                        'created_at' => '2020-11-02 14:43:59',
                        'updated_at' => '2020-11-02 14:43:59',
                    ),
                215 =>
                    array(
                        'id' => 288,
                        'lang' => 'en',
                        'lang_key' => 'Shipping metdod',
                        'lang_value' => 'Shipping metdod',
                        'created_at' => '2020-11-02 14:43:59',
                        'updated_at' => '2020-11-02 14:43:59',
                    ),
                216 =>
                    array(
                        'id' => 289,
                        'lang' => 'en',
                        'lang_key' => 'Flat shipping rate',
                        'lang_value' => 'Flat shipping rate',
                        'created_at' => '2020-11-02 14:44:00',
                        'updated_at' => '2020-11-02 14:44:00',
                    ),
                217 =>
                    array(
                        'id' => 290,
                        'lang' => 'en',
                        'lang_key' => 'Payment metdod',
                        'lang_value' => 'Payment metdod',
                        'created_at' => '2020-11-02 14:44:00',
                        'updated_at' => '2020-11-02 14:44:00',
                    ),
                218 =>
                    array(
                        'id' => 291,
                        'lang' => 'en',
                        'lang_key' => 'Variation',
                        'lang_value' => 'Variation',
                        'created_at' => '2020-11-02 14:44:00',
                        'updated_at' => '2020-11-02 14:44:00',
                    ),
                219 =>
                    array(
                        'id' => 292,
                        'lang' => 'en',
                        'lang_key' => 'Delivery Type',
                        'lang_value' => 'Delivery Type',
                        'created_at' => '2020-11-02 14:44:00',
                        'updated_at' => '2020-11-02 14:44:00',
                    ),
                220 =>
                    array(
                        'id' => 293,
                        'lang' => 'en',
                        'lang_key' => 'Home Delivery',
                        'lang_value' => 'Home Delivery',
                        'created_at' => '2020-11-02 14:44:00',
                        'updated_at' => '2020-11-02 14:44:00',
                    ),
                221 =>
                    array(
                        'id' => 294,
                        'lang' => 'en',
                        'lang_key' => 'Order Ammount',
                        'lang_value' => 'Order Ammount',
                        'created_at' => '2020-11-02 14:44:00',
                        'updated_at' => '2020-11-02 14:44:00',
                    ),
                222 =>
                    array(
                        'id' => 295,
                        'lang' => 'en',
                        'lang_key' => 'Subtotal',
                        'lang_value' => 'Subtotal',
                        'created_at' => '2020-11-02 14:44:00',
                        'updated_at' => '2020-11-02 14:44:00',
                    ),
                223 =>
                    array(
                        'id' => 296,
                        'lang' => 'en',
                        'lang_key' => 'Shipping',
                        'lang_value' => 'Shipping',
                        'created_at' => '2020-11-02 14:44:00',
                        'updated_at' => '2020-11-02 14:44:00',
                    ),
                224 =>
                    array(
                        'id' => 298,
                        'lang' => 'en',
                        'lang_key' => 'Coupon Discount',
                        'lang_value' => 'Coupon Discount',
                        'created_at' => '2020-11-02 14:44:00',
                        'updated_at' => '2020-11-02 14:44:00',
                    ),
                225 =>
                    array(
                        'id' => 300,
                        'lang' => 'en',
                        'lang_key' => 'N/A',
                        'lang_value' => 'N/A',
                        'created_at' => '2020-11-02 14:44:20',
                        'updated_at' => '2020-11-02 14:44:20',
                    ),
                226 =>
                    array(
                        'id' => 301,
                        'lang' => 'en',
                        'lang_key' => 'In stock',
                        'lang_value' => 'In stock',
                        'created_at' => '2020-11-02 14:54:52',
                        'updated_at' => '2020-11-02 14:54:52',
                    ),
                227 =>
                    array(
                        'id' => 302,
                        'lang' => 'en',
                        'lang_key' => 'Buy Now',
                        'lang_value' => 'Buy Now',
                        'created_at' => '2020-11-02 14:54:52',
                        'updated_at' => '2020-11-02 14:54:52',
                    ),
                228 =>
                    array(
                        'id' => 303,
                        'lang' => 'en',
                        'lang_key' => 'Item added to your cart!',
                        'lang_value' => 'Item added to your cart!',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                229 =>
                    array(
                        'id' => 304,
                        'lang' => 'en',
                        'lang_key' => 'Proceed to Checkout',
                        'lang_value' => 'Proceed to Checkout',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                230 =>
                    array(
                        'id' => 305,
                        'lang' => 'en',
                        'lang_key' => 'Cart Items',
                        'lang_value' => 'Cart Items',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                231 =>
                    array(
                        'id' => 306,
                        'lang' => 'en',
                        'lang_key' => '1. My Cart',
                        'lang_value' => '1. My Cart',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                232 =>
                    array(
                        'id' => 307,
                        'lang' => 'en',
                        'lang_key' => 'View cart',
                        'lang_value' => 'View cart',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                233 =>
                    array(
                        'id' => 308,
                        'lang' => 'en',
                        'lang_key' => '2. Shipping info',
                        'lang_value' => '2. Shipping info',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                234 =>
                    array(
                        'id' => 309,
                        'lang' => 'en',
                        'lang_key' => 'Checkout',
                        'lang_value' => 'Checkout',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                235 =>
                    array(
                        'id' => 310,
                        'lang' => 'en',
                        'lang_key' => '3. Delivery info',
                        'lang_value' => '3. Delivery info',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                236 =>
                    array(
                        'id' => 311,
                        'lang' => 'en',
                        'lang_key' => '4. Payment',
                        'lang_value' => '4. Payment',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                237 =>
                    array(
                        'id' => 312,
                        'lang' => 'en',
                        'lang_key' => '5. Confirmation',
                        'lang_value' => '5. Confirmation',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                238 =>
                    array(
                        'id' => 313,
                        'lang' => 'en',
                        'lang_key' => 'Remove',
                        'lang_value' => 'Remove',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                239 =>
                    array(
                        'id' => 314,
                        'lang' => 'en',
                        'lang_key' => 'Return to shop',
                        'lang_value' => 'Return to shop',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                240 =>
                    array(
                        'id' => 315,
                        'lang' => 'en',
                        'lang_key' => 'Continue to Shipping',
                        'lang_value' => 'Continue to Shipping',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                241 =>
                    array(
                        'id' => 316,
                        'lang' => 'en',
                        'lang_key' => 'Or',
                        'lang_value' => 'Or',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                242 =>
                    array(
                        'id' => 317,
                        'lang' => 'en',
                        'lang_key' => 'Guest Checkout',
                        'lang_value' => 'Guest Checkout',
                        'created_at' => '2020-11-02 14:56:46',
                        'updated_at' => '2020-11-02 14:56:46',
                    ),
                243 =>
                    array(
                        'id' => 318,
                        'lang' => 'en',
                        'lang_key' => 'Continue to Delivery Info',
                        'lang_value' => 'Continue to Delivery Info',
                        'created_at' => '2020-11-02 14:57:44',
                        'updated_at' => '2020-11-02 14:57:44',
                    ),
                244 =>
                    array(
                        'id' => 319,
                        'lang' => 'en',
                        'lang_key' => 'Postal Code',
                        'lang_value' => 'Postal Code',
                        'created_at' => '2020-11-02 15:01:01',
                        'updated_at' => '2020-11-02 15:01:01',
                    ),
                245 =>
                    array(
                        'id' => 320,
                        'lang' => 'en',
                        'lang_key' => 'Choose Delivery Type',
                        'lang_value' => 'Choose Delivery Type',
                        'created_at' => '2020-11-02 15:01:04',
                        'updated_at' => '2020-11-02 15:01:04',
                    ),
                246 =>
                    array(
                        'id' => 321,
                        'lang' => 'en',
                        'lang_key' => 'Local Pickup',
                        'lang_value' => 'Local Pickup',
                        'created_at' => '2020-11-02 15:01:04',
                        'updated_at' => '2020-11-02 15:01:04',
                    ),
                247 =>
                    array(
                        'id' => 322,
                        'lang' => 'en',
                        'lang_key' => 'Select your nearest pickup point',
                        'lang_value' => 'Select your nearest pickup point',
                        'created_at' => '2020-11-02 15:01:04',
                        'updated_at' => '2020-11-02 15:01:04',
                    ),
                248 =>
                    array(
                        'id' => 323,
                        'lang' => 'en',
                        'lang_key' => 'Continue to Payment',
                        'lang_value' => 'Continue to Payment',
                        'created_at' => '2020-11-02 15:01:04',
                        'updated_at' => '2020-11-02 15:01:04',
                    ),
                249 =>
                    array(
                        'id' => 324,
                        'lang' => 'en',
                        'lang_key' => 'Select a payment option',
                        'lang_value' => 'Select a payment option',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                250 =>
                    array(
                        'id' => 325,
                        'lang' => 'en',
                        'lang_key' => 'Razorpay',
                        'lang_value' => 'Razorpay',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                251 =>
                    array(
                        'id' => 326,
                        'lang' => 'en',
                        'lang_key' => 'Paystack',
                        'lang_value' => 'Paystack',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                252 =>
                    array(
                        'id' => 327,
                        'lang' => 'en',
                        'lang_key' => 'VoguePay',
                        'lang_value' => 'VoguePay',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                253 =>
                    array(
                        'id' => 328,
                        'lang' => 'en',
                        'lang_key' => 'payhere',
                        'lang_value' => 'payhere',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                254 =>
                    array(
                        'id' => 329,
                        'lang' => 'en',
                        'lang_key' => 'ngenius',
                        'lang_value' => 'ngenius',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                255 =>
                    array(
                        'id' => 330,
                        'lang' => 'en',
                        'lang_key' => 'Paytm',
                        'lang_value' => 'Paytm',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                256 =>
                    array(
                        'id' => 331,
                        'lang' => 'en',
                        'lang_key' => 'Cash on Delivery',
                        'lang_value' => 'Cash on Delivery',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                257 =>
                    array(
                        'id' => 332,
                        'lang' => 'en',
                        'lang_key' => 'Your wallet balance :',
                        'lang_value' => 'Your wallet balance :',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                258 =>
                    array(
                        'id' => 333,
                        'lang' => 'en',
                        'lang_key' => 'Insufficient balance',
                        'lang_value' => 'Insufficient balance',
                        'created_at' => '2020-11-02 15:01:13',
                        'updated_at' => '2020-11-02 15:01:13',
                    ),
                259 =>
                    array(
                        'id' => 334,
                        'lang' => 'en',
                        'lang_key' => 'I agree to the',
                        'lang_value' => 'I agree to the',
                        'created_at' => '2020-11-02 15:01:14',
                        'updated_at' => '2020-11-02 15:01:14',
                    ),
                260 =>
                    array(
                        'id' => 338,
                        'lang' => 'en',
                        'lang_key' => 'Complete Order',
                        'lang_value' => 'Complete Order',
                        'created_at' => '2020-11-02 15:01:14',
                        'updated_at' => '2020-11-02 15:01:14',
                    ),
                261 =>
                    array(
                        'id' => 339,
                        'lang' => 'en',
                        'lang_key' => 'Summary',
                        'lang_value' => 'Summary',
                        'created_at' => '2020-11-02 15:01:14',
                        'updated_at' => '2020-11-02 15:01:14',
                    ),
                262 =>
                    array(
                        'id' => 340,
                        'lang' => 'en',
                        'lang_key' => 'Items',
                        'lang_value' => 'Items',
                        'created_at' => '2020-11-02 15:01:14',
                        'updated_at' => '2020-11-02 15:01:14',
                    ),
                263 =>
                    array(
                        'id' => 341,
                        'lang' => 'en',
                        'lang_key' => 'Total Club point',
                        'lang_value' => 'Total Club point',
                        'created_at' => '2020-11-02 15:01:14',
                        'updated_at' => '2020-11-02 15:01:14',
                    ),
                264 =>
                    array(
                        'id' => 342,
                        'lang' => 'en',
                        'lang_key' => 'Total Shipping',
                        'lang_value' => 'Total Shipping',
                        'created_at' => '2020-11-02 15:01:14',
                        'updated_at' => '2020-11-02 15:01:14',
                    ),
                265 =>
                    array(
                        'id' => 343,
                        'lang' => 'en',
                        'lang_key' => 'Have coupon code? Enter here',
                        'lang_value' => 'Have coupon code? Enter here',
                        'created_at' => '2020-11-02 15:01:14',
                        'updated_at' => '2020-11-02 15:01:14',
                    ),
                266 =>
                    array(
                        'id' => 344,
                        'lang' => 'en',
                        'lang_key' => 'Apply',
                        'lang_value' => 'Apply',
                        'created_at' => '2020-11-02 15:01:14',
                        'updated_at' => '2020-11-02 15:01:14',
                    ),
                267 =>
                    array(
                        'id' => 345,
                        'lang' => 'en',
                        'lang_key' => 'You need to agree with our policies',
                        'lang_value' => 'You need to agree with our policies',
                        'created_at' => '2020-11-02 15:01:14',
                        'updated_at' => '2020-11-02 15:01:14',
                    ),
                268 =>
                    array(
                        'id' => 346,
                        'lang' => 'en',
                        'lang_key' => 'Forgot password',
                        'lang_value' => 'Forgot password',
                        'created_at' => '2020-11-02 15:01:25',
                        'updated_at' => '2020-11-02 15:01:25',
                    ),
                269 =>
                    array(
                        'id' => 469,
                        'lang' => 'en',
                        'lang_key' => 'SEO Setting',
                        'lang_value' => 'SEO Setting',
                        'created_at' => '2020-11-02 15:01:33',
                        'updated_at' => '2020-11-02 15:01:33',
                    ),
                270 =>
                    array(
                        'id' => 474,
                        'lang' => 'en',
                        'lang_key' => 'System Update',
                        'lang_value' => 'System Update',
                        'created_at' => '2020-11-02 15:01:34',
                        'updated_at' => '2020-11-02 15:01:34',
                    ),
                271 =>
                    array(
                        'id' => 480,
                        'lang' => 'en',
                        'lang_key' => 'Add New Payment Method',
                        'lang_value' => 'Add New Payment Method',
                        'created_at' => '2020-11-02 15:01:38',
                        'updated_at' => '2020-11-02 15:01:38',
                    ),
                272 =>
                    array(
                        'id' => 481,
                        'lang' => 'en',
                        'lang_key' => 'Manual Payment Method',
                        'lang_value' => 'Manual Payment Method',
                        'created_at' => '2020-11-02 15:01:38',
                        'updated_at' => '2020-11-02 15:01:38',
                    ),
                273 =>
                    array(
                        'id' => 482,
                        'lang' => 'en',
                        'lang_key' => 'Heading',
                        'lang_value' => 'Heading',
                        'created_at' => '2020-11-02 15:01:38',
                        'updated_at' => '2020-11-02 15:01:38',
                    ),
                274 =>
                    array(
                        'id' => 483,
                        'lang' => 'en',
                        'lang_key' => 'Logo',
                        'lang_value' => 'Logo',
                        'created_at' => '2020-11-02 15:01:38',
                        'updated_at' => '2020-11-02 15:01:38',
                    ),
                275 =>
                    array(
                        'id' => 484,
                        'lang' => 'en',
                        'lang_key' => 'Manual Payment Information',
                        'lang_value' => 'Manual Payment Information',
                        'created_at' => '2020-11-02 15:01:42',
                        'updated_at' => '2020-11-02 15:01:42',
                    ),
                276 =>
                    array(
                        'id' => 485,
                        'lang' => 'en',
                        'lang_key' => 'Type',
                        'lang_value' => 'Type',
                        'created_at' => '2020-11-02 15:01:42',
                        'updated_at' => '2020-11-02 15:01:42',
                    ),
                277 =>
                    array(
                        'id' => 486,
                        'lang' => 'en',
                        'lang_key' => 'Custom Payment',
                        'lang_value' => 'Custom Payment',
                        'created_at' => '2020-11-02 15:01:42',
                        'updated_at' => '2020-11-02 15:01:42',
                    ),
                278 =>
                    array(
                        'id' => 487,
                        'lang' => 'en',
                        'lang_key' => 'Check Payment',
                        'lang_value' => 'Check Payment',
                        'created_at' => '2020-11-02 15:01:42',
                        'updated_at' => '2020-11-02 15:01:42',
                    ),
                279 =>
                    array(
                        'id' => 488,
                        'lang' => 'en',
                        'lang_key' => 'Checkout Thumbnail',
                        'lang_value' => 'Checkout Thumbnail',
                        'created_at' => '2020-11-02 15:01:42',
                        'updated_at' => '2020-11-02 15:01:42',
                    ),
                280 =>
                    array(
                        'id' => 489,
                        'lang' => 'en',
                        'lang_key' => 'Payment Instruction',
                        'lang_value' => 'Payment Instruction',
                        'created_at' => '2020-11-02 15:01:42',
                        'updated_at' => '2020-11-02 15:01:42',
                    ),
                281 =>
                    array(
                        'id' => 490,
                        'lang' => 'en',
                        'lang_key' => 'Bank Information',
                        'lang_value' => 'Bank Information',
                        'created_at' => '2020-11-02 15:01:42',
                        'updated_at' => '2020-11-02 15:01:42',
                    ),
                282 =>
                    array(
                        'id' => 491,
                        'lang' => 'en',
                        'lang_key' => 'Select File',
                        'lang_value' => 'Select File',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                283 =>
                    array(
                        'id' => 492,
                        'lang' => 'en',
                        'lang_key' => 'Upload New',
                        'lang_value' => 'Upload New',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                284 =>
                    array(
                        'id' => 493,
                        'lang' => 'en',
                        'lang_key' => 'Sort by newest',
                        'lang_value' => 'Sort by newest',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                285 =>
                    array(
                        'id' => 494,
                        'lang' => 'en',
                        'lang_key' => 'Sort by oldest',
                        'lang_value' => 'Sort by oldest',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                286 =>
                    array(
                        'id' => 495,
                        'lang' => 'en',
                        'lang_key' => 'Sort by smallest',
                        'lang_value' => 'Sort by smallest',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                287 =>
                    array(
                        'id' => 496,
                        'lang' => 'en',
                        'lang_key' => 'Sort by largest',
                        'lang_value' => 'Sort by largest',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                288 =>
                    array(
                        'id' => 497,
                        'lang' => 'en',
                        'lang_key' => 'Selected Only',
                        'lang_value' => 'Selected Only',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                289 =>
                    array(
                        'id' => 498,
                        'lang' => 'en',
                        'lang_key' => 'No files found',
                        'lang_value' => 'No files found',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                290 =>
                    array(
                        'id' => 499,
                        'lang' => 'en',
                        'lang_key' => '0 File selected',
                        'lang_value' => '0 File selected',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                291 =>
                    array(
                        'id' => 500,
                        'lang' => 'en',
                        'lang_key' => 'Clear',
                        'lang_value' => 'Clear',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                292 =>
                    array(
                        'id' => 501,
                        'lang' => 'en',
                        'lang_key' => 'Prev',
                        'lang_value' => 'Prev',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                293 =>
                    array(
                        'id' => 502,
                        'lang' => 'en',
                        'lang_key' => 'Next',
                        'lang_value' => 'Next',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                294 =>
                    array(
                        'id' => 503,
                        'lang' => 'en',
                        'lang_key' => 'Add Files',
                        'lang_value' => 'Add Files',
                        'created_at' => '2020-11-02 15:01:53',
                        'updated_at' => '2020-11-02 15:01:53',
                    ),
                295 =>
                    array(
                        'id' => 504,
                        'lang' => 'en',
                        'lang_key' => 'Method has been inserted successfully',
                        'lang_value' => 'Method has been inserted successfully',
                        'created_at' => '2020-11-02 15:02:03',
                        'updated_at' => '2020-11-02 15:02:03',
                    ),
                296 =>
                    array(
                        'id' => 506,
                        'lang' => 'en',
                        'lang_key' => 'Order Date',
                        'lang_value' => 'Order Date',
                        'created_at' => '2020-11-02 15:02:42',
                        'updated_at' => '2020-11-02 15:02:42',
                    ),
                297 =>
                    array(
                        'id' => 507,
                        'lang' => 'en',
                        'lang_key' => 'Bill to',
                        'lang_value' => 'Bill to',
                        'created_at' => '2020-11-02 15:02:42',
                        'updated_at' => '2020-11-02 15:02:42',
                    ),
                298 =>
                    array(
                        'id' => 510,
                        'lang' => 'en',
                        'lang_key' => 'Sub Total',
                        'lang_value' => 'Sub Total',
                        'created_at' => '2020-11-02 15:02:42',
                        'updated_at' => '2020-11-02 15:02:42',
                    ),
                299 =>
                    array(
                        'id' => 512,
                        'lang' => 'en',
                        'lang_key' => 'Total Tax',
                        'lang_value' => 'Total Tax',
                        'created_at' => '2020-11-02 15:02:42',
                        'updated_at' => '2020-11-02 15:02:42',
                    ),
                300 =>
                    array(
                        'id' => 513,
                        'lang' => 'en',
                        'lang_key' => 'Grand Total',
                        'lang_value' => 'Grand Total',
                        'created_at' => '2020-11-02 15:02:42',
                        'updated_at' => '2020-11-02 15:02:42',
                    ),
                301 =>
                    array(
                        'id' => 514,
                        'lang' => 'en',
                        'lang_key' => 'Your order has been placed successfully. Please submit payment information from purchase history',
                        'lang_value' => 'Your order has been placed successfully. Please submit payment information from purchase history',
                        'created_at' => '2020-11-02 15:02:47',
                        'updated_at' => '2020-11-02 15:02:47',
                    ),
                302 =>
                    array(
                        'id' => 515,
                        'lang' => 'en',
                        'lang_key' => 'Thank You for Your Order!',
                        'lang_value' => 'Thank You for Your Order!',
                        'created_at' => '2020-11-02 15:02:48',
                        'updated_at' => '2020-11-02 15:02:48',
                    ),
                303 =>
                    array(
                        'id' => 516,
                        'lang' => 'en',
                        'lang_key' => 'Order Code:',
                        'lang_value' => 'Order Code:',
                        'created_at' => '2020-11-02 15:02:48',
                        'updated_at' => '2020-11-02 15:02:48',
                    ),
                304 =>
                    array(
                        'id' => 517,
                        'lang' => 'en',
                        'lang_key' => 'A copy or your order summary has been sent to',
                        'lang_value' => 'A copy or your order summary has been sent to',
                        'created_at' => '2020-11-02 15:02:48',
                        'updated_at' => '2020-11-02 15:02:48',
                    ),
                305 =>
                    array(
                        'id' => 518,
                        'lang' => 'en',
                        'lang_key' => 'Make Payment',
                        'lang_value' => 'Make Payment',
                        'created_at' => '2020-11-02 15:03:26',
                        'updated_at' => '2020-11-02 15:03:26',
                    ),
                306 =>
                    array(
                        'id' => 519,
                        'lang' => 'en',
                        'lang_key' => 'Payment screenshot',
                        'lang_value' => 'Payment screenshot',
                        'created_at' => '2020-11-02 15:03:29',
                        'updated_at' => '2020-11-02 15:03:29',
                    ),
                307 =>
                    array(
                        'id' => 520,
                        'lang' => 'en',
                        'lang_key' => 'Paypal Credential',
                        'lang_value' => 'Paypal Credential',
                        'created_at' => '2020-11-02 15:12:20',
                        'updated_at' => '2020-11-02 15:12:20',
                    ),
                308 =>
                    array(
                        'id' => 522,
                        'lang' => 'en',
                        'lang_key' => 'Paypal Client ID',
                        'lang_value' => 'Paypal Client ID',
                        'created_at' => '2020-11-02 15:12:20',
                        'updated_at' => '2020-11-02 15:12:20',
                    ),
                309 =>
                    array(
                        'id' => 523,
                        'lang' => 'en',
                        'lang_key' => 'Paypal Client Secret',
                        'lang_value' => 'Paypal Client Secret',
                        'created_at' => '2020-11-02 15:12:20',
                        'updated_at' => '2020-11-02 15:12:20',
                    ),
                310 =>
                    array(
                        'id' => 524,
                        'lang' => 'en',
                        'lang_key' => 'Paypal Sandbox Mode',
                        'lang_value' => 'Paypal Sandbox Mode',
                        'created_at' => '2020-11-02 15:12:20',
                        'updated_at' => '2020-11-02 15:12:20',
                    ),
                311 =>
                    array(
                        'id' => 525,
                        'lang' => 'en',
                        'lang_key' => 'Sslcommerz Credential',
                        'lang_value' => 'Sslcommerz Credential',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                312 =>
                    array(
                        'id' => 526,
                        'lang' => 'en',
                        'lang_key' => 'Sslcz Store Id',
                        'lang_value' => 'Sslcz Store Id',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                313 =>
                    array(
                        'id' => 527,
                        'lang' => 'en',
                        'lang_key' => 'Sslcz store password',
                        'lang_value' => 'Sslcz store password',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                314 =>
                    array(
                        'id' => 528,
                        'lang' => 'en',
                        'lang_key' => 'Sslcommerz Sandbox Mode',
                        'lang_value' => 'Sslcommerz Sandbox Mode',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                315 =>
                    array(
                        'id' => 529,
                        'lang' => 'en',
                        'lang_key' => 'Stripe Credential',
                        'lang_value' => 'Stripe Credential',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                316 =>
                    array(
                        'id' => 531,
                        'lang' => 'en',
                        'lang_key' => 'STRIPE KEY',
                        'lang_value' => 'STRIPE KEY',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                317 =>
                    array(
                        'id' => 533,
                        'lang' => 'en',
                        'lang_key' => 'STRIPE SECRET',
                        'lang_value' => 'STRIPE SECRET',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                318 =>
                    array(
                        'id' => 534,
                        'lang' => 'en',
                        'lang_key' => 'RazorPay Credential',
                        'lang_value' => 'RazorPay Credential',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                319 =>
                    array(
                        'id' => 535,
                        'lang' => 'en',
                        'lang_key' => 'RAZOR KEY',
                        'lang_value' => 'RAZOR KEY',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                320 =>
                    array(
                        'id' => 536,
                        'lang' => 'en',
                        'lang_key' => 'RAZOR SECRET',
                        'lang_value' => 'RAZOR SECRET',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                321 =>
                    array(
                        'id' => 537,
                        'lang' => 'en',
                        'lang_key' => 'Instamojo Credential',
                        'lang_value' => 'Instamojo Credential',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                322 =>
                    array(
                        'id' => 538,
                        'lang' => 'en',
                        'lang_key' => 'API KEY',
                        'lang_value' => 'API KEY',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                323 =>
                    array(
                        'id' => 539,
                        'lang' => 'en',
                        'lang_key' => 'IM API KEY',
                        'lang_value' => 'IM API KEY',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                324 =>
                    array(
                        'id' => 540,
                        'lang' => 'en',
                        'lang_key' => 'AUTH TOKEN',
                        'lang_value' => 'AUTH TOKEN',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                325 =>
                    array(
                        'id' => 541,
                        'lang' => 'en',
                        'lang_key' => 'IM AUTH TOKEN',
                        'lang_value' => 'IM AUTH TOKEN',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                326 =>
                    array(
                        'id' => 542,
                        'lang' => 'en',
                        'lang_key' => 'Instamojo Sandbox Mode',
                        'lang_value' => 'Instamojo Sandbox Mode',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                327 =>
                    array(
                        'id' => 543,
                        'lang' => 'en',
                        'lang_key' => 'PayStack Credential',
                        'lang_value' => 'PayStack Credential',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                328 =>
                    array(
                        'id' => 544,
                        'lang' => 'en',
                        'lang_key' => 'PUBLIC KEY',
                        'lang_value' => 'PUBLIC KEY',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                329 =>
                    array(
                        'id' => 545,
                        'lang' => 'en',
                        'lang_key' => 'SECRET KEY',
                        'lang_value' => 'SECRET KEY',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                330 =>
                    array(
                        'id' => 546,
                        'lang' => 'en',
                        'lang_key' => 'MERCHANT EMAIL',
                        'lang_value' => 'MERCHANT EMAIL',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                331 =>
                    array(
                        'id' => 547,
                        'lang' => 'en',
                        'lang_key' => 'VoguePay Credential',
                        'lang_value' => 'VoguePay Credential',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                332 =>
                    array(
                        'id' => 548,
                        'lang' => 'en',
                        'lang_key' => 'MERCHANT ID',
                        'lang_value' => 'MERCHANT ID',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                333 =>
                    array(
                        'id' => 549,
                        'lang' => 'en',
                        'lang_key' => 'Sandbox Mode',
                        'lang_value' => 'Sandbox Mode',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                334 =>
                    array(
                        'id' => 550,
                        'lang' => 'en',
                        'lang_key' => 'Payhere Credential',
                        'lang_value' => 'Payhere Credential',
                        'created_at' => '2020-11-02 15:12:21',
                        'updated_at' => '2020-11-02 15:12:21',
                    ),
                335 =>
                    array(
                        'id' => 551,
                        'lang' => 'en',
                        'lang_key' => 'PAYHERE MERCHANT ID',
                        'lang_value' => 'PAYHERE MERCHANT ID',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                336 =>
                    array(
                        'id' => 552,
                        'lang' => 'en',
                        'lang_key' => 'PAYHERE SECRET',
                        'lang_value' => 'PAYHERE SECRET',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                337 =>
                    array(
                        'id' => 553,
                        'lang' => 'en',
                        'lang_key' => 'PAYHERE CURRENCY',
                        'lang_value' => 'PAYHERE CURRENCY',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                338 =>
                    array(
                        'id' => 554,
                        'lang' => 'en',
                        'lang_key' => 'Payhere Sandbox Mode',
                        'lang_value' => 'Payhere Sandbox Mode',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                339 =>
                    array(
                        'id' => 555,
                        'lang' => 'en',
                        'lang_key' => 'Ngenius Credential',
                        'lang_value' => 'Ngenius Credential',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                340 =>
                    array(
                        'id' => 556,
                        'lang' => 'en',
                        'lang_key' => 'NGENIUS OUTLET ID',
                        'lang_value' => 'NGENIUS OUTLET ID',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                341 =>
                    array(
                        'id' => 557,
                        'lang' => 'en',
                        'lang_key' => 'NGENIUS API KEY',
                        'lang_value' => 'NGENIUS API KEY',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                342 =>
                    array(
                        'id' => 558,
                        'lang' => 'en',
                        'lang_key' => 'NGENIUS CURRENCY',
                        'lang_value' => 'NGENIUS CURRENCY',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                343 =>
                    array(
                        'id' => 559,
                        'lang' => 'en',
                        'lang_key' => 'Mpesa Credential',
                        'lang_value' => 'Mpesa Credential',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                344 =>
                    array(
                        'id' => 560,
                        'lang' => 'en',
                        'lang_key' => 'MPESA CONSUMER KEY',
                        'lang_value' => 'MPESA CONSUMER KEY',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                345 =>
                    array(
                        'id' => 561,
                        'lang' => 'en',
                        'lang_key' => 'MPESA_CONSUMER_KEY',
                        'lang_value' => 'MPESA_CONSUMER_KEY',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                346 =>
                    array(
                        'id' => 562,
                        'lang' => 'en',
                        'lang_key' => 'MPESA CONSUMER SECRET',
                        'lang_value' => 'MPESA CONSUMER SECRET',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                347 =>
                    array(
                        'id' => 563,
                        'lang' => 'en',
                        'lang_key' => 'MPESA_CONSUMER_SECRET',
                        'lang_value' => 'MPESA_CONSUMER_SECRET',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                348 =>
                    array(
                        'id' => 564,
                        'lang' => 'en',
                        'lang_key' => 'MPESA SHORT CODE',
                        'lang_value' => 'MPESA SHORT CODE',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                349 =>
                    array(
                        'id' => 565,
                        'lang' => 'en',
                        'lang_key' => 'MPESA_SHORT_CODE',
                        'lang_value' => 'MPESA_SHORT_CODE',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                350 =>
                    array(
                        'id' => 566,
                        'lang' => 'en',
                        'lang_key' => 'MPESA SANDBOX ACTIVATION',
                        'lang_value' => 'MPESA SANDBOX ACTIVATION',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                351 =>
                    array(
                        'id' => 567,
                        'lang' => 'en',
                        'lang_key' => 'Flutterwave Credential',
                        'lang_value' => 'Flutterwave Credential',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                352 =>
                    array(
                        'id' => 568,
                        'lang' => 'en',
                        'lang_key' => 'RAVE_PUBLIC_KEY',
                        'lang_value' => 'RAVE_PUBLIC_KEY',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                353 =>
                    array(
                        'id' => 569,
                        'lang' => 'en',
                        'lang_key' => 'RAVE_SECRET_KEY',
                        'lang_value' => 'RAVE_SECRET_KEY',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                354 =>
                    array(
                        'id' => 570,
                        'lang' => 'en',
                        'lang_key' => 'RAVE_TITLE',
                        'lang_value' => 'RAVE_TITLE',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                355 =>
                    array(
                        'id' => 571,
                        'lang' => 'en',
                        'lang_key' => 'STAGIN ACTIVATION',
                        'lang_value' => 'STAGIN ACTIVATION',
                        'created_at' => '2020-11-02 15:12:22',
                        'updated_at' => '2020-11-02 15:12:22',
                    ),
                356 =>
                    array(
                        'id' => 573,
                        'lang' => 'en',
                        'lang_key' => 'All Product',
                        'lang_value' => 'All Product',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                357 =>
                    array(
                        'id' => 574,
                        'lang' => 'en',
                        'lang_key' => 'Sort By',
                        'lang_value' => 'Sort By',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                358 =>
                    array(
                        'id' => 575,
                        'lang' => 'en',
                        'lang_key' => 'Rating (High > Low)',
                        'lang_value' => 'Rating (High > Low)',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                359 =>
                    array(
                        'id' => 576,
                        'lang' => 'en',
                        'lang_key' => 'Rating (Low > High)',
                        'lang_value' => 'Rating (Low > High)',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                360 =>
                    array(
                        'id' => 577,
                        'lang' => 'en',
                        'lang_key' => 'Num of Sale (High > Low)',
                        'lang_value' => 'Num of Sale (High > Low)',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                361 =>
                    array(
                        'id' => 578,
                        'lang' => 'en',
                        'lang_key' => 'Num of Sale (Low > High)',
                        'lang_value' => 'Num of Sale (Low > High)',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                362 =>
                    array(
                        'id' => 579,
                        'lang' => 'en',
                        'lang_key' => 'Base Price (High > Low)',
                        'lang_value' => 'Base Price (High > Low)',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                363 =>
                    array(
                        'id' => 580,
                        'lang' => 'en',
                        'lang_key' => 'Base Price (Low > High)',
                        'lang_value' => 'Base Price (Low > High)',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                364 =>
                    array(
                        'id' => 581,
                        'lang' => 'en',
                        'lang_key' => 'Type & Enter',
                        'lang_value' => 'Type & Enter',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                365 =>
                    array(
                        'id' => 582,
                        'lang' => 'en',
                        'lang_key' => 'Added By',
                        'lang_value' => 'Added By',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                366 =>
                    array(
                        'id' => 583,
                        'lang' => 'en',
                        'lang_key' => 'Num of Sale',
                        'lang_value' => 'Num of Sale',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                367 =>
                    array(
                        'id' => 584,
                        'lang' => 'en',
                        'lang_key' => 'Total Stock',
                        'lang_value' => 'Total Stock',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                368 =>
                    array(
                        'id' => 585,
                        'lang' => 'en',
                        'lang_key' => 'Todays Deal',
                        'lang_value' => 'Todays Deal',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                369 =>
                    array(
                        'id' => 586,
                        'lang' => 'en',
                        'lang_key' => 'Rating',
                        'lang_value' => 'Rating',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                370 =>
                    array(
                        'id' => 587,
                        'lang' => 'en',
                        'lang_key' => 'times',
                        'lang_value' => 'times',
                        'created_at' => '2020-11-02 15:15:01',
                        'updated_at' => '2020-11-02 15:15:01',
                    ),
                371 =>
                    array(
                        'id' => 588,
                        'lang' => 'en',
                        'lang_key' => 'Add Nerw Product',
                        'lang_value' => 'Add Nerw Product',
                        'created_at' => '2020-11-02 15:15:02',
                        'updated_at' => '2020-11-02 15:15:02',
                    ),
                372 =>
                    array(
                        'id' => 589,
                        'lang' => 'en',
                        'lang_key' => 'Product Information',
                        'lang_value' => 'Product Information',
                        'created_at' => '2020-11-02 15:15:02',
                        'updated_at' => '2020-11-02 15:15:02',
                    ),
                373 =>
                    array(
                        'id' => 590,
                        'lang' => 'en',
                        'lang_key' => 'Unit',
                        'lang_value' => 'Unit',
                        'created_at' => '2020-11-02 15:15:02',
                        'updated_at' => '2020-11-02 15:15:02',
                    ),
                374 =>
                    array(
                        'id' => 591,
                        'lang' => 'en',
                        'lang_key' => 'Unit (e.g. KG, Pc etc)',
                        'lang_value' => 'Unit (e.g. KG, Pc etc)',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                375 =>
                    array(
                        'id' => 592,
                        'lang' => 'en',
                        'lang_key' => 'Minimum Qty',
                        'lang_value' => 'Minimum Qty',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                376 =>
                    array(
                        'id' => 593,
                        'lang' => 'en',
                        'lang_key' => 'Tags',
                        'lang_value' => 'Tags',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                377 =>
                    array(
                        'id' => 594,
                        'lang' => 'en',
                        'lang_key' => 'Type and hit enter to add a tag',
                        'lang_value' => 'Type and hit enter to add a tag',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                378 =>
                    array(
                        'id' => 595,
                        'lang' => 'en',
                        'lang_key' => 'Barcode',
                        'lang_value' => 'Barcode',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                379 =>
                    array(
                        'id' => 596,
                        'lang' => 'en',
                        'lang_key' => 'Refundable',
                        'lang_value' => 'Refundable',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                380 =>
                    array(
                        'id' => 597,
                        'lang' => 'en',
                        'lang_key' => 'Product Images',
                        'lang_value' => 'Product Images',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                381 =>
                    array(
                        'id' => 598,
                        'lang' => 'en',
                        'lang_key' => 'Gallery Images',
                        'lang_value' => 'Gallery Images',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                382 =>
                    array(
                        'id' => 599,
                        'lang' => 'en',
                        'lang_key' => 'Todays Deal updated successfully',
                        'lang_value' => 'Todays Deal updated successfully',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                383 =>
                    array(
                        'id' => 600,
                        'lang' => 'en',
                        'lang_key' => 'Published products updated successfully',
                        'lang_value' => 'Published products updated successfully',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                384 =>
                    array(
                        'id' => 601,
                        'lang' => 'en',
                        'lang_key' => 'Thumbnail Image',
                        'lang_value' => 'Thumbnail Image',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                385 =>
                    array(
                        'id' => 602,
                        'lang' => 'en',
                        'lang_key' => 'Featured products updated successfully',
                        'lang_value' => 'Featured products updated successfully',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                386 =>
                    array(
                        'id' => 603,
                        'lang' => 'en',
                        'lang_key' => 'Product Videos',
                        'lang_value' => 'Product Videos',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                387 =>
                    array(
                        'id' => 604,
                        'lang' => 'en',
                        'lang_key' => 'Video Provider',
                        'lang_value' => 'Video Provider',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                388 =>
                    array(
                        'id' => 605,
                        'lang' => 'en',
                        'lang_key' => 'Youtube',
                        'lang_value' => 'Youtube',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                389 =>
                    array(
                        'id' => 606,
                        'lang' => 'en',
                        'lang_key' => 'Dailymotion',
                        'lang_value' => 'Dailymotion',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                390 =>
                    array(
                        'id' => 607,
                        'lang' => 'en',
                        'lang_key' => 'Vimeo',
                        'lang_value' => 'Vimeo',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                391 =>
                    array(
                        'id' => 608,
                        'lang' => 'en',
                        'lang_key' => 'Video Link',
                        'lang_value' => 'Video Link',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                392 =>
                    array(
                        'id' => 609,
                        'lang' => 'en',
                        'lang_key' => 'Product Variation',
                        'lang_value' => 'Product Variation',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                393 =>
                    array(
                        'id' => 610,
                        'lang' => 'en',
                        'lang_key' => 'Colors',
                        'lang_value' => 'Colors',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                394 =>
                    array(
                        'id' => 611,
                        'lang' => 'en',
                        'lang_key' => 'Attributes',
                        'lang_value' => 'Attributes',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                395 =>
                    array(
                        'id' => 612,
                        'lang' => 'en',
                        'lang_key' => 'Choose Attributes',
                        'lang_value' => 'Choose Attributes',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                396 =>
                    array(
                        'id' => 613,
                        'lang' => 'en',
                        'lang_key' => 'Choose the attributes of this product and then input values of each attribute',
                        'lang_value' => 'Choose the attributes of this product and then input values of each attribute',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                397 =>
                    array(
                        'id' => 614,
                        'lang' => 'en',
                        'lang_key' => 'Product price + stock',
                        'lang_value' => 'Product price + stock',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                398 =>
                    array(
                        'id' => 616,
                        'lang' => 'en',
                        'lang_key' => 'Unit price',
                        'lang_value' => 'Unit price',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                399 =>
                    array(
                        'id' => 617,
                        'lang' => 'en',
                        'lang_key' => 'Purchase price',
                        'lang_value' => 'Purchase price',
                        'created_at' => '2020-11-02 15:15:03',
                        'updated_at' => '2020-11-02 15:15:03',
                    ),
                400 =>
                    array(
                        'id' => 618,
                        'lang' => 'en',
                        'lang_key' => 'Flat',
                        'lang_value' => 'Flat',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                401 =>
                    array(
                        'id' => 619,
                        'lang' => 'en',
                        'lang_key' => 'Percent',
                        'lang_value' => 'Percent',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                402 =>
                    array(
                        'id' => 620,
                        'lang' => 'en',
                        'lang_key' => 'Discount',
                        'lang_value' => 'Discount',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                403 =>
                    array(
                        'id' => 621,
                        'lang' => 'en',
                        'lang_key' => 'Product Description',
                        'lang_value' => 'Product Description',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                404 =>
                    array(
                        'id' => 622,
                        'lang' => 'en',
                        'lang_key' => 'Product Shipping Cost',
                        'lang_value' => 'Product Shipping Cost',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                405 =>
                    array(
                        'id' => 623,
                        'lang' => 'en',
                        'lang_key' => 'Free Shipping',
                        'lang_value' => 'Free Shipping',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                406 =>
                    array(
                        'id' => 624,
                        'lang' => 'en',
                        'lang_key' => 'Flat Rate',
                        'lang_value' => 'Flat Rate',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                407 =>
                    array(
                        'id' => 625,
                        'lang' => 'en',
                        'lang_key' => 'Shipping cost',
                        'lang_value' => 'Shipping cost',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                408 =>
                    array(
                        'id' => 626,
                        'lang' => 'en',
                        'lang_key' => 'PDF Specification',
                        'lang_value' => 'PDF Specification',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                409 =>
                    array(
                        'id' => 627,
                        'lang' => 'en',
                        'lang_key' => 'SEO Meta Tags',
                        'lang_value' => 'SEO Meta Tags',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                410 =>
                    array(
                        'id' => 628,
                        'lang' => 'en',
                        'lang_key' => 'Meta Title',
                        'lang_value' => 'Meta Title',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                411 =>
                    array(
                        'id' => 629,
                        'lang' => 'en',
                        'lang_key' => 'Meta Image',
                        'lang_value' => 'Meta Image',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                412 =>
                    array(
                        'id' => 630,
                        'lang' => 'en',
                        'lang_key' => 'Choice Title',
                        'lang_value' => 'Choice Title',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                413 =>
                    array(
                        'id' => 631,
                        'lang' => 'en',
                        'lang_key' => 'Enter choice values',
                        'lang_value' => 'Enter choice values',
                        'created_at' => '2020-11-02 15:15:04',
                        'updated_at' => '2020-11-02 15:15:04',
                    ),
                414 =>
                    array(
                        'id' => 632,
                        'lang' => 'en',
                        'lang_key' => 'All categories',
                        'lang_value' => 'All categories',
                        'created_at' => '2020-11-03 09:12:19',
                        'updated_at' => '2020-11-03 09:12:19',
                    ),
                415 =>
                    array(
                        'id' => 633,
                        'lang' => 'en',
                        'lang_key' => 'Add New category',
                        'lang_value' => 'Add New category',
                        'created_at' => '2020-11-03 09:12:19',
                        'updated_at' => '2020-11-03 09:12:19',
                    ),
                416 =>
                    array(
                        'id' => 634,
                        'lang' => 'en',
                        'lang_key' => 'Type name & Enter',
                        'lang_value' => 'Type name & Enter',
                        'created_at' => '2020-11-03 09:12:19',
                        'updated_at' => '2020-11-03 09:12:19',
                    ),
                417 =>
                    array(
                        'id' => 635,
                        'lang' => 'en',
                        'lang_key' => 'Banner',
                        'lang_value' => 'Banner',
                        'created_at' => '2020-11-03 09:12:19',
                        'updated_at' => '2020-11-03 09:12:19',
                    ),
                418 =>
                    array(
                        'id' => 637,
                        'lang' => 'en',
                        'lang_key' => 'Commission',
                        'lang_value' => 'Commission',
                        'created_at' => '2020-11-03 09:12:19',
                        'updated_at' => '2020-11-03 09:12:19',
                    ),
                419 =>
                    array(
                        'id' => 638,
                        'lang' => 'en',
                        'lang_key' => 'icon',
                        'lang_value' => 'icon',
                        'created_at' => '2020-11-03 09:12:19',
                        'updated_at' => '2020-11-03 09:12:19',
                    ),
                420 =>
                    array(
                        'id' => 639,
                        'lang' => 'en',
                        'lang_key' => 'Featured categories updated successfully',
                        'lang_value' => 'Featured categories updated successfully',
                        'created_at' => '2020-11-03 09:12:20',
                        'updated_at' => '2020-11-03 09:12:20',
                    ),
                421 =>
                    array(
                        'id' => 640,
                        'lang' => 'en',
                        'lang_key' => 'Hot',
                        'lang_value' => 'Hot',
                        'created_at' => '2020-11-03 09:13:12',
                        'updated_at' => '2020-11-03 09:13:12',
                    ),
                422 =>
                    array(
                        'id' => 641,
                        'lang' => 'en',
                        'lang_key' => 'Filter by Payment Status',
                        'lang_value' => 'Filter by Payment Status',
                        'created_at' => '2020-11-03 09:15:15',
                        'updated_at' => '2020-11-03 09:15:15',
                    ),
                423 =>
                    array(
                        'id' => 642,
                        'lang' => 'en',
                        'lang_key' => 'Un-Paid',
                        'lang_value' => 'Un-Paid',
                        'created_at' => '2020-11-03 09:15:15',
                        'updated_at' => '2020-11-03 09:15:15',
                    ),
                424 =>
                    array(
                        'id' => 643,
                        'lang' => 'en',
                        'lang_key' => 'Filter by Deliver Status',
                        'lang_value' => 'Filter by Deliver Status',
                        'created_at' => '2020-11-03 09:15:15',
                        'updated_at' => '2020-11-03 09:15:15',
                    ),
                425 =>
                    array(
                        'id' => 644,
                        'lang' => 'en',
                        'lang_key' => 'Pending',
                        'lang_value' => 'Pending',
                        'created_at' => '2020-11-03 09:15:15',
                        'updated_at' => '2020-11-03 09:15:15',
                    ),
                426 =>
                    array(
                        'id' => 645,
                        'lang' => 'en',
                        'lang_key' => 'Type Order code & hit Enter',
                        'lang_value' => 'Type Order code & hit Enter',
                        'created_at' => '2020-11-03 09:15:15',
                        'updated_at' => '2020-11-03 09:15:15',
                    ),
                427 =>
                    array(
                        'id' => 646,
                        'lang' => 'en',
                        'lang_key' => 'Num. of Products',
                        'lang_value' => 'Num. of Products',
                        'created_at' => '2020-11-03 09:15:15',
                        'updated_at' => '2020-11-03 09:15:15',
                    ),
                428 =>
                    array(
                        'id' => 647,
                        'lang' => 'en',
                        'lang_key' => 'Walk In Customer',
                        'lang_value' => 'Walk In Customer',
                        'created_at' => '2020-11-03 12:03:20',
                        'updated_at' => '2020-11-03 12:03:20',
                    ),
                429 =>
                    array(
                        'id' => 648,
                        'lang' => 'en',
                        'lang_key' => 'QTY',
                        'lang_value' => 'QTY',
                        'created_at' => '2020-11-03 12:03:20',
                        'updated_at' => '2020-11-03 12:03:20',
                    ),
                430 =>
                    array(
                        'id' => 649,
                        'lang' => 'en',
                        'lang_key' => 'Without Shipping Charge',
                        'lang_value' => 'Without Shipping Charge',
                        'created_at' => '2020-11-03 12:03:20',
                        'updated_at' => '2020-11-03 12:03:20',
                    ),
                431 =>
                    array(
                        'id' => 650,
                        'lang' => 'en',
                        'lang_key' => 'With Shipping Charge',
                        'lang_value' => 'With Shipping Charge',
                        'created_at' => '2020-11-03 12:03:20',
                        'updated_at' => '2020-11-03 12:03:20',
                    ),
                432 =>
                    array(
                        'id' => 651,
                        'lang' => 'en',
                        'lang_key' => 'Pay With Cash',
                        'lang_value' => 'Pay With Cash',
                        'created_at' => '2020-11-03 12:03:20',
                        'updated_at' => '2020-11-03 12:03:20',
                    ),
                433 =>
                    array(
                        'id' => 652,
                        'lang' => 'en',
                        'lang_key' => 'Shipping Address',
                        'lang_value' => 'Shipping Address',
                        'created_at' => '2020-11-03 12:03:20',
                        'updated_at' => '2020-11-03 12:03:20',
                    ),
                434 =>
                    array(
                        'id' => 653,
                        'lang' => 'en',
                        'lang_key' => 'Close',
                        'lang_value' => 'Close',
                        'created_at' => '2020-11-03 12:03:20',
                        'updated_at' => '2020-11-03 12:03:20',
                    ),
                435 =>
                    array(
                        'id' => 654,
                        'lang' => 'en',
                        'lang_key' => 'Select country',
                        'lang_value' => 'Select country',
                        'created_at' => '2020-11-03 12:03:21',
                        'updated_at' => '2020-11-03 12:03:21',
                    ),
                436 =>
                    array(
                        'id' => 655,
                        'lang' => 'en',
                        'lang_key' => 'Order Confirmation',
                        'lang_value' => 'Order Confirmation',
                        'created_at' => '2020-11-03 12:03:21',
                        'updated_at' => '2020-11-03 12:03:21',
                    ),
                437 =>
                    array(
                        'id' => 656,
                        'lang' => 'en',
                        'lang_key' => 'Are you sure to confirm this order?',
                        'lang_value' => 'Are you sure to confirm this order?',
                        'created_at' => '2020-11-03 12:03:21',
                        'updated_at' => '2020-11-03 12:03:21',
                    ),
                438 =>
                    array(
                        'id' => 657,
                        'lang' => 'en',
                        'lang_key' => 'Comfirm Order',
                        'lang_value' => 'Comfirm Order',
                        'created_at' => '2020-11-03 12:03:21',
                        'updated_at' => '2020-11-03 12:03:21',
                    ),
                439 =>
                    array(
                        'id' => 659,
                        'lang' => 'en',
                        'lang_key' => 'Personal Info',
                        'lang_value' => 'Personal Info',
                        'created_at' => '2020-11-03 13:38:15',
                        'updated_at' => '2020-11-03 13:38:15',
                    ),
                440 =>
                    array(
                        'id' => 660,
                        'lang' => 'en',
                        'lang_key' => 'Repeat Password',
                        'lang_value' => 'Repeat Password',
                        'created_at' => '2020-11-03 13:38:15',
                        'updated_at' => '2020-11-03 13:38:15',
                    ),
                441 =>
                    array(
                        'id' => 661,
                        'lang' => 'en',
                        'lang_key' => 'Shop Name',
                        'lang_value' => 'Shop Name',
                        'created_at' => '2020-11-03 13:38:15',
                        'updated_at' => '2020-11-03 13:38:15',
                    ),
                442 =>
                    array(
                        'id' => 662,
                        'lang' => 'en',
                        'lang_key' => 'Register Your Shop',
                        'lang_value' => 'Register Your Shop',
                        'created_at' => '2020-11-03 13:38:15',
                        'updated_at' => '2020-11-03 13:38:15',
                    ),
                443 =>
                    array(
                        'id' => 663,
                        'lang' => 'en',
                        'lang_key' => 'Affiliate Informations',
                        'lang_value' => 'Affiliate Informations',
                        'created_at' => '2020-11-03 13:39:06',
                        'updated_at' => '2020-11-03 13:39:06',
                    ),
                444 =>
                    array(
                        'id' => 664,
                        'lang' => 'en',
                        'lang_key' => 'Affiliate',
                        'lang_value' => 'Affiliate',
                        'created_at' => '2020-11-03 13:39:06',
                        'updated_at' => '2020-11-03 13:39:06',
                    ),
                445 =>
                    array(
                        'id' => 665,
                        'lang' => 'en',
                        'lang_key' => 'User Info',
                        'lang_value' => 'User Info',
                        'created_at' => '2020-11-03 13:39:06',
                        'updated_at' => '2020-11-03 13:39:06',
                    ),
                446 =>
                    array(
                        'id' => 667,
                        'lang' => 'en',
                        'lang_key' => 'Installed Addon',
                        'lang_value' => 'Installed Addon',
                        'created_at' => '2020-11-03 13:48:13',
                        'updated_at' => '2020-11-03 13:48:13',
                    ),
                447 =>
                    array(
                        'id' => 668,
                        'lang' => 'en',
                        'lang_key' => 'Available Addon',
                        'lang_value' => 'Available Addon',
                        'created_at' => '2020-11-03 13:48:13',
                        'updated_at' => '2020-11-03 13:48:13',
                    ),
                448 =>
                    array(
                        'id' => 669,
                        'lang' => 'en',
                        'lang_key' => 'Install New Addon',
                        'lang_value' => 'Install New Addon',
                        'created_at' => '2020-11-03 13:48:13',
                        'updated_at' => '2020-11-03 13:48:13',
                    ),
                449 =>
                    array(
                        'id' => 670,
                        'lang' => 'en',
                        'lang_key' => 'Version',
                        'lang_value' => 'Version',
                        'created_at' => '2020-11-03 13:48:13',
                        'updated_at' => '2020-11-03 13:48:13',
                    ),
                450 =>
                    array(
                        'id' => 671,
                        'lang' => 'en',
                        'lang_key' => 'Activated',
                        'lang_value' => 'Activated',
                        'created_at' => '2020-11-03 13:48:13',
                        'updated_at' => '2020-11-03 13:48:13',
                    ),
                451 =>
                    array(
                        'id' => 672,
                        'lang' => 'en',
                        'lang_key' => 'Deactivated',
                        'lang_value' => 'Deactivated',
                        'created_at' => '2020-11-03 13:48:13',
                        'updated_at' => '2020-11-03 13:48:13',
                    ),
                452 =>
                    array(
                        'id' => 673,
                        'lang' => 'en',
                        'lang_key' => 'Activate OTP',
                        'lang_value' => 'Activate OTP',
                        'created_at' => '2020-11-03 13:48:20',
                        'updated_at' => '2020-11-03 13:48:20',
                    ),
                453 =>
                    array(
                        'id' => 674,
                        'lang' => 'en',
                        'lang_key' => 'OTP will be Used For',
                        'lang_value' => 'OTP will be Used For',
                        'created_at' => '2020-11-03 13:48:20',
                        'updated_at' => '2020-11-03 13:48:20',
                    ),
                454 =>
                    array(
                        'id' => 675,
                        'lang' => 'en',
                        'lang_key' => 'Settings updated successfully',
                        'lang_value' => 'Settings updated successfully',
                        'created_at' => '2020-11-03 13:48:20',
                        'updated_at' => '2020-11-03 13:48:20',
                    ),
                455 =>
                    array(
                        'id' => 676,
                        'lang' => 'en',
                        'lang_key' => 'Product Owner',
                        'lang_value' => 'Product Owner',
                        'created_at' => '2020-11-03 13:48:46',
                        'updated_at' => '2020-11-03 13:48:46',
                    ),
                456 =>
                    array(
                        'id' => 677,
                        'lang' => 'en',
                        'lang_key' => 'Point',
                        'lang_value' => 'Point',
                        'created_at' => '2020-11-03 13:48:46',
                        'updated_at' => '2020-11-03 13:48:46',
                    ),
                457 =>
                    array(
                        'id' => 678,
                        'lang' => 'en',
                        'lang_key' => 'Set Point for Product Within a Range',
                        'lang_value' => 'Set Point for Product Within a Range',
                        'created_at' => '2020-11-03 13:48:47',
                        'updated_at' => '2020-11-03 13:48:47',
                    ),
                458 =>
                    array(
                        'id' => 679,
                        'lang' => 'en',
                        'lang_key' => 'Set Point for multiple products',
                        'lang_value' => 'Set Point for multiple products',
                        'created_at' => '2020-11-03 13:48:47',
                        'updated_at' => '2020-11-03 13:48:47',
                    ),
                459 =>
                    array(
                        'id' => 680,
                        'lang' => 'en',
                        'lang_key' => 'Min Price',
                        'lang_value' => 'Min Price',
                        'created_at' => '2020-11-03 13:48:47',
                        'updated_at' => '2020-11-03 13:48:47',
                    ),
                460 =>
                    array(
                        'id' => 681,
                        'lang' => 'en',
                        'lang_key' => 'Max Price',
                        'lang_value' => 'Max Price',
                        'created_at' => '2020-11-03 13:48:47',
                        'updated_at' => '2020-11-03 13:48:47',
                    ),
                461 =>
                    array(
                        'id' => 682,
                        'lang' => 'en',
                        'lang_key' => 'Set Point for all Products',
                        'lang_value' => 'Set Point for all Products',
                        'created_at' => '2020-11-03 13:48:47',
                        'updated_at' => '2020-11-03 13:48:47',
                    ),
                462 =>
                    array(
                        'id' => 683,
                        'lang' => 'en',
                        'lang_key' => 'Set Point For ',
                        'lang_value' => 'Set Point For ',
                        'created_at' => '2020-11-03 13:48:47',
                        'updated_at' => '2020-11-03 13:48:47',
                    ),
                463 =>
                    array(
                        'id' => 684,
                        'lang' => 'en',
                        'lang_key' => 'Convert Status',
                        'lang_value' => 'Convert Status',
                        'created_at' => '2020-11-03 13:48:58',
                        'updated_at' => '2020-11-03 13:48:58',
                    ),
                464 =>
                    array(
                        'id' => 685,
                        'lang' => 'en',
                        'lang_key' => 'Earned At',
                        'lang_value' => 'Earned At',
                        'created_at' => '2020-11-03 13:48:59',
                        'updated_at' => '2020-11-03 13:48:59',
                    ),
                465 =>
                    array(
                        'id' => 686,
                        'lang' => 'en',
                        'lang_key' => 'Seller Based Selling Report',
                        'lang_value' => 'Seller Based Selling Report',
                        'created_at' => '2020-11-03 13:49:35',
                        'updated_at' => '2020-11-03 13:49:35',
                    ),
                466 =>
                    array(
                        'id' => 687,
                        'lang' => 'en',
                        'lang_key' => 'Sort by verificarion status',
                        'lang_value' => 'Sort by verificarion status',
                        'created_at' => '2020-11-03 13:49:35',
                        'updated_at' => '2020-11-03 13:49:35',
                    ),
                467 =>
                    array(
                        'id' => 688,
                        'lang' => 'en',
                        'lang_key' => 'Approved',
                        'lang_value' => 'Approved',
                        'created_at' => '2020-11-03 13:49:35',
                        'updated_at' => '2020-11-03 13:49:35',
                    ),
                468 =>
                    array(
                        'id' => 689,
                        'lang' => 'en',
                        'lang_key' => 'Non Approved',
                        'lang_value' => 'Non Approved',
                        'created_at' => '2020-11-03 13:49:35',
                        'updated_at' => '2020-11-03 13:49:35',
                    ),
                469 =>
                    array(
                        'id' => 690,
                        'lang' => 'en',
                        'lang_key' => 'Filter',
                        'lang_value' => 'Filter',
                        'created_at' => '2020-11-03 13:49:35',
                        'updated_at' => '2020-11-03 13:49:35',
                    ),
                470 =>
                    array(
                        'id' => 691,
                        'lang' => 'en',
                        'lang_key' => 'Seller Name',
                        'lang_value' => 'Seller Name',
                        'created_at' => '2020-11-03 13:49:35',
                        'updated_at' => '2020-11-03 13:49:35',
                    ),
                471 =>
                    array(
                        'id' => 692,
                        'lang' => 'en',
                        'lang_key' => 'Number of Product Sale',
                        'lang_value' => 'Number of Product Sale',
                        'created_at' => '2020-11-03 13:49:36',
                        'updated_at' => '2020-11-03 13:49:36',
                    ),
                472 =>
                    array(
                        'id' => 693,
                        'lang' => 'en',
                        'lang_key' => 'Order Amount',
                        'lang_value' => 'Order Amount',
                        'created_at' => '2020-11-03 13:49:36',
                        'updated_at' => '2020-11-03 13:49:36',
                    ),
                473 =>
                    array(
                        'id' => 694,
                        'lang' => 'en',
                        'lang_key' => 'Facebook Chat Setting',
                        'lang_value' => 'Facebook Chat Setting',
                        'created_at' => '2020-11-03 13:51:14',
                        'updated_at' => '2020-11-03 13:51:14',
                    ),
                474 =>
                    array(
                        'id' => 695,
                        'lang' => 'en',
                        'lang_key' => 'Facebook Page ID',
                        'lang_value' => 'Facebook Page ID',
                        'created_at' => '2020-11-03 13:51:14',
                        'updated_at' => '2020-11-03 13:51:14',
                    ),
                475 =>
                    array(
                        'id' => 696,
                        'lang' => 'en',
                        'lang_key' => 'Please be carefull when you are configuring Facebook chat. For incorrect configuration you will not get messenger icon on your user-end site.',
                        'lang_value' => 'Please be carefull when you are configuring Facebook chat. For incorrect configuration you will not get messenger icon on your user-end site.',
                        'created_at' => '2020-11-03 13:51:14',
                        'updated_at' => '2020-11-03 13:51:14',
                    ),
                476 =>
                    array(
                        'id' => 697,
                        'lang' => 'en',
                        'lang_key' => 'Login into your facebook page',
                        'lang_value' => 'Login into your facebook page',
                        'created_at' => '2020-11-03 13:51:14',
                        'updated_at' => '2020-11-03 13:51:14',
                    ),
                477 =>
                    array(
                        'id' => 698,
                        'lang' => 'en',
                        'lang_key' => 'Find the About option of your facebook page',
                        'lang_value' => 'Find the About option of your facebook page',
                        'created_at' => '2020-11-03 13:51:14',
                        'updated_at' => '2020-11-03 13:51:14',
                    ),
                478 =>
                    array(
                        'id' => 699,
                        'lang' => 'en',
                        'lang_key' => 'At the very bottom, you can find the \\“Facebook Page ID\\”',
                        'lang_value' => 'At the very bottom, you can find the \\“Facebook Page ID\\”',
                        'created_at' => '2020-11-03 13:51:14',
                        'updated_at' => '2020-11-03 13:51:14',
                    ),
                479 =>
                    array(
                        'id' => 700,
                        'lang' => 'en',
                        'lang_key' => 'Go to Settings of your page and find the option of \\"Advance Messaging\\"',
                        'lang_value' => 'Go to Settings of your page and find the option of \\"Advance Messaging\\"',
                        'created_at' => '2020-11-03 13:51:14',
                        'updated_at' => '2020-11-03 13:51:14',
                    ),
                480 =>
                    array(
                        'id' => 701,
                        'lang' => 'en',
                        'lang_key' => 'Scroll down that page and you will get \\"white listed domain\\"',
                        'lang_value' => 'Scroll down that page and you will get \\"white listed domain\\"',
                        'created_at' => '2020-11-03 13:51:14',
                        'updated_at' => '2020-11-03 13:51:14',
                    ),
                481 =>
                    array(
                        'id' => 702,
                        'lang' => 'en',
                        'lang_key' => 'Set your website domain name',
                        'lang_value' => 'Set your website domain name',
                        'created_at' => '2020-11-03 13:51:14',
                        'updated_at' => '2020-11-03 13:51:14',
                    ),
                482 =>
                    array(
                        'id' => 703,
                        'lang' => 'en',
                        'lang_key' => 'Google reCAPTCHA Setting',
                        'lang_value' => 'Google reCAPTCHA Setting',
                        'created_at' => '2020-11-03 13:51:25',
                        'updated_at' => '2020-11-03 13:51:25',
                    ),
                483 =>
                    array(
                        'id' => 704,
                        'lang' => 'en',
                        'lang_key' => 'Site KEY',
                        'lang_value' => 'Site KEY',
                        'created_at' => '2020-11-03 13:51:25',
                        'updated_at' => '2020-11-03 13:51:25',
                    ),
                484 =>
                    array(
                        'id' => 705,
                        'lang' => 'en',
                        'lang_key' => 'Select Shipping Method',
                        'lang_value' => 'Select Shipping Method',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                485 =>
                    array(
                        'id' => 706,
                        'lang' => 'en',
                        'lang_key' => 'Product Wise Shipping Cost',
                        'lang_value' => 'Product Wise Shipping Cost',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                486 =>
                    array(
                        'id' => 707,
                        'lang' => 'en',
                        'lang_key' => 'Flat Rate Shipping Cost',
                        'lang_value' => 'Flat Rate Shipping Cost',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                487 =>
                    array(
                        'id' => 708,
                        'lang' => 'en',
                        'lang_key' => 'Seller Wise Flat Shipping Cost',
                        'lang_value' => 'Seller Wise Flat Shipping Cost',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                488 =>
                    array(
                        'id' => 709,
                        'lang' => 'en',
                        'lang_key' => 'Note',
                        'lang_value' => 'Note',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                489 =>
                    array(
                        'id' => 710,
                        'lang' => 'en',
                        'lang_key' => 'Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost',
                        'lang_value' => 'Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                490 =>
                    array(
                        'id' => 711,
                        'lang' => 'en',
                        'lang_key' => 'Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn\'t matter. Shipping cost is fixed',
                        'lang_value' => 'Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn\'t matter. Shipping cost is fixed',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                491 =>
                    array(
                        'id' => 712,
                        'lang' => 'en',
                        'lang_key' => 'Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If a customer purchase 2 product from two seller shipping cost is calculate by addition of each seller flat shipping cost',
                        'lang_value' => 'Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If a customer purchase 2 product from two seller shipping cost is calculate by addition of each seller flat shipping cost',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                492 =>
                    array(
                        'id' => 713,
                        'lang' => 'en',
                        'lang_key' => 'Flat Rate Cost',
                        'lang_value' => 'Flat Rate Cost',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                493 =>
                    array(
                        'id' => 714,
                        'lang' => 'en',
                        'lang_key' => 'Shipping Cost for Admin Products',
                        'lang_value' => 'Shipping Cost for Admin Products',
                        'created_at' => '2020-11-03 13:51:32',
                        'updated_at' => '2020-11-03 13:51:32',
                    ),
                494 =>
                    array(
                        'id' => 715,
                        'lang' => 'en',
                        'lang_key' => 'Countries',
                        'lang_value' => 'Countries',
                        'created_at' => '2020-11-03 13:52:02',
                        'updated_at' => '2020-11-03 13:52:02',
                    ),
                495 =>
                    array(
                        'id' => 716,
                        'lang' => 'en',
                        'lang_key' => 'Show/Hide',
                        'lang_value' => 'Show/Hide',
                        'created_at' => '2020-11-03 13:52:02',
                        'updated_at' => '2020-11-03 13:52:02',
                    ),
                496 =>
                    array(
                        'id' => 717,
                        'lang' => 'en',
                        'lang_key' => 'Country status updated successfully',
                        'lang_value' => 'Country status updated successfully',
                        'created_at' => '2020-11-03 13:52:02',
                        'updated_at' => '2020-11-03 13:52:02',
                    ),
                497 =>
                    array(
                        'id' => 718,
                        'lang' => 'en',
                        'lang_key' => 'All Subcategories',
                        'lang_value' => 'All Subcategories',
                        'created_at' => '2020-11-03 14:27:55',
                        'updated_at' => '2020-11-03 14:27:55',
                    ),
                498 =>
                    array(
                        'id' => 719,
                        'lang' => 'en',
                        'lang_key' => 'Add New Subcategory',
                        'lang_value' => 'Add New Subcategory',
                        'created_at' => '2020-11-03 14:27:55',
                        'updated_at' => '2020-11-03 14:27:55',
                    ),
                499 =>
                    array(
                        'id' => 720,
                        'lang' => 'en',
                        'lang_key' => 'Sub-Categories',
                        'lang_value' => 'Sub-Categories',
                        'created_at' => '2020-11-03 14:27:55',
                        'updated_at' => '2020-11-03 14:27:55',
                    ),
            ));
            \DB::table('translations')->insert(array(
                0 =>
                    array(
                        'id' => 721,
                        'lang' => 'en',
                        'lang_key' => 'Sub Category Information',
                        'lang_value' => 'Sub Category Information',
                        'created_at' => '2020-11-03 14:28:07',
                        'updated_at' => '2020-11-03 14:28:07',
                    ),
                1 =>
                    array(
                        'id' => 723,
                        'lang' => 'en',
                        'lang_key' => 'Slug',
                        'lang_value' => 'Slug',
                        'created_at' => '2020-11-03 14:28:07',
                        'updated_at' => '2020-11-03 14:28:07',
                    ),
                2 =>
                    array(
                        'id' => 724,
                        'lang' => 'en',
                        'lang_key' => 'All Sub Subcategories',
                        'lang_value' => 'All Sub Subcategories',
                        'created_at' => '2020-11-03 14:29:12',
                        'updated_at' => '2020-11-03 14:29:12',
                    ),
                3 =>
                    array(
                        'id' => 725,
                        'lang' => 'en',
                        'lang_key' => 'Add New Sub Subcategory',
                        'lang_value' => 'Add New Sub Subcategory',
                        'created_at' => '2020-11-03 14:29:12',
                        'updated_at' => '2020-11-03 14:29:12',
                    ),
                4 =>
                    array(
                        'id' => 726,
                        'lang' => 'en',
                        'lang_key' => 'Sub-Sub-categories',
                        'lang_value' => 'Sub-Sub-categories',
                        'created_at' => '2020-11-03 14:29:12',
                        'updated_at' => '2020-11-03 14:29:12',
                    ),
                5 =>
                    array(
                        'id' => 727,
                        'lang' => 'en',
                        'lang_key' => 'Make This Default',
                        'lang_value' => 'Make This Default',
                        'created_at' => '2020-11-04 10:24:24',
                        'updated_at' => '2020-11-04 10:24:24',
                    ),
                6 =>
                    array(
                        'id' => 728,
                        'lang' => 'en',
                        'lang_key' => 'Shops',
                        'lang_value' => 'Shops',
                        'created_at' => '2020-11-04 13:17:10',
                        'updated_at' => '2020-11-04 13:17:10',
                    ),
                7 =>
                    array(
                        'id' => 729,
                        'lang' => 'en',
                        'lang_key' => 'Women Clothing & Fashion',
                        'lang_value' => 'Women Clothing & Fashion',
                        'created_at' => '2020-11-04 13:23:12',
                        'updated_at' => '2020-11-04 13:23:12',
                    ),
                8 =>
                    array(
                        'id' => 730,
                        'lang' => 'en',
                        'lang_key' => 'Cellphones & Tabs',
                        'lang_value' => 'Cellphones & Tabs',
                        'created_at' => '2020-11-04 14:10:41',
                        'updated_at' => '2020-11-04 14:10:41',
                    ),
                9 =>
                    array(
                        'id' => 731,
                        'lang' => 'en',
                        'lang_key' => 'Welcome to',
                        'lang_value' => 'Welcome to',
                        'created_at' => '2020-11-07 09:14:43',
                        'updated_at' => '2020-11-07 09:14:43',
                    ),
                10 =>
                    array(
                        'id' => 732,
                        'lang' => 'en',
                        'lang_key' => 'Create a New Account',
                        'lang_value' => 'Create a New Account',
                        'created_at' => '2020-11-07 09:32:15',
                        'updated_at' => '2020-11-07 09:32:15',
                    ),
                11 =>
                    array(
                        'id' => 733,
                        'lang' => 'en',
                        'lang_key' => 'Full Name',
                        'lang_value' => 'Full Name',
                        'created_at' => '2020-11-07 09:32:15',
                        'updated_at' => '2020-11-07 09:32:15',
                    ),
                12 =>
                    array(
                        'id' => 734,
                        'lang' => 'en',
                        'lang_key' => 'password',
                        'lang_value' => 'password',
                        'created_at' => '2020-11-07 09:32:15',
                        'updated_at' => '2020-11-07 09:32:15',
                    ),
                13 =>
                    array(
                        'id' => 735,
                        'lang' => 'en',
                        'lang_key' => 'Confrim Password',
                        'lang_value' => 'Confrim Password',
                        'created_at' => '2020-11-07 09:32:15',
                        'updated_at' => '2020-11-07 09:32:15',
                    ),
                14 =>
                    array(
                        'id' => 736,
                        'lang' => 'en',
                        'lang_key' => 'I agree with the',
                        'lang_value' => 'I agree with the',
                        'created_at' => '2020-11-07 09:32:15',
                        'updated_at' => '2020-11-07 09:32:15',
                    ),
                15 =>
                    array(
                        'id' => 737,
                        'lang' => 'en',
                        'lang_key' => 'Terms and Conditions',
                        'lang_value' => 'Terms and Conditions',
                        'created_at' => '2020-11-07 09:32:15',
                        'updated_at' => '2020-11-07 09:32:15',
                    ),
                16 =>
                    array(
                        'id' => 738,
                        'lang' => 'en',
                        'lang_key' => 'Register',
                        'lang_value' => 'Register',
                        'created_at' => '2020-11-07 09:32:15',
                        'updated_at' => '2020-11-07 09:32:15',
                    ),
                17 =>
                    array(
                        'id' => 739,
                        'lang' => 'en',
                        'lang_key' => 'Already have an account',
                        'lang_value' => 'Already have an account',
                        'created_at' => '2020-11-07 09:32:16',
                        'updated_at' => '2020-11-07 09:32:16',
                    ),
                18 =>
                    array(
                        'id' => 741,
                        'lang' => 'en',
                        'lang_key' => 'Sign Up with',
                        'lang_value' => 'Sign Up with',
                        'created_at' => '2020-11-07 09:32:16',
                        'updated_at' => '2020-11-07 09:32:16',
                    ),
                19 =>
                    array(
                        'id' => 742,
                        'lang' => 'en',
                        'lang_key' => 'I agree with the Terms and Conditions',
                        'lang_value' => 'I agree with the Terms and Conditions',
                        'created_at' => '2020-11-07 09:34:49',
                        'updated_at' => '2020-11-07 09:34:49',
                    ),
                20 =>
                    array(
                        'id' => 745,
                        'lang' => 'en',
                        'lang_key' => 'All Role',
                        'lang_value' => 'All Role',
                        'created_at' => '2020-11-07 09:44:28',
                        'updated_at' => '2020-11-07 09:44:28',
                    ),
                21 =>
                    array(
                        'id' => 746,
                        'lang' => 'en',
                        'lang_key' => 'Add New Role',
                        'lang_value' => 'Add New Role',
                        'created_at' => '2020-11-07 09:44:28',
                        'updated_at' => '2020-11-07 09:44:28',
                    ),
                22 =>
                    array(
                        'id' => 747,
                        'lang' => 'en',
                        'lang_key' => 'Roles',
                        'lang_value' => 'Roles',
                        'created_at' => '2020-11-07 09:44:28',
                        'updated_at' => '2020-11-07 09:44:28',
                    ),
                23 =>
                    array(
                        'id' => 749,
                        'lang' => 'en',
                        'lang_key' => 'Add New Staffs',
                        'lang_value' => 'Add New Staffs',
                        'created_at' => '2020-11-07 09:44:36',
                        'updated_at' => '2020-11-07 09:44:36',
                    ),
                24 =>
                    array(
                        'id' => 750,
                        'lang' => 'en',
                        'lang_key' => 'Role',
                        'lang_value' => 'Role',
                        'created_at' => '2020-11-07 09:44:36',
                        'updated_at' => '2020-11-07 09:44:36',
                    ),
                25 =>
                    array(
                        'id' => 751,
                        'lang' => 'en',
                        'lang_key' => 'Frontend Website Name',
                        'lang_value' => 'Frontend Website Name',
                        'created_at' => '2020-11-07 09:44:59',
                        'updated_at' => '2020-11-07 09:44:59',
                    ),
                26 =>
                    array(
                        'id' => 752,
                        'lang' => 'en',
                        'lang_key' => 'Website Name',
                        'lang_value' => 'Website Name',
                        'created_at' => '2020-11-07 09:44:59',
                        'updated_at' => '2020-11-07 09:44:59',
                    ),
                27 =>
                    array(
                        'id' => 753,
                        'lang' => 'en',
                        'lang_key' => 'Site Motto',
                        'lang_value' => 'Site Motto',
                        'created_at' => '2020-11-07 09:44:59',
                        'updated_at' => '2020-11-07 09:44:59',
                    ),
                28 =>
                    array(
                        'id' => 754,
                        'lang' => 'en',
                        'lang_key' => 'Best eCommerce Website',
                        'lang_value' => 'Best eCommerce Website',
                        'created_at' => '2020-11-07 09:44:59',
                        'updated_at' => '2020-11-07 09:44:59',
                    ),
                29 =>
                    array(
                        'id' => 755,
                        'lang' => 'en',
                        'lang_key' => 'Site Icon',
                        'lang_value' => 'Site Icon',
                        'created_at' => '2020-11-07 09:44:59',
                        'updated_at' => '2020-11-07 09:44:59',
                    ),
                30 =>
                    array(
                        'id' => 756,
                        'lang' => 'en',
                        'lang_key' => 'Website favicon. 32x32 .png',
                        'lang_value' => 'Website favicon. 32x32 .png',
                        'created_at' => '2020-11-07 09:44:59',
                        'updated_at' => '2020-11-07 09:44:59',
                    ),
                31 =>
                    array(
                        'id' => 757,
                        'lang' => 'en',
                        'lang_key' => 'Website Base Color',
                        'lang_value' => 'Website Base Color',
                        'created_at' => '2020-11-07 09:44:59',
                        'updated_at' => '2020-11-07 09:44:59',
                    ),
                32 =>
                    array(
                        'id' => 758,
                        'lang' => 'en',
                        'lang_key' => 'Hex Color Code',
                        'lang_value' => 'Hex Color Code',
                        'created_at' => '2020-11-07 09:44:59',
                        'updated_at' => '2020-11-07 09:44:59',
                    ),
                33 =>
                    array(
                        'id' => 759,
                        'lang' => 'en',
                        'lang_key' => 'Website Base Hover Color',
                        'lang_value' => 'Website Base Hover Color',
                        'created_at' => '2020-11-07 09:44:59',
                        'updated_at' => '2020-11-07 09:44:59',
                    ),
                34 =>
                    array(
                        'id' => 760,
                        'lang' => 'en',
                        'lang_key' => 'Update',
                        'lang_value' => 'Update',
                        'created_at' => '2020-11-07 09:45:00',
                        'updated_at' => '2020-11-07 09:45:00',
                    ),
                35 =>
                    array(
                        'id' => 761,
                        'lang' => 'en',
                        'lang_key' => 'Global Seo',
                        'lang_value' => 'Global Seo',
                        'created_at' => '2020-11-07 09:45:00',
                        'updated_at' => '2020-11-07 09:45:00',
                    ),
                36 =>
                    array(
                        'id' => 762,
                        'lang' => 'en',
                        'lang_key' => 'Meta description',
                        'lang_value' => 'Meta description',
                        'created_at' => '2020-11-07 09:45:00',
                        'updated_at' => '2020-11-07 09:45:00',
                    ),
                37 =>
                    array(
                        'id' => 763,
                        'lang' => 'en',
                        'lang_key' => 'Keywords',
                        'lang_value' => 'Keywords',
                        'created_at' => '2020-11-07 09:45:00',
                        'updated_at' => '2020-11-07 09:45:00',
                    ),
                38 =>
                    array(
                        'id' => 764,
                        'lang' => 'en',
                        'lang_key' => 'Separate with coma',
                        'lang_value' => 'Separate with coma',
                        'created_at' => '2020-11-07 09:45:00',
                        'updated_at' => '2020-11-07 09:45:00',
                    ),
                39 =>
                    array(
                        'id' => 765,
                        'lang' => 'en',
                        'lang_key' => 'Website Pages',
                        'lang_value' => 'Website Pages',
                        'created_at' => '2020-11-07 09:49:04',
                        'updated_at' => '2020-11-07 09:49:04',
                    ),
                40 =>
                    array(
                        'id' => 766,
                        'lang' => 'en',
                        'lang_key' => 'All Pages',
                        'lang_value' => 'All Pages',
                        'created_at' => '2020-11-07 09:49:04',
                        'updated_at' => '2020-11-07 09:49:04',
                    ),
                41 =>
                    array(
                        'id' => 767,
                        'lang' => 'en',
                        'lang_key' => 'Add New Page',
                        'lang_value' => 'Add New Page',
                        'created_at' => '2020-11-07 09:49:04',
                        'updated_at' => '2020-11-07 09:49:04',
                    ),
                42 =>
                    array(
                        'id' => 768,
                        'lang' => 'en',
                        'lang_key' => 'URL',
                        'lang_value' => 'URL',
                        'created_at' => '2020-11-07 09:49:04',
                        'updated_at' => '2020-11-07 09:49:04',
                    ),
                43 =>
                    array(
                        'id' => 769,
                        'lang' => 'en',
                        'lang_key' => 'Actions',
                        'lang_value' => 'Actions',
                        'created_at' => '2020-11-07 09:49:04',
                        'updated_at' => '2020-11-07 09:49:04',
                    ),
                44 =>
                    array(
                        'id' => 770,
                        'lang' => 'en',
                        'lang_key' => 'Edit Page Information',
                        'lang_value' => 'Edit Page Information',
                        'created_at' => '2020-11-07 09:49:22',
                        'updated_at' => '2020-11-07 09:49:22',
                    ),
                45 =>
                    array(
                        'id' => 771,
                        'lang' => 'en',
                        'lang_key' => 'Page Content',
                        'lang_value' => 'Page Content',
                        'created_at' => '2020-11-07 09:49:22',
                        'updated_at' => '2020-11-07 09:49:22',
                    ),
                46 =>
                    array(
                        'id' => 772,
                        'lang' => 'en',
                        'lang_key' => 'Title',
                        'lang_value' => 'Title',
                        'created_at' => '2020-11-07 09:49:22',
                        'updated_at' => '2020-11-07 09:49:22',
                    ),
                47 =>
                    array(
                        'id' => 773,
                        'lang' => 'en',
                        'lang_key' => 'Link',
                        'lang_value' => 'Link',
                        'created_at' => '2020-11-07 09:49:22',
                        'updated_at' => '2020-11-07 09:49:22',
                    ),
                48 =>
                    array(
                        'id' => 774,
                        'lang' => 'en',
                        'lang_key' => 'Use character, number, hypen only',
                        'lang_value' => 'Use character, number, hypen only',
                        'created_at' => '2020-11-07 09:49:22',
                        'updated_at' => '2020-11-07 09:49:22',
                    ),
                49 =>
                    array(
                        'id' => 775,
                        'lang' => 'en',
                        'lang_key' => 'Add Content',
                        'lang_value' => 'Add Content',
                        'created_at' => '2020-11-07 09:49:22',
                        'updated_at' => '2020-11-07 09:49:22',
                    ),
                50 =>
                    array(
                        'id' => 776,
                        'lang' => 'en',
                        'lang_key' => 'Seo Fields',
                        'lang_value' => 'Seo Fields',
                        'created_at' => '2020-11-07 09:49:22',
                        'updated_at' => '2020-11-07 09:49:22',
                    ),
                51 =>
                    array(
                        'id' => 777,
                        'lang' => 'en',
                        'lang_key' => 'Update Page',
                        'lang_value' => 'Update Page',
                        'created_at' => '2020-11-07 09:49:22',
                        'updated_at' => '2020-11-07 09:49:22',
                    ),
                52 =>
                    array(
                        'id' => 778,
                        'lang' => 'en',
                        'lang_key' => 'Default Language',
                        'lang_value' => 'Default Language',
                        'created_at' => '2020-11-07 09:50:09',
                        'updated_at' => '2020-11-07 09:50:09',
                    ),
                53 =>
                    array(
                        'id' => 779,
                        'lang' => 'en',
                        'lang_key' => 'Add New Language',
                        'lang_value' => 'Add New Language',
                        'created_at' => '2020-11-07 09:50:09',
                        'updated_at' => '2020-11-07 09:50:09',
                    ),
                54 =>
                    array(
                        'id' => 780,
                        'lang' => 'en',
                        'lang_key' => 'RTL',
                        'lang_value' => 'RTL',
                        'created_at' => '2020-11-07 09:50:09',
                        'updated_at' => '2020-11-07 09:50:09',
                    ),
                55 =>
                    array(
                        'id' => 781,
                        'lang' => 'en',
                        'lang_key' => 'Translation',
                        'lang_value' => 'Translation',
                        'created_at' => '2020-11-07 09:50:09',
                        'updated_at' => '2020-11-07 09:50:09',
                    ),
                56 =>
                    array(
                        'id' => 782,
                        'lang' => 'en',
                        'lang_key' => 'Language Information',
                        'lang_value' => 'Language Information',
                        'created_at' => '2020-11-07 09:50:23',
                        'updated_at' => '2020-11-07 09:50:23',
                    ),
                57 =>
                    array(
                        'id' => 783,
                        'lang' => 'en',
                        'lang_key' => 'Save Page',
                        'lang_value' => 'Save Page',
                        'created_at' => '2020-11-07 09:51:27',
                        'updated_at' => '2020-11-07 09:51:27',
                    ),
                58 =>
                    array(
                        'id' => 784,
                        'lang' => 'en',
                        'lang_key' => 'Home Page Settings',
                        'lang_value' => 'Home Page Settings',
                        'created_at' => '2020-11-07 09:51:35',
                        'updated_at' => '2020-11-07 09:51:35',
                    ),
                59 =>
                    array(
                        'id' => 785,
                        'lang' => 'en',
                        'lang_key' => 'Home Slider',
                        'lang_value' => 'Home Slider',
                        'created_at' => '2020-11-07 09:51:35',
                        'updated_at' => '2020-11-07 09:51:35',
                    ),
                60 =>
                    array(
                        'id' => 786,
                        'lang' => 'en',
                        'lang_key' => 'Photos & Links',
                        'lang_value' => 'Photos & Links',
                        'created_at' => '2020-11-07 09:51:35',
                        'updated_at' => '2020-11-07 09:51:35',
                    ),
                61 =>
                    array(
                        'id' => 787,
                        'lang' => 'en',
                        'lang_key' => 'Add New',
                        'lang_value' => 'Add New',
                        'created_at' => '2020-11-07 09:51:35',
                        'updated_at' => '2020-11-07 09:51:35',
                    ),
                62 =>
                    array(
                        'id' => 788,
                        'lang' => 'en',
                        'lang_key' => 'Home Categories',
                        'lang_value' => 'Home Categories',
                        'created_at' => '2020-11-07 09:51:35',
                        'updated_at' => '2020-11-07 09:51:35',
                    ),
                63 =>
                    array(
                        'id' => 789,
                        'lang' => 'en',
                        'lang_key' => 'Home Banner 1 (Max 3)',
                        'lang_value' => 'Home Banner 1 (Max 3)',
                        'created_at' => '2020-11-07 09:51:35',
                        'updated_at' => '2020-11-07 09:51:35',
                    ),
                64 =>
                    array(
                        'id' => 790,
                        'lang' => 'en',
                        'lang_key' => 'Banner & Links',
                        'lang_value' => 'Banner & Links',
                        'created_at' => '2020-11-07 09:51:35',
                        'updated_at' => '2020-11-07 09:51:35',
                    ),
                65 =>
                    array(
                        'id' => 791,
                        'lang' => 'en',
                        'lang_key' => 'Home Banner 2 (Max 3)',
                        'lang_value' => 'Home Banner 2 (Max 3)',
                        'created_at' => '2020-11-07 09:51:36',
                        'updated_at' => '2020-11-07 09:51:36',
                    ),
                66 =>
                    array(
                        'id' => 792,
                        'lang' => 'en',
                        'lang_key' => 'Top 10',
                        'lang_value' => 'Top 10',
                        'created_at' => '2020-11-07 09:51:36',
                        'updated_at' => '2020-11-07 09:51:36',
                    ),
                67 =>
                    array(
                        'id' => 793,
                        'lang' => 'en',
                        'lang_key' => 'Top Categories (Max 10)',
                        'lang_value' => 'Top Categories (Max 10)',
                        'created_at' => '2020-11-07 09:51:36',
                        'updated_at' => '2020-11-07 09:51:36',
                    ),
                68 =>
                    array(
                        'id' => 794,
                        'lang' => 'en',
                        'lang_key' => 'Top Brands (Max 10)',
                        'lang_value' => 'Top Brands (Max 10)',
                        'created_at' => '2020-11-07 09:51:36',
                        'updated_at' => '2020-11-07 09:51:36',
                    ),
                69 =>
                    array(
                        'id' => 795,
                        'lang' => 'en',
                        'lang_key' => 'System Name',
                        'lang_value' => 'System Name',
                        'created_at' => '2020-11-07 09:54:22',
                        'updated_at' => '2020-11-07 09:54:22',
                    ),
                70 =>
                    array(
                        'id' => 796,
                        'lang' => 'en',
                        'lang_key' => 'System Logo - White',
                        'lang_value' => 'System Logo - White',
                        'created_at' => '2020-11-07 09:54:22',
                        'updated_at' => '2020-11-07 09:54:22',
                    ),
                71 =>
                    array(
                        'id' => 797,
                        'lang' => 'en',
                        'lang_key' => 'Choose Files',
                        'lang_value' => 'Choose Files',
                        'created_at' => '2020-11-07 09:54:22',
                        'updated_at' => '2020-11-07 09:54:22',
                    ),
                72 =>
                    array(
                        'id' => 798,
                        'lang' => 'en',
                        'lang_key' => 'Will be used in admin panel side menu',
                        'lang_value' => 'Will be used in admin panel side menu',
                        'created_at' => '2020-11-07 09:54:23',
                        'updated_at' => '2020-11-07 09:54:23',
                    ),
                73 =>
                    array(
                        'id' => 799,
                        'lang' => 'en',
                        'lang_key' => 'System Logo - Black',
                        'lang_value' => 'System Logo - Black',
                        'created_at' => '2020-11-07 09:54:23',
                        'updated_at' => '2020-11-07 09:54:23',
                    ),
                74 =>
                    array(
                        'id' => 800,
                        'lang' => 'en',
                        'lang_key' => 'Will be used in admin panel topbar in mobile + Admin login page',
                        'lang_value' => 'Will be used in admin panel topbar in mobile + Admin login page',
                        'created_at' => '2020-11-07 09:54:23',
                        'updated_at' => '2020-11-07 09:54:23',
                    ),
                75 =>
                    array(
                        'id' => 801,
                        'lang' => 'en',
                        'lang_key' => 'System Timezone',
                        'lang_value' => 'System Timezone',
                        'created_at' => '2020-11-07 09:54:23',
                        'updated_at' => '2020-11-07 09:54:23',
                    ),
                76 =>
                    array(
                        'id' => 802,
                        'lang' => 'en',
                        'lang_key' => 'Admin login page background',
                        'lang_value' => 'Admin login page background',
                        'created_at' => '2020-11-07 09:54:23',
                        'updated_at' => '2020-11-07 09:54:23',
                    ),
                77 =>
                    array(
                        'id' => 803,
                        'lang' => 'en',
                        'lang_key' => 'Website Header',
                        'lang_value' => 'Website Header',
                        'created_at' => '2020-11-07 10:21:36',
                        'updated_at' => '2020-11-07 10:21:36',
                    ),
                78 =>
                    array(
                        'id' => 804,
                        'lang' => 'en',
                        'lang_key' => 'Header Setting',
                        'lang_value' => 'Header Setting',
                        'created_at' => '2020-11-07 10:21:36',
                        'updated_at' => '2020-11-07 10:21:36',
                    ),
                79 =>
                    array(
                        'id' => 805,
                        'lang' => 'en',
                        'lang_key' => 'Header Logo',
                        'lang_value' => 'Header Logo',
                        'created_at' => '2020-11-07 10:21:36',
                        'updated_at' => '2020-11-07 10:21:36',
                    ),
                80 =>
                    array(
                        'id' => 806,
                        'lang' => 'en',
                        'lang_key' => 'Show Language Switcher?',
                        'lang_value' => 'Show Language Switcher?',
                        'created_at' => '2020-11-07 10:21:36',
                        'updated_at' => '2020-11-07 10:21:36',
                    ),
                81 =>
                    array(
                        'id' => 807,
                        'lang' => 'en',
                        'lang_key' => 'Show Currency Switcher?',
                        'lang_value' => 'Show Currency Switcher?',
                        'created_at' => '2020-11-07 10:21:36',
                        'updated_at' => '2020-11-07 10:21:36',
                    ),
                82 =>
                    array(
                        'id' => 808,
                        'lang' => 'en',
                        'lang_key' => 'Enable stikcy header?',
                        'lang_value' => 'Enable stikcy header?',
                        'created_at' => '2020-11-07 10:21:36',
                        'updated_at' => '2020-11-07 10:21:36',
                    ),
                83 =>
                    array(
                        'id' => 809,
                        'lang' => 'en',
                        'lang_key' => 'Website Footer',
                        'lang_value' => 'Website Footer',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                84 =>
                    array(
                        'id' => 810,
                        'lang' => 'en',
                        'lang_key' => 'Footer Widget',
                        'lang_value' => 'Footer Widget',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                85 =>
                    array(
                        'id' => 811,
                        'lang' => 'en',
                        'lang_key' => 'About Widget',
                        'lang_value' => 'About Widget',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                86 =>
                    array(
                        'id' => 812,
                        'lang' => 'en',
                        'lang_key' => 'Footer Logo',
                        'lang_value' => 'Footer Logo',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                87 =>
                    array(
                        'id' => 813,
                        'lang' => 'en',
                        'lang_key' => 'About description',
                        'lang_value' => 'About description',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                88 =>
                    array(
                        'id' => 814,
                        'lang' => 'en',
                        'lang_key' => 'Contact Info Widget',
                        'lang_value' => 'Contact Info Widget',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                89 =>
                    array(
                        'id' => 815,
                        'lang' => 'en',
                        'lang_key' => 'Footer contact address',
                        'lang_value' => 'Footer contact address',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                90 =>
                    array(
                        'id' => 816,
                        'lang' => 'en',
                        'lang_key' => 'Footer contact phone',
                        'lang_value' => 'Footer contact phone',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                91 =>
                    array(
                        'id' => 817,
                        'lang' => 'en',
                        'lang_key' => 'Footer contact email',
                        'lang_value' => 'Footer contact email',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                92 =>
                    array(
                        'id' => 818,
                        'lang' => 'en',
                        'lang_key' => 'Link Widget One',
                        'lang_value' => 'Link Widget One',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                93 =>
                    array(
                        'id' => 819,
                        'lang' => 'en',
                        'lang_key' => 'Links',
                        'lang_value' => 'Links',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                94 =>
                    array(
                        'id' => 820,
                        'lang' => 'en',
                        'lang_key' => 'Footer Bottom',
                        'lang_value' => 'Footer Bottom',
                        'created_at' => '2020-11-07 10:21:56',
                        'updated_at' => '2020-11-07 10:21:56',
                    ),
                95 =>
                    array(
                        'id' => 821,
                        'lang' => 'en',
                        'lang_key' => 'Copyright Widget ',
                        'lang_value' => 'Copyright Widget ',
                        'created_at' => '2020-11-07 10:21:57',
                        'updated_at' => '2020-11-07 10:21:57',
                    ),
                96 =>
                    array(
                        'id' => 822,
                        'lang' => 'en',
                        'lang_key' => 'Copyright Text',
                        'lang_value' => 'Copyright Text',
                        'created_at' => '2020-11-07 10:21:57',
                        'updated_at' => '2020-11-07 10:21:57',
                    ),
                97 =>
                    array(
                        'id' => 823,
                        'lang' => 'en',
                        'lang_key' => 'Social Link Widget ',
                        'lang_value' => 'Social Link Widget ',
                        'created_at' => '2020-11-07 10:21:57',
                        'updated_at' => '2020-11-07 10:21:57',
                    ),
                98 =>
                    array(
                        'id' => 824,
                        'lang' => 'en',
                        'lang_key' => 'Show Social Links?',
                        'lang_value' => 'Show Social Links?',
                        'created_at' => '2020-11-07 10:21:57',
                        'updated_at' => '2020-11-07 10:21:57',
                    ),
                99 =>
                    array(
                        'id' => 825,
                        'lang' => 'en',
                        'lang_key' => 'Social Links',
                        'lang_value' => 'Social Links',
                        'created_at' => '2020-11-07 10:21:57',
                        'updated_at' => '2020-11-07 10:21:57',
                    ),
                100 =>
                    array(
                        'id' => 826,
                        'lang' => 'en',
                        'lang_key' => 'Payment Methods Widget ',
                        'lang_value' => 'Payment Methods Widget ',
                        'created_at' => '2020-11-07 10:21:57',
                        'updated_at' => '2020-11-07 10:21:57',
                    ),
                101 =>
                    array(
                        'id' => 827,
                        'lang' => 'en',
                        'lang_key' => 'RTL status updated successfully',
                        'lang_value' => 'RTL status updated successfully',
                        'created_at' => '2020-11-07 10:36:11',
                        'updated_at' => '2020-11-07 10:36:11',
                    ),
                102 =>
                    array(
                        'id' => 828,
                        'lang' => 'en',
                        'lang_key' => 'Language changed to ',
                        'lang_value' => 'Language changed to ',
                        'created_at' => '2020-11-07 10:36:27',
                        'updated_at' => '2020-11-07 10:36:27',
                    ),
                103 =>
                    array(
                        'id' => 829,
                        'lang' => 'en',
                        'lang_key' => 'Inhouse Product sale report',
                        'lang_value' => 'Inhouse Product sale report',
                        'created_at' => '2020-11-07 11:30:25',
                        'updated_at' => '2020-11-07 11:30:25',
                    ),
                104 =>
                    array(
                        'id' => 830,
                        'lang' => 'en',
                        'lang_key' => 'Sort by Category',
                        'lang_value' => 'Sort by Category',
                        'created_at' => '2020-11-07 11:30:25',
                        'updated_at' => '2020-11-07 11:30:25',
                    ),
                105 =>
                    array(
                        'id' => 831,
                        'lang' => 'en',
                        'lang_key' => 'Product wise stock report',
                        'lang_value' => 'Product wise stock report',
                        'created_at' => '2020-11-07 11:31:02',
                        'updated_at' => '2020-11-07 11:31:02',
                    ),
                106 =>
                    array(
                        'id' => 832,
                        'lang' => 'en',
                        'lang_key' => 'Currency changed to ',
                        'lang_value' => 'Currency changed to ',
                        'created_at' => '2020-11-07 14:36:28',
                        'updated_at' => '2020-11-07 14:36:28',
                    ),
                107 =>
                    array(
                        'id' => 833,
                        'lang' => 'en',
                        'lang_key' => 'Avatar',
                        'lang_value' => 'Avatar',
                        'created_at' => '2020-11-08 11:32:35',
                        'updated_at' => '2020-11-08 11:32:35',
                    ),
                108 =>
                    array(
                        'id' => 834,
                        'lang' => 'en',
                        'lang_key' => 'Copy',
                        'lang_value' => 'Copy',
                        'created_at' => '2020-11-08 12:03:42',
                        'updated_at' => '2020-11-08 12:03:42',
                    ),
                109 =>
                    array(
                        'id' => 835,
                        'lang' => 'en',
                        'lang_key' => 'Variant',
                        'lang_value' => 'Variant',
                        'created_at' => '2020-11-08 12:43:02',
                        'updated_at' => '2020-11-08 12:43:02',
                    ),
                110 =>
                    array(
                        'id' => 836,
                        'lang' => 'en',
                        'lang_key' => 'Variant Price',
                        'lang_value' => 'Variant Price',
                        'created_at' => '2020-11-08 12:43:03',
                        'updated_at' => '2020-11-08 12:43:03',
                    ),
                111 =>
                    array(
                        'id' => 837,
                        'lang' => 'en',
                        'lang_key' => 'SKU',
                        'lang_value' => 'SKU',
                        'created_at' => '2020-11-08 12:43:03',
                        'updated_at' => '2020-11-08 12:43:03',
                    ),
                112 =>
                    array(
                        'id' => 838,
                        'lang' => 'en',
                        'lang_key' => 'Key',
                        'lang_value' => 'Key',
                        'created_at' => '2020-11-08 14:35:09',
                        'updated_at' => '2020-11-08 14:35:09',
                    ),
                113 =>
                    array(
                        'id' => 839,
                        'lang' => 'en',
                        'lang_key' => 'Value',
                        'lang_value' => 'Value',
                        'created_at' => '2020-11-08 14:35:09',
                        'updated_at' => '2020-11-08 14:35:09',
                    ),
                114 =>
                    array(
                        'id' => 840,
                        'lang' => 'en',
                        'lang_key' => 'Copy Translations',
                        'lang_value' => 'Copy Translations',
                        'created_at' => '2020-11-08 14:35:10',
                        'updated_at' => '2020-11-08 14:35:10',
                    ),
                115 =>
                    array(
                        'id' => 841,
                        'lang' => 'en',
                        'lang_key' => 'All Pick-up Points',
                        'lang_value' => 'All Pick-up Points',
                        'created_at' => '2020-11-08 14:35:43',
                        'updated_at' => '2020-11-08 14:35:43',
                    ),
                116 =>
                    array(
                        'id' => 842,
                        'lang' => 'en',
                        'lang_key' => 'Add New Pick-up Point',
                        'lang_value' => 'Add New Pick-up Point',
                        'created_at' => '2020-11-08 14:35:43',
                        'updated_at' => '2020-11-08 14:35:43',
                    ),
                117 =>
                    array(
                        'id' => 843,
                        'lang' => 'en',
                        'lang_key' => 'Manager',
                        'lang_value' => 'Manager',
                        'created_at' => '2020-11-08 14:35:43',
                        'updated_at' => '2020-11-08 14:35:43',
                    ),
                118 =>
                    array(
                        'id' => 844,
                        'lang' => 'en',
                        'lang_key' => 'Location',
                        'lang_value' => 'Location',
                        'created_at' => '2020-11-08 14:35:43',
                        'updated_at' => '2020-11-08 14:35:43',
                    ),
                119 =>
                    array(
                        'id' => 845,
                        'lang' => 'en',
                        'lang_key' => 'Pickup Station Contact',
                        'lang_value' => 'Pickup Station Contact',
                        'created_at' => '2020-11-08 14:35:43',
                        'updated_at' => '2020-11-08 14:35:43',
                    ),
                120 =>
                    array(
                        'id' => 846,
                        'lang' => 'en',
                        'lang_key' => 'Open',
                        'lang_value' => 'Open',
                        'created_at' => '2020-11-08 14:35:43',
                        'updated_at' => '2020-11-08 14:35:43',
                    ),
                121 =>
                    array(
                        'id' => 847,
                        'lang' => 'en',
                        'lang_key' => 'POS Activation for Seller',
                        'lang_value' => 'POS Activation for Seller',
                        'created_at' => '2020-11-08 14:35:55',
                        'updated_at' => '2020-11-08 14:35:55',
                    ),
                122 =>
                    array(
                        'id' => 848,
                        'lang' => 'en',
                        'lang_key' => 'Order Completed Successfully.',
                        'lang_value' => 'Order Completed Successfully.',
                        'created_at' => '2020-11-08 14:36:02',
                        'updated_at' => '2020-11-08 14:36:02',
                    ),
                123 =>
                    array(
                        'id' => 849,
                        'lang' => 'en',
                        'lang_key' => 'Text Input',
                        'lang_value' => 'Text Input',
                        'created_at' => '2020-11-08 14:38:40',
                        'updated_at' => '2020-11-08 14:38:40',
                    ),
                124 =>
                    array(
                        'id' => 850,
                        'lang' => 'en',
                        'lang_key' => 'Select',
                        'lang_value' => 'Select',
                        'created_at' => '2020-11-08 14:38:40',
                        'updated_at' => '2020-11-08 14:38:40',
                    ),
                125 =>
                    array(
                        'id' => 851,
                        'lang' => 'en',
                        'lang_key' => 'Multiple Select',
                        'lang_value' => 'Multiple Select',
                        'created_at' => '2020-11-08 14:38:40',
                        'updated_at' => '2020-11-08 14:38:40',
                    ),
                126 =>
                    array(
                        'id' => 852,
                        'lang' => 'en',
                        'lang_key' => 'Radio',
                        'lang_value' => 'Radio',
                        'created_at' => '2020-11-08 14:38:40',
                        'updated_at' => '2020-11-08 14:38:40',
                    ),
                127 =>
                    array(
                        'id' => 853,
                        'lang' => 'en',
                        'lang_key' => 'File',
                        'lang_value' => 'File',
                        'created_at' => '2020-11-08 14:38:40',
                        'updated_at' => '2020-11-08 14:38:40',
                    ),
                128 =>
                    array(
                        'id' => 854,
                        'lang' => 'en',
                        'lang_key' => 'Email Address',
                        'lang_value' => 'Email Address',
                        'created_at' => '2020-11-08 14:39:32',
                        'updated_at' => '2020-11-08 14:39:32',
                    ),
                129 =>
                    array(
                        'id' => 855,
                        'lang' => 'en',
                        'lang_key' => 'Verification Info',
                        'lang_value' => 'Verification Info',
                        'created_at' => '2020-11-08 14:39:32',
                        'updated_at' => '2020-11-08 14:39:32',
                    ),
                130 =>
                    array(
                        'id' => 856,
                        'lang' => 'en',
                        'lang_key' => 'Approval',
                        'lang_value' => 'Approval',
                        'created_at' => '2020-11-08 14:39:32',
                        'updated_at' => '2020-11-08 14:39:32',
                    ),
                131 =>
                    array(
                        'id' => 857,
                        'lang' => 'en',
                        'lang_key' => 'Due Amount',
                        'lang_value' => 'Due Amount',
                        'created_at' => '2020-11-08 14:39:32',
                        'updated_at' => '2020-11-08 14:39:32',
                    ),
                132 =>
                    array(
                        'id' => 858,
                        'lang' => 'en',
                        'lang_key' => 'Show',
                        'lang_value' => 'Show',
                        'created_at' => '2020-11-08 14:39:32',
                        'updated_at' => '2020-11-08 14:39:32',
                    ),
                133 =>
                    array(
                        'id' => 859,
                        'lang' => 'en',
                        'lang_key' => 'Pay Now',
                        'lang_value' => 'Pay Now',
                        'created_at' => '2020-11-08 14:39:32',
                        'updated_at' => '2020-11-08 14:39:32',
                    ),
                134 =>
                    array(
                        'id' => 860,
                        'lang' => 'en',
                        'lang_key' => 'Affiliate User Verification',
                        'lang_value' => 'Affiliate User Verification',
                        'created_at' => '2020-11-08 14:40:01',
                        'updated_at' => '2020-11-08 14:40:01',
                    ),
                135 =>
                    array(
                        'id' => 861,
                        'lang' => 'en',
                        'lang_key' => 'Reject',
                        'lang_value' => 'Reject',
                        'created_at' => '2020-11-08 14:40:01',
                        'updated_at' => '2020-11-08 14:40:01',
                    ),
                136 =>
                    array(
                        'id' => 862,
                        'lang' => 'en',
                        'lang_key' => 'Accept',
                        'lang_value' => 'Accept',
                        'created_at' => '2020-11-08 14:40:01',
                        'updated_at' => '2020-11-08 14:40:01',
                    ),
                137 =>
                    array(
                        'id' => 863,
                        'lang' => 'en',
                        'lang_key' => 'Beauty, Health & Hair',
                        'lang_value' => 'Beauty, Health & Hair',
                        'created_at' => '2020-11-08 14:54:17',
                        'updated_at' => '2020-11-08 14:54:17',
                    ),
                138 =>
                    array(
                        'id' => 864,
                        'lang' => 'en',
                        'lang_key' => 'Comparison',
                        'lang_value' => 'Comparison',
                        'created_at' => '2020-11-08 14:54:33',
                        'updated_at' => '2020-11-08 14:54:33',
                    ),
                139 =>
                    array(
                        'id' => 865,
                        'lang' => 'en',
                        'lang_key' => 'Reset Compare List',
                        'lang_value' => 'Reset Compare List',
                        'created_at' => '2020-11-08 14:54:33',
                        'updated_at' => '2020-11-08 14:54:33',
                    ),
                140 =>
                    array(
                        'id' => 866,
                        'lang' => 'en',
                        'lang_key' => 'Your comparison list is empty',
                        'lang_value' => 'Your comparison list is empty',
                        'created_at' => '2020-11-08 14:54:33',
                        'updated_at' => '2020-11-08 14:54:33',
                    ),
                141 =>
                    array(
                        'id' => 867,
                        'lang' => 'en',
                        'lang_key' => 'Convert Point To Wallet',
                        'lang_value' => 'Convert Point To Wallet',
                        'created_at' => '2020-11-08 15:04:42',
                        'updated_at' => '2020-11-08 15:04:42',
                    ),
                142 =>
                    array(
                        'id' => 868,
                        'lang' => 'en',
                        'lang_key' => 'Note: You need to activate wallet option first before using club point addon.',
                        'lang_value' => 'Note: You need to activate wallet option first before using club point addon.',
                        'created_at' => '2020-11-08 15:04:43',
                        'updated_at' => '2020-11-08 15:04:43',
                    ),
                143 =>
                    array(
                        'id' => 869,
                        'lang' => 'en',
                        'lang_key' => 'Create an account.',
                        'lang_value' => 'Create an account.',
                        'created_at' => '2020-11-09 08:17:11',
                        'updated_at' => '2020-11-09 08:17:11',
                    ),
                144 =>
                    array(
                        'id' => 870,
                        'lang' => 'en',
                        'lang_key' => 'Use Email Instead',
                        'lang_value' => 'Use Email Instead',
                        'created_at' => '2020-11-09 08:17:11',
                        'updated_at' => '2020-11-09 08:17:11',
                    ),
                145 =>
                    array(
                        'id' => 871,
                        'lang' => 'en',
                        'lang_key' => 'By signing up you agree to our terms and conditions.',
                        'lang_value' => 'By signing up you agree to our terms and conditions.',
                        'created_at' => '2020-11-09 08:17:11',
                        'updated_at' => '2020-11-09 08:17:11',
                    ),
                146 =>
                    array(
                        'id' => 872,
                        'lang' => 'en',
                        'lang_key' => 'Create Account',
                        'lang_value' => 'Create Account',
                        'created_at' => '2020-11-09 08:17:11',
                        'updated_at' => '2020-11-09 08:17:11',
                    ),
                147 =>
                    array(
                        'id' => 873,
                        'lang' => 'en',
                        'lang_key' => 'Or Join With',
                        'lang_value' => 'Or Join With',
                        'created_at' => '2020-11-09 08:17:11',
                        'updated_at' => '2020-11-09 08:17:11',
                    ),
                148 =>
                    array(
                        'id' => 874,
                        'lang' => 'en',
                        'lang_key' => 'Already have an account?',
                        'lang_value' => 'Already have an account?',
                        'created_at' => '2020-11-09 08:17:11',
                        'updated_at' => '2020-11-09 08:17:11',
                    ),
                149 =>
                    array(
                        'id' => 875,
                        'lang' => 'en',
                        'lang_key' => 'Log In',
                        'lang_value' => 'Log In',
                        'created_at' => '2020-11-09 08:17:11',
                        'updated_at' => '2020-11-09 08:17:11',
                    ),
                150 =>
                    array(
                        'id' => 876,
                        'lang' => 'en',
                        'lang_key' => 'Computer & Accessories',
                        'lang_value' => 'Computer & Accessories',
                        'created_at' => '2020-11-09 09:52:05',
                        'updated_at' => '2020-11-09 09:52:05',
                    ),
                151 =>
                    array(
                        'id' => 878,
                        'lang' => 'en',
                        'lang_key' => 'Product(s)',
                        'lang_value' => 'Product(s)',
                        'created_at' => '2020-11-09 09:52:23',
                        'updated_at' => '2020-11-09 09:52:23',
                    ),
                152 =>
                    array(
                        'id' => 879,
                        'lang' => 'en',
                        'lang_key' => 'in your cart',
                        'lang_value' => 'in your cart',
                        'created_at' => '2020-11-09 09:52:23',
                        'updated_at' => '2020-11-09 09:52:23',
                    ),
                153 =>
                    array(
                        'id' => 880,
                        'lang' => 'en',
                        'lang_key' => 'in your wishlist',
                        'lang_value' => 'in your wishlist',
                        'created_at' => '2020-11-09 09:52:23',
                        'updated_at' => '2020-11-09 09:52:23',
                    ),
                154 =>
                    array(
                        'id' => 881,
                        'lang' => 'en',
                        'lang_key' => 'you ordered',
                        'lang_value' => 'you ordered',
                        'created_at' => '2020-11-09 09:52:24',
                        'updated_at' => '2020-11-09 09:52:24',
                    ),
                155 =>
                    array(
                        'id' => 882,
                        'lang' => 'en',
                        'lang_key' => 'Default Shipping Address',
                        'lang_value' => 'Default Shipping Address',
                        'created_at' => '2020-11-09 09:52:24',
                        'updated_at' => '2020-11-09 09:52:24',
                    ),
                156 =>
                    array(
                        'id' => 883,
                        'lang' => 'en',
                        'lang_key' => 'Sports & outdoor',
                        'lang_value' => 'Sports & outdoor',
                        'created_at' => '2020-11-09 09:53:32',
                        'updated_at' => '2020-11-09 09:53:32',
                    ),
                157 =>
                    array(
                        'id' => 884,
                        'lang' => 'en',
                        'lang_key' => 'Copied',
                        'lang_value' => 'Copied',
                        'created_at' => '2020-11-09 09:54:19',
                        'updated_at' => '2020-11-09 09:54:19',
                    ),
                158 =>
                    array(
                        'id' => 885,
                        'lang' => 'en',
                        'lang_key' => 'Copy the Promote Link',
                        'lang_value' => 'Copy the Promote Link',
                        'created_at' => '2020-11-09 09:54:19',
                        'updated_at' => '2020-11-09 09:54:19',
                    ),
                159 =>
                    array(
                        'id' => 886,
                        'lang' => 'en',
                        'lang_key' => 'Write a review',
                        'lang_value' => 'Write a review',
                        'created_at' => '2020-11-09 09:54:20',
                        'updated_at' => '2020-11-09 09:54:20',
                    ),
                160 =>
                    array(
                        'id' => 887,
                        'lang' => 'en',
                        'lang_key' => 'Your name',
                        'lang_value' => 'Your name',
                        'created_at' => '2020-11-09 09:54:20',
                        'updated_at' => '2020-11-09 09:54:20',
                    ),
                161 =>
                    array(
                        'id' => 888,
                        'lang' => 'en',
                        'lang_key' => 'Comment',
                        'lang_value' => 'Comment',
                        'created_at' => '2020-11-09 09:54:20',
                        'updated_at' => '2020-11-09 09:54:20',
                    ),
                162 =>
                    array(
                        'id' => 889,
                        'lang' => 'en',
                        'lang_key' => 'Your review',
                        'lang_value' => 'Your review',
                        'created_at' => '2020-11-09 09:54:20',
                        'updated_at' => '2020-11-09 09:54:20',
                    ),
                163 =>
                    array(
                        'id' => 890,
                        'lang' => 'en',
                        'lang_key' => 'Submit review',
                        'lang_value' => 'Submit review',
                        'created_at' => '2020-11-09 09:54:20',
                        'updated_at' => '2020-11-09 09:54:20',
                    ),
                164 =>
                    array(
                        'id' => 891,
                        'lang' => 'en',
                        'lang_key' => 'Claire Willis',
                        'lang_value' => 'Claire Willis',
                        'created_at' => '2020-11-09 10:05:00',
                        'updated_at' => '2020-11-09 10:05:00',
                    ),
                165 =>
                    array(
                        'id' => 892,
                        'lang' => 'en',
                        'lang_key' => 'Germaine Greene',
                        'lang_value' => 'Germaine Greene',
                        'created_at' => '2020-11-09 10:05:00',
                        'updated_at' => '2020-11-09 10:05:00',
                    ),
                166 =>
                    array(
                        'id' => 893,
                        'lang' => 'en',
                        'lang_key' => 'Product File',
                        'lang_value' => 'Product File',
                        'created_at' => '2020-11-09 10:07:08',
                        'updated_at' => '2020-11-09 10:07:08',
                    ),
                167 =>
                    array(
                        'id' => 894,
                        'lang' => 'en',
                        'lang_key' => 'Choose file',
                        'lang_value' => 'Choose file',
                        'created_at' => '2020-11-09 10:07:08',
                        'updated_at' => '2020-11-09 10:07:08',
                    ),
                168 =>
                    array(
                        'id' => 895,
                        'lang' => 'en',
                        'lang_key' => 'Type to add a tag',
                        'lang_value' => 'Type to add a tag',
                        'created_at' => '2020-11-09 10:07:08',
                        'updated_at' => '2020-11-09 10:07:08',
                    ),
                169 =>
                    array(
                        'id' => 896,
                        'lang' => 'en',
                        'lang_key' => 'Images',
                        'lang_value' => 'Images',
                        'created_at' => '2020-11-09 10:07:08',
                        'updated_at' => '2020-11-09 10:07:08',
                    ),
                170 =>
                    array(
                        'id' => 897,
                        'lang' => 'en',
                        'lang_key' => 'Main Images',
                        'lang_value' => 'Main Images',
                        'created_at' => '2020-11-09 10:07:08',
                        'updated_at' => '2020-11-09 10:07:08',
                    ),
                171 =>
                    array(
                        'id' => 898,
                        'lang' => 'en',
                        'lang_key' => 'Meta Tags',
                        'lang_value' => 'Meta Tags',
                        'created_at' => '2020-11-09 10:07:08',
                        'updated_at' => '2020-11-09 10:07:08',
                    ),
                172 =>
                    array(
                        'id' => 899,
                        'lang' => 'en',
                        'lang_key' => 'Digital Product has been inserted successfully',
                        'lang_value' => 'Digital Product has been inserted successfully',
                        'created_at' => '2020-11-09 10:14:25',
                        'updated_at' => '2020-11-09 10:14:25',
                    ),
                173 =>
                    array(
                        'id' => 900,
                        'lang' => 'en',
                        'lang_key' => 'Edit Digital Product',
                        'lang_value' => 'Edit Digital Product',
                        'created_at' => '2020-11-09 10:14:34',
                        'updated_at' => '2020-11-09 10:14:34',
                    ),
                174 =>
                    array(
                        'id' => 901,
                        'lang' => 'en',
                        'lang_key' => 'Select an option',
                        'lang_value' => 'Select an option',
                        'created_at' => '2020-11-09 10:14:34',
                        'updated_at' => '2020-11-09 10:14:34',
                    ),
                175 =>
                    array(
                        'id' => 902,
                        'lang' => 'en',
                        'lang_key' => 'tax',
                        'lang_value' => 'tax',
                        'created_at' => '2020-11-09 10:14:35',
                        'updated_at' => '2020-11-09 10:14:35',
                    ),
                176 =>
                    array(
                        'id' => 903,
                        'lang' => 'en',
                        'lang_key' => 'Any question about this product?',
                        'lang_value' => 'Any question about this product?',
                        'created_at' => '2020-11-09 10:15:11',
                        'updated_at' => '2020-11-09 10:15:11',
                    ),
                177 =>
                    array(
                        'id' => 904,
                        'lang' => 'en',
                        'lang_key' => 'Sign in',
                        'lang_value' => 'Sign in',
                        'created_at' => '2020-11-09 10:15:11',
                        'updated_at' => '2020-11-09 10:15:11',
                    ),
                178 =>
                    array(
                        'id' => 905,
                        'lang' => 'en',
                        'lang_key' => 'Login with Google',
                        'lang_value' => 'Login with Google',
                        'created_at' => '2020-11-09 10:15:11',
                        'updated_at' => '2020-11-09 10:15:11',
                    ),
                179 =>
                    array(
                        'id' => 906,
                        'lang' => 'en',
                        'lang_key' => 'Login with Facebook',
                        'lang_value' => 'Login with Facebook',
                        'created_at' => '2020-11-09 10:15:11',
                        'updated_at' => '2020-11-09 10:15:11',
                    ),
                180 =>
                    array(
                        'id' => 907,
                        'lang' => 'en',
                        'lang_key' => 'Login with Twitter',
                        'lang_value' => 'Login with Twitter',
                        'created_at' => '2020-11-09 10:15:11',
                        'updated_at' => '2020-11-09 10:15:11',
                    ),
                181 =>
                    array(
                        'id' => 908,
                        'lang' => 'en',
                        'lang_key' => 'Click to show phone number',
                        'lang_value' => 'Click to show phone number',
                        'created_at' => '2020-11-09 10:15:51',
                        'updated_at' => '2020-11-09 10:15:51',
                    ),
                182 =>
                    array(
                        'id' => 909,
                        'lang' => 'en',
                        'lang_key' => 'Other Ads of',
                        'lang_value' => 'Other Ads of',
                        'created_at' => '2020-11-09 10:15:52',
                        'updated_at' => '2020-11-09 10:15:52',
                    ),
                183 =>
                    array(
                        'id' => 910,
                        'lang' => 'en',
                        'lang_key' => 'Store Home',
                        'lang_value' => 'Store Home',
                        'created_at' => '2020-11-09 10:54:23',
                        'updated_at' => '2020-11-09 10:54:23',
                    ),
                184 =>
                    array(
                        'id' => 911,
                        'lang' => 'en',
                        'lang_key' => 'Top Selling',
                        'lang_value' => 'Top Selling',
                        'created_at' => '2020-11-09 10:54:23',
                        'updated_at' => '2020-11-09 10:54:23',
                    ),
                185 =>
                    array(
                        'id' => 912,
                        'lang' => 'en',
                        'lang_key' => 'Shop Settings',
                        'lang_value' => 'Shop Settings',
                        'created_at' => '2020-11-09 10:55:38',
                        'updated_at' => '2020-11-09 10:55:38',
                    ),
                186 =>
                    array(
                        'id' => 913,
                        'lang' => 'en',
                        'lang_key' => 'Visit Shop',
                        'lang_value' => 'Visit Shop',
                        'created_at' => '2020-11-09 10:55:38',
                        'updated_at' => '2020-11-09 10:55:38',
                    ),
                187 =>
                    array(
                        'id' => 914,
                        'lang' => 'en',
                        'lang_key' => 'Pickup Points',
                        'lang_value' => 'Pickup Points',
                        'created_at' => '2020-11-09 10:55:38',
                        'updated_at' => '2020-11-09 10:55:38',
                    ),
                188 =>
                    array(
                        'id' => 915,
                        'lang' => 'en',
                        'lang_key' => 'Select Pickup Point',
                        'lang_value' => 'Select Pickup Point',
                        'created_at' => '2020-11-09 10:55:38',
                        'updated_at' => '2020-11-09 10:55:38',
                    ),
                189 =>
                    array(
                        'id' => 916,
                        'lang' => 'en',
                        'lang_key' => 'Slider Settings',
                        'lang_value' => 'Slider Settings',
                        'created_at' => '2020-11-09 10:55:39',
                        'updated_at' => '2020-11-09 10:55:39',
                    ),
                190 =>
                    array(
                        'id' => 917,
                        'lang' => 'en',
                        'lang_key' => 'Social Media Link',
                        'lang_value' => 'Social Media Link',
                        'created_at' => '2020-11-09 10:55:39',
                        'updated_at' => '2020-11-09 10:55:39',
                    ),
                191 =>
                    array(
                        'id' => 918,
                        'lang' => 'en',
                        'lang_key' => 'Facebook',
                        'lang_value' => 'Facebook',
                        'created_at' => '2020-11-09 10:55:39',
                        'updated_at' => '2020-11-09 10:55:39',
                    ),
                192 =>
                    array(
                        'id' => 919,
                        'lang' => 'en',
                        'lang_key' => 'Twitter',
                        'lang_value' => 'Twitter',
                        'created_at' => '2020-11-09 10:55:39',
                        'updated_at' => '2020-11-09 10:55:39',
                    ),
                193 =>
                    array(
                        'id' => 920,
                        'lang' => 'en',
                        'lang_key' => 'Google',
                        'lang_value' => 'Google',
                        'created_at' => '2020-11-09 10:55:39',
                        'updated_at' => '2020-11-09 10:55:39',
                    ),
                194 =>
                    array(
                        'id' => 921,
                        'lang' => 'en',
                        'lang_key' => 'New Arrival Products',
                        'lang_value' => 'New Arrival Products',
                        'created_at' => '2020-11-09 10:56:26',
                        'updated_at' => '2020-11-09 10:56:26',
                    ),
                195 =>
                    array(
                        'id' => 922,
                        'lang' => 'en',
                        'lang_key' => 'Check Your Order Status',
                        'lang_value' => 'Check Your Order Status',
                        'created_at' => '2020-11-09 11:23:32',
                        'updated_at' => '2020-11-09 11:23:32',
                    ),
                196 =>
                    array(
                        'id' => 923,
                        'lang' => 'en',
                        'lang_key' => 'Shipping method',
                        'lang_value' => 'Shipping method',
                        'created_at' => '2020-11-09 11:27:40',
                        'updated_at' => '2020-11-09 11:27:40',
                    ),
                197 =>
                    array(
                        'id' => 924,
                        'lang' => 'en',
                        'lang_key' => 'Shipped By',
                        'lang_value' => 'Shipped By',
                        'created_at' => '2020-11-09 11:27:41',
                        'updated_at' => '2020-11-09 11:27:41',
                    ),
                198 =>
                    array(
                        'id' => 925,
                        'lang' => 'en',
                        'lang_key' => 'Image',
                        'lang_value' => 'Image',
                        'created_at' => '2020-11-09 11:29:37',
                        'updated_at' => '2020-11-09 11:29:37',
                    ),
                199 =>
                    array(
                        'id' => 926,
                        'lang' => 'en',
                        'lang_key' => 'Sub Sub Category',
                        'lang_value' => 'Sub Sub Category',
                        'created_at' => '2020-11-09 11:29:37',
                        'updated_at' => '2020-11-09 11:29:37',
                    ),
                200 =>
                    array(
                        'id' => 927,
                        'lang' => 'en',
                        'lang_key' => 'Inhouse Products',
                        'lang_value' => 'Inhouse Products',
                        'created_at' => '2020-11-09 12:22:32',
                        'updated_at' => '2020-11-09 12:22:32',
                    ),
                201 =>
                    array(
                        'id' => 928,
                        'lang' => 'en',
                        'lang_key' => 'Forgot Password?',
                        'lang_value' => 'Forgot Password?',
                        'created_at' => '2020-11-09 12:33:21',
                        'updated_at' => '2020-11-09 12:33:21',
                    ),
                202 =>
                    array(
                        'id' => 929,
                        'lang' => 'en',
                        'lang_key' => 'Enter your email address to recover your password.',
                        'lang_value' => 'Enter your email address to recover your password.',
                        'created_at' => '2020-11-09 12:33:21',
                        'updated_at' => '2020-11-09 12:33:21',
                    ),
                203 =>
                    array(
                        'id' => 930,
                        'lang' => 'en',
                        'lang_key' => 'Email or Phone',
                        'lang_value' => 'Email or Phone',
                        'created_at' => '2020-11-09 12:33:21',
                        'updated_at' => '2020-11-09 12:33:21',
                    ),
                204 =>
                    array(
                        'id' => 931,
                        'lang' => 'en',
                        'lang_key' => 'Send Password Reset Link',
                        'lang_value' => 'Send Password Reset Link',
                        'created_at' => '2020-11-09 12:33:21',
                        'updated_at' => '2020-11-09 12:33:21',
                    ),
                205 =>
                    array(
                        'id' => 932,
                        'lang' => 'en',
                        'lang_key' => 'Back to Login',
                        'lang_value' => 'Back to Login',
                        'created_at' => '2020-11-09 12:33:21',
                        'updated_at' => '2020-11-09 12:33:21',
                    ),
                206 =>
                    array(
                        'id' => 933,
                        'lang' => 'en',
                        'lang_key' => 'index',
                        'lang_value' => 'index',
                        'created_at' => '2020-11-09 12:35:29',
                        'updated_at' => '2020-11-09 12:35:29',
                    ),
                207 =>
                    array(
                        'id' => 934,
                        'lang' => 'en',
                        'lang_key' => 'Download Your Product',
                        'lang_value' => 'Download Your Product',
                        'created_at' => '2020-11-09 12:35:30',
                        'updated_at' => '2020-11-09 12:35:30',
                    ),
                208 =>
                    array(
                        'id' => 935,
                        'lang' => 'en',
                        'lang_key' => 'Option',
                        'lang_value' => 'Option',
                        'created_at' => '2020-11-09 12:35:30',
                        'updated_at' => '2020-11-09 12:35:30',
                    ),
                209 =>
                    array(
                        'id' => 936,
                        'lang' => 'en',
                        'lang_key' => 'Applied Refund Request',
                        'lang_value' => 'Applied Refund Request',
                        'created_at' => '2020-11-09 12:35:39',
                        'updated_at' => '2020-11-09 12:35:39',
                    ),
                210 =>
                    array(
                        'id' => 937,
                        'lang' => 'en',
                        'lang_key' => 'Item has been renoved from wishlist',
                        'lang_value' => 'Item has been renoved from wishlist',
                        'created_at' => '2020-11-09 12:36:04',
                        'updated_at' => '2020-11-09 12:36:04',
                    ),
                211 =>
                    array(
                        'id' => 938,
                        'lang' => 'en',
                        'lang_key' => 'Bulk Products Upload',
                        'lang_value' => 'Bulk Products Upload',
                        'created_at' => '2020-11-09 12:39:24',
                        'updated_at' => '2020-11-09 12:39:24',
                    ),
                212 =>
                    array(
                        'id' => 939,
                        'lang' => 'en',
                        'lang_key' => 'Upload CSV',
                        'lang_value' => 'Upload CSV',
                        'created_at' => '2020-11-09 12:39:25',
                        'updated_at' => '2020-11-09 12:39:25',
                    ),
                213 =>
                    array(
                        'id' => 940,
                        'lang' => 'en',
                        'lang_key' => 'Create a Ticket',
                        'lang_value' => 'Create a Ticket',
                        'created_at' => '2020-11-09 12:40:25',
                        'updated_at' => '2020-11-09 12:40:25',
                    ),
                214 =>
                    array(
                        'id' => 941,
                        'lang' => 'en',
                        'lang_key' => 'Tickets',
                        'lang_value' => 'Tickets',
                        'created_at' => '2020-11-09 12:40:25',
                        'updated_at' => '2020-11-09 12:40:25',
                    ),
                215 =>
                    array(
                        'id' => 942,
                        'lang' => 'en',
                        'lang_key' => 'Ticket ID',
                        'lang_value' => 'Ticket ID',
                        'created_at' => '2020-11-09 12:40:25',
                        'updated_at' => '2020-11-09 12:40:25',
                    ),
                216 =>
                    array(
                        'id' => 943,
                        'lang' => 'en',
                        'lang_key' => 'Sending Date',
                        'lang_value' => 'Sending Date',
                        'created_at' => '2020-11-09 12:40:25',
                        'updated_at' => '2020-11-09 12:40:25',
                    ),
                217 =>
                    array(
                        'id' => 944,
                        'lang' => 'en',
                        'lang_key' => 'Subject',
                        'lang_value' => 'Subject',
                        'created_at' => '2020-11-09 12:40:25',
                        'updated_at' => '2020-11-09 12:40:25',
                    ),
                218 =>
                    array(
                        'id' => 945,
                        'lang' => 'en',
                        'lang_key' => 'View Details',
                        'lang_value' => 'View Details',
                        'created_at' => '2020-11-09 12:40:25',
                        'updated_at' => '2020-11-09 12:40:25',
                    ),
                219 =>
                    array(
                        'id' => 946,
                        'lang' => 'en',
                        'lang_key' => 'Provide a detailed description',
                        'lang_value' => 'Provide a detailed description',
                        'created_at' => '2020-11-09 12:40:26',
                        'updated_at' => '2020-11-09 12:40:26',
                    ),
                220 =>
                    array(
                        'id' => 947,
                        'lang' => 'en',
                        'lang_key' => 'Type your reply',
                        'lang_value' => 'Type your reply',
                        'created_at' => '2020-11-09 12:40:26',
                        'updated_at' => '2020-11-09 12:40:26',
                    ),
                221 =>
                    array(
                        'id' => 948,
                        'lang' => 'en',
                        'lang_key' => 'Send Ticket',
                        'lang_value' => 'Send Ticket',
                        'created_at' => '2020-11-09 12:40:26',
                        'updated_at' => '2020-11-09 12:40:26',
                    ),
                222 =>
                    array(
                        'id' => 949,
                        'lang' => 'en',
                        'lang_key' => 'Load More',
                        'lang_value' => 'Load More',
                        'created_at' => '2020-11-09 12:40:57',
                        'updated_at' => '2020-11-09 12:40:57',
                    ),
                223 =>
                    array(
                        'id' => 950,
                        'lang' => 'en',
                        'lang_key' => 'Jewelry & Watches',
                        'lang_value' => 'Jewelry & Watches',
                        'created_at' => '2020-11-09 12:47:38',
                        'updated_at' => '2020-11-09 12:47:38',
                    ),
                224 =>
                    array(
                        'id' => 951,
                        'lang' => 'en',
                        'lang_key' => 'Filters',
                        'lang_value' => 'Filters',
                        'created_at' => '2020-11-09 12:53:54',
                        'updated_at' => '2020-11-09 12:53:54',
                    ),
                225 =>
                    array(
                        'id' => 952,
                        'lang' => 'en',
                        'lang_key' => 'Contact address',
                        'lang_value' => 'Contact address',
                        'created_at' => '2020-11-09 12:58:46',
                        'updated_at' => '2020-11-09 12:58:46',
                    ),
                226 =>
                    array(
                        'id' => 953,
                        'lang' => 'en',
                        'lang_key' => 'Contact phone',
                        'lang_value' => 'Contact phone',
                        'created_at' => '2020-11-09 12:58:47',
                        'updated_at' => '2020-11-09 12:58:47',
                    ),
                227 =>
                    array(
                        'id' => 954,
                        'lang' => 'en',
                        'lang_key' => 'Contact email',
                        'lang_value' => 'Contact email',
                        'created_at' => '2020-11-09 12:58:47',
                        'updated_at' => '2020-11-09 12:58:47',
                    ),
                228 =>
                    array(
                        'id' => 955,
                        'lang' => 'en',
                        'lang_key' => 'Filter by',
                        'lang_value' => 'Filter by',
                        'created_at' => '2020-11-09 13:00:03',
                        'updated_at' => '2020-11-09 13:00:03',
                    ),
                229 =>
                    array(
                        'id' => 956,
                        'lang' => 'en',
                        'lang_key' => 'Condition',
                        'lang_value' => 'Condition',
                        'created_at' => '2020-11-09 13:56:13',
                        'updated_at' => '2020-11-09 13:56:13',
                    ),
                230 =>
                    array(
                        'id' => 957,
                        'lang' => 'en',
                        'lang_key' => 'All Type',
                        'lang_value' => 'All Type',
                        'created_at' => '2020-11-09 13:56:13',
                        'updated_at' => '2020-11-09 13:56:13',
                    ),
                231 =>
                    array(
                        'id' => 960,
                        'lang' => 'en',
                        'lang_key' => 'Pay with wallet',
                        'lang_value' => 'Pay with wallet',
                        'created_at' => '2020-11-09 14:56:34',
                        'updated_at' => '2020-11-09 14:56:34',
                    ),
                232 =>
                    array(
                        'id' => 961,
                        'lang' => 'en',
                        'lang_key' => 'Select variation',
                        'lang_value' => 'Select variation',
                        'created_at' => '2020-11-10 09:54:29',
                        'updated_at' => '2020-11-10 09:54:29',
                    ),
                233 =>
                    array(
                        'id' => 962,
                        'lang' => 'en',
                        'lang_key' => 'No Product Added',
                        'lang_value' => 'No Product Added',
                        'created_at' => '2020-11-10 10:07:53',
                        'updated_at' => '2020-11-10 10:07:53',
                    ),
                234 =>
                    array(
                        'id' => 963,
                        'lang' => 'en',
                        'lang_key' => 'Status has been updated successfully',
                        'lang_value' => 'Status has been updated successfully',
                        'created_at' => '2020-11-10 10:41:23',
                        'updated_at' => '2020-11-10 10:41:23',
                    ),
                235 =>
                    array(
                        'id' => 964,
                        'lang' => 'en',
                        'lang_key' => 'All Seller Packages',
                        'lang_value' => 'All Seller Packages',
                        'created_at' => '2020-11-10 11:14:10',
                        'updated_at' => '2020-11-10 11:14:10',
                    ),
                236 =>
                    array(
                        'id' => 965,
                        'lang' => 'en',
                        'lang_key' => 'Add New Package',
                        'lang_value' => 'Add New Package',
                        'created_at' => '2020-11-10 11:14:10',
                        'updated_at' => '2020-11-10 11:14:10',
                    ),
                237 =>
                    array(
                        'id' => 966,
                        'lang' => 'en',
                        'lang_key' => 'Package Logo',
                        'lang_value' => 'Package Logo',
                        'created_at' => '2020-11-10 11:14:10',
                        'updated_at' => '2020-11-10 11:14:10',
                    ),
                238 =>
                    array(
                        'id' => 967,
                        'lang' => 'en',
                        'lang_key' => 'days',
                        'lang_value' => 'days',
                        'created_at' => '2020-11-10 11:14:10',
                        'updated_at' => '2020-11-10 11:14:10',
                    ),
                239 =>
                    array(
                        'id' => 968,
                        'lang' => 'en',
                        'lang_key' => 'Create New Seller Package',
                        'lang_value' => 'Create New Seller Package',
                        'created_at' => '2020-11-10 11:14:31',
                        'updated_at' => '2020-11-10 11:14:31',
                    ),
                240 =>
                    array(
                        'id' => 969,
                        'lang' => 'en',
                        'lang_key' => 'Package Name',
                        'lang_value' => 'Package Name',
                        'created_at' => '2020-11-10 11:14:31',
                        'updated_at' => '2020-11-10 11:14:31',
                    ),
                241 =>
                    array(
                        'id' => 970,
                        'lang' => 'en',
                        'lang_key' => 'Duration',
                        'lang_value' => 'Duration',
                        'created_at' => '2020-11-10 11:14:31',
                        'updated_at' => '2020-11-10 11:14:31',
                    ),
                242 =>
                    array(
                        'id' => 971,
                        'lang' => 'en',
                        'lang_key' => 'Validity in number of days',
                        'lang_value' => 'Validity in number of days',
                        'created_at' => '2020-11-10 11:14:31',
                        'updated_at' => '2020-11-10 11:14:31',
                    ),
                243 =>
                    array(
                        'id' => 972,
                        'lang' => 'en',
                        'lang_key' => 'Update Package Information',
                        'lang_value' => 'Update Package Information',
                        'created_at' => '2020-11-10 11:14:59',
                        'updated_at' => '2020-11-10 11:14:59',
                    ),
                244 =>
                    array(
                        'id' => 973,
                        'lang' => 'en',
                        'lang_key' => 'Package has been inserted successfully',
                        'lang_value' => 'Package has been inserted successfully',
                        'created_at' => '2020-11-10 11:15:14',
                        'updated_at' => '2020-11-10 11:15:14',
                    ),
                245 =>
                    array(
                        'id' => 974,
                        'lang' => 'en',
                        'lang_key' => 'Refund Request',
                        'lang_value' => 'Refund Request',
                        'created_at' => '2020-11-10 11:17:25',
                        'updated_at' => '2020-11-10 11:17:25',
                    ),
                246 =>
                    array(
                        'id' => 975,
                        'lang' => 'en',
                        'lang_key' => 'Reason',
                        'lang_value' => 'Reason',
                        'created_at' => '2020-11-10 11:17:25',
                        'updated_at' => '2020-11-10 11:17:25',
                    ),
                247 =>
                    array(
                        'id' => 976,
                        'lang' => 'en',
                        'lang_key' => 'Label',
                        'lang_value' => 'Label',
                        'created_at' => '2020-11-10 11:20:13',
                        'updated_at' => '2020-11-10 11:20:13',
                    ),
                248 =>
                    array(
                        'id' => 977,
                        'lang' => 'en',
                        'lang_key' => 'Select Label',
                        'lang_value' => 'Select Label',
                        'created_at' => '2020-11-10 11:20:13',
                        'updated_at' => '2020-11-10 11:20:13',
                    ),
                249 =>
                    array(
                        'id' => 978,
                        'lang' => 'en',
                        'lang_key' => 'Multiple Select Label',
                        'lang_value' => 'Multiple Select Label',
                        'created_at' => '2020-11-10 11:20:13',
                        'updated_at' => '2020-11-10 11:20:13',
                    ),
                250 =>
                    array(
                        'id' => 979,
                        'lang' => 'en',
                        'lang_key' => 'Radio Label',
                        'lang_value' => 'Radio Label',
                        'created_at' => '2020-11-10 11:20:13',
                        'updated_at' => '2020-11-10 11:20:13',
                    ),
                251 =>
                    array(
                        'id' => 980,
                        'lang' => 'en',
                        'lang_key' => 'Pickup Point Orders',
                        'lang_value' => 'Pickup Point Orders',
                        'created_at' => '2020-11-10 11:25:40',
                        'updated_at' => '2020-11-10 11:25:40',
                    ),
                252 =>
                    array(
                        'id' => 981,
                        'lang' => 'en',
                        'lang_key' => 'View',
                        'lang_value' => 'View',
                        'created_at' => '2020-11-10 11:25:40',
                        'updated_at' => '2020-11-10 11:25:40',
                    ),
                253 =>
                    array(
                        'id' => 982,
                        'lang' => 'en',
                        'lang_key' => 'Order #',
                        'lang_value' => 'Order #',
                        'created_at' => '2020-11-10 11:25:48',
                        'updated_at' => '2020-11-10 11:25:48',
                    ),
                254 =>
                    array(
                        'id' => 983,
                        'lang' => 'en',
                        'lang_key' => 'Order Status',
                        'lang_value' => 'Order Status',
                        'created_at' => '2020-11-10 11:25:48',
                        'updated_at' => '2020-11-10 11:25:48',
                    ),
                255 =>
                    array(
                        'id' => 984,
                        'lang' => 'en',
                        'lang_key' => 'Total amount',
                        'lang_value' => 'Total amount',
                        'created_at' => '2020-11-10 11:25:48',
                        'updated_at' => '2020-11-10 11:25:48',
                    ),
                256 =>
                    array(
                        'id' => 986,
                        'lang' => 'en',
                        'lang_key' => 'TOTAL',
                        'lang_value' => 'TOTAL',
                        'created_at' => '2020-11-10 11:25:49',
                        'updated_at' => '2020-11-10 11:25:49',
                    ),
                257 =>
                    array(
                        'id' => 987,
                        'lang' => 'en',
                        'lang_key' => 'Delivery status has been updated',
                        'lang_value' => 'Delivery status has been updated',
                        'created_at' => '2020-11-10 11:25:49',
                        'updated_at' => '2020-11-10 11:25:49',
                    ),
                258 =>
                    array(
                        'id' => 988,
                        'lang' => 'en',
                        'lang_key' => 'Payment status has been updated',
                        'lang_value' => 'Payment status has been updated',
                        'created_at' => '2020-11-10 11:25:49',
                        'updated_at' => '2020-11-10 11:25:49',
                    ),
                259 =>
                    array(
                        'id' => 989,
                        'lang' => 'en',
                        'lang_key' => 'INVOICE',
                        'lang_value' => 'INVOICE',
                        'created_at' => '2020-11-10 11:25:58',
                        'updated_at' => '2020-11-10 11:25:58',
                    ),
                260 =>
                    array(
                        'id' => 990,
                        'lang' => 'en',
                        'lang_key' => 'Set Refund Time',
                        'lang_value' => 'Set Refund Time',
                        'created_at' => '2020-11-10 11:34:04',
                        'updated_at' => '2020-11-10 11:34:04',
                    ),
                261 =>
                    array(
                        'id' => 991,
                        'lang' => 'en',
                        'lang_key' => 'Set Time for sending Refund Request',
                        'lang_value' => 'Set Time for sending Refund Request',
                        'created_at' => '2020-11-10 11:34:04',
                        'updated_at' => '2020-11-10 11:34:04',
                    ),
                262 =>
                    array(
                        'id' => 992,
                        'lang' => 'en',
                        'lang_key' => 'Set Refund Sticker',
                        'lang_value' => 'Set Refund Sticker',
                        'created_at' => '2020-11-10 11:34:05',
                        'updated_at' => '2020-11-10 11:34:05',
                    ),
                263 =>
                    array(
                        'id' => 993,
                        'lang' => 'en',
                        'lang_key' => 'Sticker',
                        'lang_value' => 'Sticker',
                        'created_at' => '2020-11-10 11:34:05',
                        'updated_at' => '2020-11-10 11:34:05',
                    ),
                264 =>
                    array(
                        'id' => 994,
                        'lang' => 'en',
                        'lang_key' => 'Refund Request All',
                        'lang_value' => 'Refund Request All',
                        'created_at' => '2020-11-10 11:34:12',
                        'updated_at' => '2020-11-10 11:34:12',
                    ),
                265 =>
                    array(
                        'id' => 995,
                        'lang' => 'en',
                        'lang_key' => 'Order Id',
                        'lang_value' => 'Order Id',
                        'created_at' => '2020-11-10 11:34:12',
                        'updated_at' => '2020-11-10 11:34:12',
                    ),
                266 =>
                    array(
                        'id' => 996,
                        'lang' => 'en',
                        'lang_key' => 'Seller Approval',
                        'lang_value' => 'Seller Approval',
                        'created_at' => '2020-11-10 11:34:12',
                        'updated_at' => '2020-11-10 11:34:12',
                    ),
                267 =>
                    array(
                        'id' => 997,
                        'lang' => 'en',
                        'lang_key' => 'Admin Approval',
                        'lang_value' => 'Admin Approval',
                        'created_at' => '2020-11-10 11:34:12',
                        'updated_at' => '2020-11-10 11:34:12',
                    ),
                268 =>
                    array(
                        'id' => 998,
                        'lang' => 'en',
                        'lang_key' => 'Refund Status',
                        'lang_value' => 'Refund Status',
                        'created_at' => '2020-11-10 11:34:12',
                        'updated_at' => '2020-11-10 11:34:12',
                    ),
                269 =>
                    array(
                        'id' => 1000,
                        'lang' => 'en',
                        'lang_key' => 'No Refund',
                        'lang_value' => 'No Refund',
                        'created_at' => '2020-11-10 11:35:27',
                        'updated_at' => '2020-11-10 11:35:27',
                    ),
                270 =>
                    array(
                        'id' => 1001,
                        'lang' => 'en',
                        'lang_key' => 'Status updated successfully',
                        'lang_value' => 'Status updated successfully',
                        'created_at' => '2020-11-10 11:54:20',
                        'updated_at' => '2020-11-10 11:54:20',
                    ),
                271 =>
                    array(
                        'id' => 1002,
                        'lang' => 'en',
                        'lang_key' => 'User Search Report',
                        'lang_value' => 'User Search Report',
                        'created_at' => '2020-11-11 08:43:24',
                        'updated_at' => '2020-11-11 08:43:24',
                    ),
                272 =>
                    array(
                        'id' => 1003,
                        'lang' => 'en',
                        'lang_key' => 'Search By',
                        'lang_value' => 'Search By',
                        'created_at' => '2020-11-11 08:43:24',
                        'updated_at' => '2020-11-11 08:43:24',
                    ),
                273 =>
                    array(
                        'id' => 1004,
                        'lang' => 'en',
                        'lang_key' => 'Number searches',
                        'lang_value' => 'Number searches',
                        'created_at' => '2020-11-11 08:43:24',
                        'updated_at' => '2020-11-11 08:43:24',
                    ),
                274 =>
                    array(
                        'id' => 1005,
                        'lang' => 'en',
                        'lang_key' => 'Sender',
                        'lang_value' => 'Sender',
                        'created_at' => '2020-11-11 08:51:49',
                        'updated_at' => '2020-11-11 08:51:49',
                    ),
                275 =>
                    array(
                        'id' => 1006,
                        'lang' => 'en',
                        'lang_key' => 'Receiver',
                        'lang_value' => 'Receiver',
                        'created_at' => '2020-11-11 08:51:49',
                        'updated_at' => '2020-11-11 08:51:49',
                    ),
                276 =>
                    array(
                        'id' => 1007,
                        'lang' => 'en',
                        'lang_key' => 'Verification form updated successfully',
                        'lang_value' => 'Verification form updated successfully',
                        'created_at' => '2020-11-11 08:53:29',
                        'updated_at' => '2020-11-11 08:53:29',
                    ),
                277 =>
                    array(
                        'id' => 1008,
                        'lang' => 'en',
                        'lang_key' => 'Invalid email or password',
                        'lang_value' => 'Invalid email or password',
                        'created_at' => '2020-11-11 09:07:49',
                        'updated_at' => '2020-11-11 09:07:49',
                    ),
                278 =>
                    array(
                        'id' => 1009,
                        'lang' => 'en',
                        'lang_key' => 'All Coupons',
                        'lang_value' => 'All Coupons',
                        'created_at' => '2020-11-11 09:14:04',
                        'updated_at' => '2020-11-11 09:14:04',
                    ),
                279 =>
                    array(
                        'id' => 1010,
                        'lang' => 'en',
                        'lang_key' => 'Add New Coupon',
                        'lang_value' => 'Add New Coupon',
                        'created_at' => '2020-11-11 09:14:04',
                        'updated_at' => '2020-11-11 09:14:04',
                    ),
                280 =>
                    array(
                        'id' => 1011,
                        'lang' => 'en',
                        'lang_key' => 'Coupon Information',
                        'lang_value' => 'Coupon Information',
                        'created_at' => '2020-11-11 09:14:04',
                        'updated_at' => '2020-11-11 09:14:04',
                    ),
                281 =>
                    array(
                        'id' => 1012,
                        'lang' => 'en',
                        'lang_key' => 'Start Date',
                        'lang_value' => 'Start Date',
                        'created_at' => '2020-11-11 09:14:04',
                        'updated_at' => '2020-11-11 09:14:04',
                    ),
                282 =>
                    array(
                        'id' => 1013,
                        'lang' => 'en',
                        'lang_key' => 'End Date',
                        'lang_value' => 'End Date',
                        'created_at' => '2020-11-11 09:14:05',
                        'updated_at' => '2020-11-11 09:14:05',
                    ),
                283 =>
                    array(
                        'id' => 1014,
                        'lang' => 'en',
                        'lang_key' => 'Product Base',
                        'lang_value' => 'Product Base',
                        'created_at' => '2020-11-11 09:14:05',
                        'updated_at' => '2020-11-11 09:14:05',
                    ),
                284 =>
                    array(
                        'id' => 1015,
                        'lang' => 'en',
                        'lang_key' => 'Send Newsletter',
                        'lang_value' => 'Send Newsletter',
                        'created_at' => '2020-11-11 09:14:10',
                        'updated_at' => '2020-11-11 09:14:10',
                    ),
                285 =>
                    array(
                        'id' => 1016,
                        'lang' => 'en',
                        'lang_key' => 'Mobile Users',
                        'lang_value' => 'Mobile Users',
                        'created_at' => '2020-11-11 09:14:10',
                        'updated_at' => '2020-11-11 09:14:10',
                    ),
                286 =>
                    array(
                        'id' => 1017,
                        'lang' => 'en',
                        'lang_key' => 'SMS subject',
                        'lang_value' => 'SMS subject',
                        'created_at' => '2020-11-11 09:14:10',
                        'updated_at' => '2020-11-11 09:14:10',
                    ),
                287 =>
                    array(
                        'id' => 1018,
                        'lang' => 'en',
                        'lang_key' => 'SMS content',
                        'lang_value' => 'SMS content',
                        'created_at' => '2020-11-11 09:14:10',
                        'updated_at' => '2020-11-11 09:14:10',
                    ),
                288 =>
                    array(
                        'id' => 1019,
                        'lang' => 'en',
                        'lang_key' => 'All Flash Delas',
                        'lang_value' => 'All Flash Delas',
                        'created_at' => '2020-11-11 09:16:06',
                        'updated_at' => '2020-11-11 09:16:06',
                    ),
                289 =>
                    array(
                        'id' => 1020,
                        'lang' => 'en',
                        'lang_key' => 'Create New Flash Dela',
                        'lang_value' => 'Create New Flash Dela',
                        'created_at' => '2020-11-11 09:16:06',
                        'updated_at' => '2020-11-11 09:16:06',
                    ),
                290 =>
                    array(
                        'id' => 1022,
                        'lang' => 'en',
                        'lang_key' => 'Page Link',
                        'lang_value' => 'Page Link',
                        'created_at' => '2020-11-11 09:16:06',
                        'updated_at' => '2020-11-11 09:16:06',
                    ),
                291 =>
                    array(
                        'id' => 1023,
                        'lang' => 'en',
                        'lang_key' => 'Flash Deal Information',
                        'lang_value' => 'Flash Deal Information',
                        'created_at' => '2020-11-11 09:16:14',
                        'updated_at' => '2020-11-11 09:16:14',
                    ),
                292 =>
                    array(
                        'id' => 1024,
                        'lang' => 'en',
                        'lang_key' => 'Background Color',
                        'lang_value' => 'Background Color',
                        'created_at' => '2020-11-11 09:16:14',
                        'updated_at' => '2020-11-11 09:16:14',
                    ),
                293 =>
                    array(
                        'id' => 1026,
                        'lang' => 'en',
                        'lang_key' => 'Text Color',
                        'lang_value' => 'Text Color',
                        'created_at' => '2020-11-11 09:16:14',
                        'updated_at' => '2020-11-11 09:16:14',
                    ),
                294 =>
                    array(
                        'id' => 1027,
                        'lang' => 'en',
                        'lang_key' => 'White',
                        'lang_value' => 'White',
                        'created_at' => '2020-11-11 09:16:14',
                        'updated_at' => '2020-11-11 09:16:14',
                    ),
                295 =>
                    array(
                        'id' => 1028,
                        'lang' => 'en',
                        'lang_key' => 'Dark',
                        'lang_value' => 'Dark',
                        'created_at' => '2020-11-11 09:16:15',
                        'updated_at' => '2020-11-11 09:16:15',
                    ),
                296 =>
                    array(
                        'id' => 1029,
                        'lang' => 'en',
                        'lang_key' => 'Choose Products',
                        'lang_value' => 'Choose Products',
                        'created_at' => '2020-11-11 09:16:15',
                        'updated_at' => '2020-11-11 09:16:15',
                    ),
                297 =>
                    array(
                        'id' => 1030,
                        'lang' => 'en',
                        'lang_key' => 'Discounts',
                        'lang_value' => 'Discounts',
                        'created_at' => '2020-11-11 09:16:20',
                        'updated_at' => '2020-11-11 09:16:20',
                    ),
                298 =>
                    array(
                        'id' => 1031,
                        'lang' => 'en',
                        'lang_key' => 'Discount Type',
                        'lang_value' => 'Discount Type',
                        'created_at' => '2020-11-11 09:16:20',
                        'updated_at' => '2020-11-11 09:16:20',
                    ),
                299 =>
                    array(
                        'id' => 1032,
                        'lang' => 'en',
                        'lang_key' => 'Twillo Credential',
                        'lang_value' => 'Twillo Credential',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                300 =>
                    array(
                        'id' => 1033,
                        'lang' => 'en',
                        'lang_key' => 'TWILIO SID',
                        'lang_value' => 'TWILIO SID',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                301 =>
                    array(
                        'id' => 1034,
                        'lang' => 'en',
                        'lang_key' => 'TWILIO AUTH TOKEN',
                        'lang_value' => 'TWILIO AUTH TOKEN',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                302 =>
                    array(
                        'id' => 1035,
                        'lang' => 'en',
                        'lang_key' => 'TWILIO VERIFY SID',
                        'lang_value' => 'TWILIO VERIFY SID',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                303 =>
                    array(
                        'id' => 1036,
                        'lang' => 'en',
                        'lang_key' => 'VALID TWILLO NUMBER',
                        'lang_value' => 'VALID TWILLO NUMBER',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                304 =>
                    array(
                        'id' => 1037,
                        'lang' => 'en',
                        'lang_key' => 'Nexmo Credential',
                        'lang_value' => 'Nexmo Credential',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                305 =>
                    array(
                        'id' => 1038,
                        'lang' => 'en',
                        'lang_key' => 'NEXMO KEY',
                        'lang_value' => 'NEXMO KEY',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                306 =>
                    array(
                        'id' => 1039,
                        'lang' => 'en',
                        'lang_key' => 'NEXMO SECRET',
                        'lang_value' => 'NEXMO SECRET',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                307 =>
                    array(
                        'id' => 1040,
                        'lang' => 'en',
                        'lang_key' => 'SSL Wireless Credential',
                        'lang_value' => 'SSL Wireless Credential',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                308 =>
                    array(
                        'id' => 1041,
                        'lang' => 'en',
                        'lang_key' => 'SSL SMS API TOKEN',
                        'lang_value' => 'SSL SMS API TOKEN',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                309 =>
                    array(
                        'id' => 1042,
                        'lang' => 'en',
                        'lang_key' => 'SSL SMS SID',
                        'lang_value' => 'SSL SMS SID',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                310 =>
                    array(
                        'id' => 1043,
                        'lang' => 'en',
                        'lang_key' => 'SSL SMS URL',
                        'lang_value' => 'SSL SMS URL',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                311 =>
                    array(
                        'id' => 1044,
                        'lang' => 'en',
                        'lang_key' => 'Fast2SMS Credential',
                        'lang_value' => 'Fast2SMS Credential',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                312 =>
                    array(
                        'id' => 1045,
                        'lang' => 'en',
                        'lang_key' => 'AUTH KEY',
                        'lang_value' => 'AUTH KEY',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                313 =>
                    array(
                        'id' => 1046,
                        'lang' => 'en',
                        'lang_key' => 'ROUTE',
                        'lang_value' => 'ROUTE',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                314 =>
                    array(
                        'id' => 1047,
                        'lang' => 'en',
                        'lang_key' => 'Promotional Use',
                        'lang_value' => 'Promotional Use',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                315 =>
                    array(
                        'id' => 1048,
                        'lang' => 'en',
                        'lang_key' => 'Transactional Use',
                        'lang_value' => 'Transactional Use',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                316 =>
                    array(
                        'id' => 1050,
                        'lang' => 'en',
                        'lang_key' => 'SENDER ID',
                        'lang_value' => 'SENDER ID',
                        'created_at' => '2020-11-11 09:17:35',
                        'updated_at' => '2020-11-11 09:17:35',
                    ),
                317 =>
                    array(
                        'id' => 1051,
                        'lang' => 'en',
                        'lang_key' => 'Nexmo OTP',
                        'lang_value' => 'Nexmo OTP',
                        'created_at' => '2020-11-11 09:17:42',
                        'updated_at' => '2020-11-11 09:17:42',
                    ),
                318 =>
                    array(
                        'id' => 1052,
                        'lang' => 'en',
                        'lang_key' => 'Twillo OTP',
                        'lang_value' => 'Twillo OTP',
                        'created_at' => '2020-11-11 09:17:43',
                        'updated_at' => '2020-11-11 09:17:43',
                    ),
                319 =>
                    array(
                        'id' => 1053,
                        'lang' => 'en',
                        'lang_key' => 'SSL Wireless OTP',
                        'lang_value' => 'SSL Wireless OTP',
                        'created_at' => '2020-11-11 09:17:43',
                        'updated_at' => '2020-11-11 09:17:43',
                    ),
                320 =>
                    array(
                        'id' => 1054,
                        'lang' => 'en',
                        'lang_key' => 'Fast2SMS OTP',
                        'lang_value' => 'Fast2SMS OTP',
                        'created_at' => '2020-11-11 09:17:43',
                        'updated_at' => '2020-11-11 09:17:43',
                    ),
                321 =>
                    array(
                        'id' => 1055,
                        'lang' => 'en',
                        'lang_key' => 'Order Placement',
                        'lang_value' => 'Order Placement',
                        'created_at' => '2020-11-11 09:17:43',
                        'updated_at' => '2020-11-11 09:17:43',
                    ),
                322 =>
                    array(
                        'id' => 1056,
                        'lang' => 'en',
                        'lang_key' => 'Delivery Status Changing Time',
                        'lang_value' => 'Delivery Status Changing Time',
                        'created_at' => '2020-11-11 09:17:43',
                        'updated_at' => '2020-11-11 09:17:43',
                    ),
                323 =>
                    array(
                        'id' => 1057,
                        'lang' => 'en',
                        'lang_key' => 'Paid Status Changing Time',
                        'lang_value' => 'Paid Status Changing Time',
                        'created_at' => '2020-11-11 09:17:43',
                        'updated_at' => '2020-11-11 09:17:43',
                    ),
                324 =>
                    array(
                        'id' => 1058,
                        'lang' => 'en',
                        'lang_key' => 'Send Bulk SMS',
                        'lang_value' => 'Send Bulk SMS',
                        'created_at' => '2020-11-11 09:19:14',
                        'updated_at' => '2020-11-11 09:19:14',
                    ),
                325 =>
                    array(
                        'id' => 1059,
                        'lang' => 'en',
                        'lang_key' => 'All Subscribers',
                        'lang_value' => 'All Subscribers',
                        'created_at' => '2020-11-11 09:21:51',
                        'updated_at' => '2020-11-11 09:21:51',
                    ),
                326 =>
                    array(
                        'id' => 1060,
                        'lang' => 'en',
                        'lang_key' => 'Coupon Information Adding',
                        'lang_value' => 'Coupon Information Adding',
                        'created_at' => '2020-11-11 09:22:25',
                        'updated_at' => '2020-11-11 09:22:25',
                    ),
                327 =>
                    array(
                        'id' => 1061,
                        'lang' => 'en',
                        'lang_key' => 'Coupon Type',
                        'lang_value' => 'Coupon Type',
                        'created_at' => '2020-11-11 09:22:25',
                        'updated_at' => '2020-11-11 09:22:25',
                    ),
                328 =>
                    array(
                        'id' => 1062,
                        'lang' => 'en',
                        'lang_key' => 'For Products',
                        'lang_value' => 'For Products',
                        'created_at' => '2020-11-11 09:22:25',
                        'updated_at' => '2020-11-11 09:22:25',
                    ),
                329 =>
                    array(
                        'id' => 1063,
                        'lang' => 'en',
                        'lang_key' => 'For Total Orders',
                        'lang_value' => 'For Total Orders',
                        'created_at' => '2020-11-11 09:22:25',
                        'updated_at' => '2020-11-11 09:22:25',
                    ),
                330 =>
                    array(
                        'id' => 1064,
                        'lang' => 'en',
                        'lang_key' => 'Add Your Product Base Coupon',
                        'lang_value' => 'Add Your Product Base Coupon',
                        'created_at' => '2020-11-11 09:22:42',
                        'updated_at' => '2020-11-11 09:22:42',
                    ),
                331 =>
                    array(
                        'id' => 1065,
                        'lang' => 'en',
                        'lang_key' => 'Coupon code',
                        'lang_value' => 'Coupon code',
                        'created_at' => '2020-11-11 09:22:42',
                        'updated_at' => '2020-11-11 09:22:42',
                    ),
                332 =>
                    array(
                        'id' => 1066,
                        'lang' => 'en',
                        'lang_key' => 'Sub Category',
                        'lang_value' => 'Sub Category',
                        'created_at' => '2020-11-11 09:22:42',
                        'updated_at' => '2020-11-11 09:22:42',
                    ),
                333 =>
                    array(
                        'id' => 1067,
                        'lang' => 'en',
                        'lang_key' => 'Add More',
                        'lang_value' => 'Add More',
                        'created_at' => '2020-11-11 09:22:43',
                        'updated_at' => '2020-11-11 09:22:43',
                    ),
                334 =>
                    array(
                        'id' => 1068,
                        'lang' => 'en',
                        'lang_key' => 'Add Your Cart Base Coupon',
                        'lang_value' => 'Add Your Cart Base Coupon',
                        'created_at' => '2020-11-11 09:29:40',
                        'updated_at' => '2020-11-11 09:29:40',
                    ),
                335 =>
                    array(
                        'id' => 1069,
                        'lang' => 'en',
                        'lang_key' => 'Minimum Shopping',
                        'lang_value' => 'Minimum Shopping',
                        'created_at' => '2020-11-11 09:29:40',
                        'updated_at' => '2020-11-11 09:29:40',
                    ),
                336 =>
                    array(
                        'id' => 1070,
                        'lang' => 'en',
                        'lang_key' => 'Maximum Discount Amount',
                        'lang_value' => 'Maximum Discount Amount',
                        'created_at' => '2020-11-11 09:29:41',
                        'updated_at' => '2020-11-11 09:29:41',
                    ),
                337 =>
                    array(
                        'id' => 1071,
                        'lang' => 'en',
                        'lang_key' => 'Coupon Information Update',
                        'lang_value' => 'Coupon Information Update',
                        'created_at' => '2020-11-11 10:18:34',
                        'updated_at' => '2020-11-11 10:18:34',
                    ),
                338 =>
                    array(
                        'id' => 1073,
                        'lang' => 'en',
                        'lang_key' => 'Please Configure SMTP Setting to work all email sending funtionality',
                        'lang_value' => 'Please Configure SMTP Setting to work all email sending funtionality',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                339 =>
                    array(
                        'id' => 1074,
                        'lang' => 'en',
                        'lang_key' => 'Configure Now',
                        'lang_value' => 'Configure Now',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                340 =>
                    array(
                        'id' => 1076,
                        'lang' => 'en',
                        'lang_key' => 'Total published products',
                        'lang_value' => 'Total published products',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                341 =>
                    array(
                        'id' => 1077,
                        'lang' => 'en',
                        'lang_key' => 'Total sellers products',
                        'lang_value' => 'Total sellers products',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                342 =>
                    array(
                        'id' => 1078,
                        'lang' => 'en',
                        'lang_key' => 'Total admin products',
                        'lang_value' => 'Total admin products',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                343 =>
                    array(
                        'id' => 1079,
                        'lang' => 'en',
                        'lang_key' => 'Manage Products',
                        'lang_value' => 'Manage Products',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                344 =>
                    array(
                        'id' => 1080,
                        'lang' => 'en',
                        'lang_key' => 'Total product category',
                        'lang_value' => 'Total product category',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                345 =>
                    array(
                        'id' => 1081,
                        'lang' => 'en',
                        'lang_key' => 'Create Category',
                        'lang_value' => 'Create Category',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                346 =>
                    array(
                        'id' => 1082,
                        'lang' => 'en',
                        'lang_key' => 'Total product sub sub category',
                        'lang_value' => 'Total product sub sub category',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                347 =>
                    array(
                        'id' => 1083,
                        'lang' => 'en',
                        'lang_key' => 'Create Sub Sub Category',
                        'lang_value' => 'Create Sub Sub Category',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                348 =>
                    array(
                        'id' => 1084,
                        'lang' => 'en',
                        'lang_key' => 'Total product sub category',
                        'lang_value' => 'Total product sub category',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                349 =>
                    array(
                        'id' => 1085,
                        'lang' => 'en',
                        'lang_key' => 'Create Sub Category',
                        'lang_value' => 'Create Sub Category',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                350 =>
                    array(
                        'id' => 1086,
                        'lang' => 'en',
                        'lang_key' => 'Total product brand',
                        'lang_value' => 'Total product brand',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                351 =>
                    array(
                        'id' => 1087,
                        'lang' => 'en',
                        'lang_key' => 'Create Brand',
                        'lang_value' => 'Create Brand',
                        'created_at' => '2020-11-11 15:10:18',
                        'updated_at' => '2020-11-11 15:10:18',
                    ),
                352 =>
                    array(
                        'id' => 1089,
                        'lang' => 'en',
                        'lang_key' => 'Total sellers',
                        'lang_value' => 'Total sellers',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                353 =>
                    array(
                        'id' => 1091,
                        'lang' => 'en',
                        'lang_key' => 'Total approved sellers',
                        'lang_value' => 'Total approved sellers',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                354 =>
                    array(
                        'id' => 1093,
                        'lang' => 'en',
                        'lang_key' => 'Total pending sellers',
                        'lang_value' => 'Total pending sellers',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                355 =>
                    array(
                        'id' => 1094,
                        'lang' => 'en',
                        'lang_key' => 'Manage Sellers',
                        'lang_value' => 'Manage Sellers',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                356 =>
                    array(
                        'id' => 1095,
                        'lang' => 'en',
                        'lang_key' => 'Category wise product sale',
                        'lang_value' => 'Category wise product sale',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                357 =>
                    array(
                        'id' => 1097,
                        'lang' => 'en',
                        'lang_key' => 'Sale',
                        'lang_value' => 'Sale',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                358 =>
                    array(
                        'id' => 1098,
                        'lang' => 'en',
                        'lang_key' => 'Category wise product stock',
                        'lang_value' => 'Category wise product stock',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                359 =>
                    array(
                        'id' => 1099,
                        'lang' => 'en',
                        'lang_key' => 'Category Name',
                        'lang_value' => 'Category Name',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                360 =>
                    array(
                        'id' => 1100,
                        'lang' => 'en',
                        'lang_key' => 'Stock',
                        'lang_value' => 'Stock',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                361 =>
                    array(
                        'id' => 1101,
                        'lang' => 'en',
                        'lang_key' => 'Frontend',
                        'lang_value' => 'Frontend',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                362 =>
                    array(
                        'id' => 1103,
                        'lang' => 'en',
                        'lang_key' => 'Home page',
                        'lang_value' => 'Home page',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                363 =>
                    array(
                        'id' => 1104,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:19',
                        'updated_at' => '2020-11-11 15:10:19',
                    ),
                364 =>
                    array(
                        'id' => 1106,
                        'lang' => 'en',
                        'lang_key' => 'Policy page',
                        'lang_value' => 'Policy page',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                365 =>
                    array(
                        'id' => 1107,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                366 =>
                    array(
                        'id' => 1109,
                        'lang' => 'en',
                        'lang_key' => 'General',
                        'lang_value' => 'General',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                367 =>
                    array(
                        'id' => 1110,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                368 =>
                    array(
                        'id' => 1111,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                369 =>
                    array(
                        'id' => 1112,
                        'lang' => 'en',
                        'lang_key' => 'Useful link',
                        'lang_value' => 'Useful link',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                370 =>
                    array(
                        'id' => 1113,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                371 =>
                    array(
                        'id' => 1114,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                372 =>
                    array(
                        'id' => 1115,
                        'lang' => 'en',
                        'lang_key' => 'Activation',
                        'lang_value' => 'Activation',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                373 =>
                    array(
                        'id' => 1116,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                374 =>
                    array(
                        'id' => 1117,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                375 =>
                    array(
                        'id' => 1118,
                        'lang' => 'en',
                        'lang_key' => 'SMTP',
                        'lang_value' => 'SMTP',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                376 =>
                    array(
                        'id' => 1119,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                377 =>
                    array(
                        'id' => 1120,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                378 =>
                    array(
                        'id' => 1121,
                        'lang' => 'en',
                        'lang_key' => 'Payment method',
                        'lang_value' => 'Payment method',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                379 =>
                    array(
                        'id' => 1122,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                380 =>
                    array(
                        'id' => 1123,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                381 =>
                    array(
                        'id' => 1124,
                        'lang' => 'en',
                        'lang_key' => 'Social media',
                        'lang_value' => 'Social media',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                382 =>
                    array(
                        'id' => 1125,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:20',
                        'updated_at' => '2020-11-11 15:10:20',
                    ),
                383 =>
                    array(
                        'id' => 1126,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                384 =>
                    array(
                        'id' => 1127,
                        'lang' => 'en',
                        'lang_key' => 'Business',
                        'lang_value' => 'Business',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                385 =>
                    array(
                        'id' => 1128,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                386 =>
                    array(
                        'id' => 1130,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                387 =>
                    array(
                        'id' => 1131,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                388 =>
                    array(
                        'id' => 1132,
                        'lang' => 'en',
                        'lang_key' => 'Seller verification',
                        'lang_value' => 'Seller verification',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                389 =>
                    array(
                        'id' => 1133,
                        'lang' => 'en',
                        'lang_key' => 'form setting',
                        'lang_value' => 'form setting',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                390 =>
                    array(
                        'id' => 1134,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                391 =>
                    array(
                        'id' => 1135,
                        'lang' => 'en',
                        'lang_key' => 'Language',
                        'lang_value' => 'Language',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                392 =>
                    array(
                        'id' => 1136,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                393 =>
                    array(
                        'id' => 1137,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                394 =>
                    array(
                        'id' => 1139,
                        'lang' => 'en',
                        'lang_key' => 'setting',
                        'lang_value' => 'setting',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                395 =>
                    array(
                        'id' => 1140,
                        'lang' => 'en',
                        'lang_key' => 'Click Here',
                        'lang_value' => 'Click Here',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                396 =>
                    array(
                        'id' => 1141,
                        'lang' => 'en',
                        'lang_key' => 'Dashboard',
                        'lang_value' => 'Dashboard',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                397 =>
                    array(
                        'id' => 1142,
                        'lang' => 'en',
                        'lang_key' => 'POS System',
                        'lang_value' => 'POS System',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                398 =>
                    array(
                        'id' => 1143,
                        'lang' => 'en',
                        'lang_key' => 'POS Manager',
                        'lang_value' => 'POS Manager',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                399 =>
                    array(
                        'id' => 1144,
                        'lang' => 'en',
                        'lang_key' => 'POS Configuration',
                        'lang_value' => 'POS Configuration',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                400 =>
                    array(
                        'id' => 1145,
                        'lang' => 'en',
                        'lang_key' => 'Products',
                        'lang_value' => 'Products',
                        'created_at' => '2020-11-11 15:10:21',
                        'updated_at' => '2020-11-11 15:10:21',
                    ),
                401 =>
                    array(
                        'id' => 1146,
                        'lang' => 'en',
                        'lang_key' => 'Add New product',
                        'lang_value' => 'Add New product',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                402 =>
                    array(
                        'id' => 1147,
                        'lang' => 'en',
                        'lang_key' => 'All Products',
                        'lang_value' => 'All Products',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                403 =>
                    array(
                        'id' => 1148,
                        'lang' => 'en',
                        'lang_key' => 'In House Products',
                        'lang_value' => 'In House Products',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                404 =>
                    array(
                        'id' => 1149,
                        'lang' => 'en',
                        'lang_key' => 'Seller Products',
                        'lang_value' => 'Seller Products',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                405 =>
                    array(
                        'id' => 1150,
                        'lang' => 'en',
                        'lang_key' => 'Digital Products',
                        'lang_value' => 'Digital Products',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                406 =>
                    array(
                        'id' => 1151,
                        'lang' => 'en',
                        'lang_key' => 'Bulk Import',
                        'lang_value' => 'Bulk Import',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                407 =>
                    array(
                        'id' => 1152,
                        'lang' => 'en',
                        'lang_key' => 'Bulk Export',
                        'lang_value' => 'Bulk Export',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                408 =>
                    array(
                        'id' => 1153,
                        'lang' => 'en',
                        'lang_key' => 'Category',
                        'lang_value' => 'Category',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                409 =>
                    array(
                        'id' => 1154,
                        'lang' => 'en',
                        'lang_key' => 'Subcategory',
                        'lang_value' => 'Subcategory',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                410 =>
                    array(
                        'id' => 1155,
                        'lang' => 'en',
                        'lang_key' => 'Sub Subcategory',
                        'lang_value' => 'Sub Subcategory',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                411 =>
                    array(
                        'id' => 1156,
                        'lang' => 'en',
                        'lang_key' => 'Brand',
                        'lang_value' => 'Brand',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                412 =>
                    array(
                        'id' => 1157,
                        'lang' => 'en',
                        'lang_key' => 'Attribute',
                        'lang_value' => 'Attribute',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                413 =>
                    array(
                        'id' => 1158,
                        'lang' => 'en',
                        'lang_key' => 'Product Reviews',
                        'lang_value' => 'Product Reviews',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                414 =>
                    array(
                        'id' => 1159,
                        'lang' => 'en',
                        'lang_key' => 'Sales',
                        'lang_value' => 'Sales',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                415 =>
                    array(
                        'id' => 1160,
                        'lang' => 'en',
                        'lang_key' => 'All Orders',
                        'lang_value' => 'All Orders',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                416 =>
                    array(
                        'id' => 1161,
                        'lang' => 'en',
                        'lang_key' => 'Inhouse orders',
                        'lang_value' => 'Inhouse orders',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                417 =>
                    array(
                        'id' => 1162,
                        'lang' => 'en',
                        'lang_key' => 'Seller Orders',
                        'lang_value' => 'Seller Orders',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                418 =>
                    array(
                        'id' => 1163,
                        'lang' => 'en',
                        'lang_key' => 'Pick-up Point Order',
                        'lang_value' => 'Pick-up Point Order',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                419 =>
                    array(
                        'id' => 1164,
                        'lang' => 'en',
                        'lang_key' => 'Refunds',
                        'lang_value' => 'Refunds',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                420 =>
                    array(
                        'id' => 1165,
                        'lang' => 'en',
                        'lang_key' => 'Refund Requests',
                        'lang_value' => 'Refund Requests',
                        'created_at' => '2020-11-11 15:10:22',
                        'updated_at' => '2020-11-11 15:10:22',
                    ),
                421 =>
                    array(
                        'id' => 1166,
                        'lang' => 'en',
                        'lang_key' => 'Approved Refund',
                        'lang_value' => 'Approved Refund',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                422 =>
                    array(
                        'id' => 1167,
                        'lang' => 'en',
                        'lang_key' => 'Refund Configuration',
                        'lang_value' => 'Refund Configuration',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                423 =>
                    array(
                        'id' => 1168,
                        'lang' => 'en',
                        'lang_key' => 'Customers',
                        'lang_value' => 'Customers',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                424 =>
                    array(
                        'id' => 1169,
                        'lang' => 'en',
                        'lang_key' => 'Customer list',
                        'lang_value' => 'Customer list',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                425 =>
                    array(
                        'id' => 1170,
                        'lang' => 'en',
                        'lang_key' => 'Classified Products',
                        'lang_value' => 'Classified Products',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                426 =>
                    array(
                        'id' => 1171,
                        'lang' => 'en',
                        'lang_key' => 'Classified Packages',
                        'lang_value' => 'Classified Packages',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                427 =>
                    array(
                        'id' => 1172,
                        'lang' => 'en',
                        'lang_key' => 'Sellers',
                        'lang_value' => 'Sellers',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                428 =>
                    array(
                        'id' => 1173,
                        'lang' => 'en',
                        'lang_key' => 'All Seller',
                        'lang_value' => 'All Seller',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                429 =>
                    array(
                        'id' => 1174,
                        'lang' => 'en',
                        'lang_key' => 'Payouts',
                        'lang_value' => 'Payouts',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                430 =>
                    array(
                        'id' => 1175,
                        'lang' => 'en',
                        'lang_key' => 'Payout Requests',
                        'lang_value' => 'Payout Requests',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                431 =>
                    array(
                        'id' => 1176,
                        'lang' => 'en',
                        'lang_key' => 'Seller Commission',
                        'lang_value' => 'Seller Commission',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                432 =>
                    array(
                        'id' => 1177,
                        'lang' => 'en',
                        'lang_key' => 'Seller Packages',
                        'lang_value' => 'Seller Packages',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                433 =>
                    array(
                        'id' => 1178,
                        'lang' => 'en',
                        'lang_key' => 'Seller Verification Form',
                        'lang_value' => 'Seller Verification Form',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                434 =>
                    array(
                        'id' => 1179,
                        'lang' => 'en',
                        'lang_key' => 'Reports',
                        'lang_value' => 'Reports',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                435 =>
                    array(
                        'id' => 1180,
                        'lang' => 'en',
                        'lang_key' => 'In House Product Sale',
                        'lang_value' => 'In House Product Sale',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                436 =>
                    array(
                        'id' => 1181,
                        'lang' => 'en',
                        'lang_key' => 'Seller Products Sale',
                        'lang_value' => 'Seller Products Sale',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                437 =>
                    array(
                        'id' => 1182,
                        'lang' => 'en',
                        'lang_key' => 'Products Stock',
                        'lang_value' => 'Products Stock',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                438 =>
                    array(
                        'id' => 1183,
                        'lang' => 'en',
                        'lang_key' => 'Products wishlist',
                        'lang_value' => 'Products wishlist',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                439 =>
                    array(
                        'id' => 1184,
                        'lang' => 'en',
                        'lang_key' => 'User Searches',
                        'lang_value' => 'User Searches',
                        'created_at' => '2020-11-11 15:10:23',
                        'updated_at' => '2020-11-11 15:10:23',
                    ),
                440 =>
                    array(
                        'id' => 1185,
                        'lang' => 'en',
                        'lang_key' => 'Marketing',
                        'lang_value' => 'Marketing',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                441 =>
                    array(
                        'id' => 1186,
                        'lang' => 'en',
                        'lang_key' => 'Flash deals',
                        'lang_value' => 'Flash deals',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                442 =>
                    array(
                        'id' => 1187,
                        'lang' => 'en',
                        'lang_key' => 'Newsletters',
                        'lang_value' => 'Newsletters',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                443 =>
                    array(
                        'id' => 1188,
                        'lang' => 'en',
                        'lang_key' => 'Bulk SMS',
                        'lang_value' => 'Bulk SMS',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                444 =>
                    array(
                        'id' => 1189,
                        'lang' => 'en',
                        'lang_key' => 'Subscribers',
                        'lang_value' => 'Subscribers',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                445 =>
                    array(
                        'id' => 1190,
                        'lang' => 'en',
                        'lang_key' => 'Coupon',
                        'lang_value' => 'Coupon',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                446 =>
                    array(
                        'id' => 1191,
                        'lang' => 'en',
                        'lang_key' => 'Support',
                        'lang_value' => 'Support',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                447 =>
                    array(
                        'id' => 1192,
                        'lang' => 'en',
                        'lang_key' => 'Ticket',
                        'lang_value' => 'Ticket',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                448 =>
                    array(
                        'id' => 1193,
                        'lang' => 'en',
                        'lang_key' => 'Product Queries',
                        'lang_value' => 'Product Queries',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                449 =>
                    array(
                        'id' => 1194,
                        'lang' => 'en',
                        'lang_key' => 'Website Setup',
                        'lang_value' => 'Website Setup',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                450 =>
                    array(
                        'id' => 1195,
                        'lang' => 'en',
                        'lang_key' => 'Header',
                        'lang_value' => 'Header',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                451 =>
                    array(
                        'id' => 1196,
                        'lang' => 'en',
                        'lang_key' => 'Footer',
                        'lang_value' => 'Footer',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                452 =>
                    array(
                        'id' => 1197,
                        'lang' => 'en',
                        'lang_key' => 'Pages',
                        'lang_value' => 'Pages',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                453 =>
                    array(
                        'id' => 1198,
                        'lang' => 'en',
                        'lang_key' => 'Appearance',
                        'lang_value' => 'Appearance',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                454 =>
                    array(
                        'id' => 1199,
                        'lang' => 'en',
                        'lang_key' => 'Setup & Configurations',
                        'lang_value' => 'Setup & Configurations',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                455 =>
                    array(
                        'id' => 1200,
                        'lang' => 'en',
                        'lang_key' => 'General Settings',
                        'lang_value' => 'General Settings',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                456 =>
                    array(
                        'id' => 1201,
                        'lang' => 'en',
                        'lang_key' => 'Features activation',
                        'lang_value' => 'Features activation',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                457 =>
                    array(
                        'id' => 1202,
                        'lang' => 'en',
                        'lang_key' => 'Languages',
                        'lang_value' => 'Languages',
                        'created_at' => '2020-11-11 15:10:24',
                        'updated_at' => '2020-11-11 15:10:24',
                    ),
                458 =>
                    array(
                        'id' => 1203,
                        'lang' => 'en',
                        'lang_key' => 'Currency',
                        'lang_value' => 'Currency',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                459 =>
                    array(
                        'id' => 1204,
                        'lang' => 'en',
                        'lang_key' => 'Pickup point',
                        'lang_value' => 'Pickup point',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                460 =>
                    array(
                        'id' => 1205,
                        'lang' => 'en',
                        'lang_key' => 'SMTP Settings',
                        'lang_value' => 'SMTP Settings',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                461 =>
                    array(
                        'id' => 1206,
                        'lang' => 'en',
                        'lang_key' => 'Payment Methods',
                        'lang_value' => 'Payment Methods',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                462 =>
                    array(
                        'id' => 1207,
                        'lang' => 'en',
                        'lang_key' => 'File System Configuration',
                        'lang_value' => 'File System Configuration',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                463 =>
                    array(
                        'id' => 1208,
                        'lang' => 'en',
                        'lang_key' => 'Social media Logins',
                        'lang_value' => 'Social media Logins',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                464 =>
                    array(
                        'id' => 1209,
                        'lang' => 'en',
                        'lang_key' => 'Analytics Tools',
                        'lang_value' => 'Analytics Tools',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                465 =>
                    array(
                        'id' => 1210,
                        'lang' => 'en',
                        'lang_key' => 'Facebook Chat',
                        'lang_value' => 'Facebook Chat',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                466 =>
                    array(
                        'id' => 1211,
                        'lang' => 'en',
                        'lang_key' => 'Google reCAPTCHA',
                        'lang_value' => 'Google reCAPTCHA',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                467 =>
                    array(
                        'id' => 1212,
                        'lang' => 'en',
                        'lang_key' => 'Shipping Configuration',
                        'lang_value' => 'Shipping Configuration',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                468 =>
                    array(
                        'id' => 1213,
                        'lang' => 'en',
                        'lang_key' => 'Shipping Countries',
                        'lang_value' => 'Shipping Countries',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                469 =>
                    array(
                        'id' => 1214,
                        'lang' => 'en',
                        'lang_key' => 'Affiliate System',
                        'lang_value' => 'Affiliate System',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                470 =>
                    array(
                        'id' => 1215,
                        'lang' => 'en',
                        'lang_key' => 'Affiliate Registration Form',
                        'lang_value' => 'Affiliate Registration Form',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                471 =>
                    array(
                        'id' => 1216,
                        'lang' => 'en',
                        'lang_key' => 'Affiliate Configurations',
                        'lang_value' => 'Affiliate Configurations',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                472 =>
                    array(
                        'id' => 1217,
                        'lang' => 'en',
                        'lang_key' => 'Affiliate Users',
                        'lang_value' => 'Affiliate Users',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                473 =>
                    array(
                        'id' => 1218,
                        'lang' => 'en',
                        'lang_key' => 'Referral Users',
                        'lang_value' => 'Referral Users',
                        'created_at' => '2020-11-11 15:10:25',
                        'updated_at' => '2020-11-11 15:10:25',
                    ),
                474 =>
                    array(
                        'id' => 1219,
                        'lang' => 'en',
                        'lang_key' => 'Affiliate Withdraw Requests',
                        'lang_value' => 'Affiliate Withdraw Requests',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                475 =>
                    array(
                        'id' => 1220,
                        'lang' => 'en',
                        'lang_key' => 'Offline Payment System',
                        'lang_value' => 'Offline Payment System',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                476 =>
                    array(
                        'id' => 1221,
                        'lang' => 'en',
                        'lang_key' => 'Manual Payment Methods',
                        'lang_value' => 'Manual Payment Methods',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                477 =>
                    array(
                        'id' => 1222,
                        'lang' => 'en',
                        'lang_key' => 'Offline Wallet Recharge',
                        'lang_value' => 'Offline Wallet Recharge',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                478 =>
                    array(
                        'id' => 1223,
                        'lang' => 'en',
                        'lang_key' => 'Offline Customer Package Payments',
                        'lang_value' => 'Offline Customer Package Payments',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                479 =>
                    array(
                        'id' => 1224,
                        'lang' => 'en',
                        'lang_key' => 'Offline Seller Package Payments',
                        'lang_value' => 'Offline Seller Package Payments',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                480 =>
                    array(
                        'id' => 1225,
                        'lang' => 'en',
                        'lang_key' => 'Paytm Payment Gateway',
                        'lang_value' => 'Paytm Payment Gateway',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                481 =>
                    array(
                        'id' => 1226,
                        'lang' => 'en',
                        'lang_key' => 'Set Paytm Credentials',
                        'lang_value' => 'Set Paytm Credentials',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                482 =>
                    array(
                        'id' => 1227,
                        'lang' => 'en',
                        'lang_key' => 'Club Point System',
                        'lang_value' => 'Club Point System',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                483 =>
                    array(
                        'id' => 1228,
                        'lang' => 'en',
                        'lang_key' => 'Club Point Configurations',
                        'lang_value' => 'Club Point Configurations',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                484 =>
                    array(
                        'id' => 1229,
                        'lang' => 'en',
                        'lang_key' => 'Set Product Point',
                        'lang_value' => 'Set Product Point',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                485 =>
                    array(
                        'id' => 1230,
                        'lang' => 'en',
                        'lang_key' => 'User Points',
                        'lang_value' => 'User Points',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                486 =>
                    array(
                        'id' => 1231,
                        'lang' => 'en',
                        'lang_key' => 'OTP System',
                        'lang_value' => 'OTP System',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                487 =>
                    array(
                        'id' => 1232,
                        'lang' => 'en',
                        'lang_key' => 'OTP Configurations',
                        'lang_value' => 'OTP Configurations',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                488 =>
                    array(
                        'id' => 1233,
                        'lang' => 'en',
                        'lang_key' => 'Set OTP Credentials',
                        'lang_value' => 'Set OTP Credentials',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                489 =>
                    array(
                        'id' => 1234,
                        'lang' => 'en',
                        'lang_key' => 'Staffs',
                        'lang_value' => 'Staffs',
                        'created_at' => '2020-11-11 15:10:26',
                        'updated_at' => '2020-11-11 15:10:26',
                    ),
                490 =>
                    array(
                        'id' => 1235,
                        'lang' => 'en',
                        'lang_key' => 'All staffs',
                        'lang_value' => 'All staffs',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
                491 =>
                    array(
                        'id' => 1236,
                        'lang' => 'en',
                        'lang_key' => 'Staff permissions',
                        'lang_value' => 'Staff permissions',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
                492 =>
                    array(
                        'id' => 1237,
                        'lang' => 'en',
                        'lang_key' => 'Addon Manager',
                        'lang_value' => 'Addon Manager',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
                493 =>
                    array(
                        'id' => 1238,
                        'lang' => 'en',
                        'lang_key' => 'Browse Website',
                        'lang_value' => 'Browse Website',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
                494 =>
                    array(
                        'id' => 1239,
                        'lang' => 'en',
                        'lang_key' => 'POS',
                        'lang_value' => 'POS',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
                495 =>
                    array(
                        'id' => 1240,
                        'lang' => 'en',
                        'lang_key' => 'Notifications',
                        'lang_value' => 'Notifications',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
                496 =>
                    array(
                        'id' => 1241,
                        'lang' => 'en',
                        'lang_key' => 'new orders',
                        'lang_value' => 'new orders',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
                497 =>
                    array(
                        'id' => 1242,
                        'lang' => 'en',
                        'lang_key' => 'user-image',
                        'lang_value' => 'user-image',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
                498 =>
                    array(
                        'id' => 1243,
                        'lang' => 'en',
                        'lang_key' => 'Profile',
                        'lang_value' => 'Profile',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
                499 =>
                    array(
                        'id' => 1244,
                        'lang' => 'en',
                        'lang_key' => 'Logout',
                        'lang_value' => 'Logout',
                        'created_at' => '2020-11-11 15:10:27',
                        'updated_at' => '2020-11-11 15:10:27',
                    ),
            ));
            \DB::table('translations')->insert(array(
                0 =>
                    array(
                        'id' => 1247,
                        'lang' => 'en',
                        'lang_key' => 'Page Not Found!',
                        'lang_value' => 'Page Not Found!',
                        'created_at' => '2020-11-11 15:10:28',
                        'updated_at' => '2020-11-11 15:10:28',
                    ),
                1 =>
                    array(
                        'id' => 1249,
                        'lang' => 'en',
                        'lang_key' => 'The page you are looking for has not been found on our server.',
                        'lang_value' => 'The page you are looking for has not been found on our server.',
                        'created_at' => '2020-11-11 15:10:28',
                        'updated_at' => '2020-11-11 15:10:28',
                    ),
                2 =>
                    array(
                        'id' => 1253,
                        'lang' => 'en',
                        'lang_key' => 'Registration',
                        'lang_value' => 'Registration',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                3 =>
                    array(
                        'id' => 1255,
                        'lang' => 'en',
                        'lang_key' => 'I am shopping for...',
                        'lang_value' => 'I am shopping for...',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                4 =>
                    array(
                        'id' => 1257,
                        'lang' => 'en',
                        'lang_key' => 'Compare',
                        'lang_value' => 'Compare',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                5 =>
                    array(
                        'id' => 1259,
                        'lang' => 'en',
                        'lang_key' => 'Wishlist',
                        'lang_value' => 'Wishlist',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                6 =>
                    array(
                        'id' => 1261,
                        'lang' => 'en',
                        'lang_key' => 'Cart',
                        'lang_value' => 'Cart',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                7 =>
                    array(
                        'id' => 1263,
                        'lang' => 'en',
                        'lang_key' => 'Your Cart is empty',
                        'lang_value' => 'Your Cart is empty',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                8 =>
                    array(
                        'id' => 1265,
                        'lang' => 'en',
                        'lang_key' => 'Categories',
                        'lang_value' => 'Categories',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                9 =>
                    array(
                        'id' => 1267,
                        'lang' => 'en',
                        'lang_key' => 'See All',
                        'lang_value' => 'See All',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                10 =>
                    array(
                        'id' => 1269,
                        'lang' => 'en',
                        'lang_key' => 'Seller Policy',
                        'lang_value' => 'Seller Policy',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                11 =>
                    array(
                        'id' => 1271,
                        'lang' => 'en',
                        'lang_key' => 'Return Policy',
                        'lang_value' => 'Return Policy',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                12 =>
                    array(
                        'id' => 1273,
                        'lang' => 'en',
                        'lang_key' => 'Support Policy',
                        'lang_value' => 'Support Policy',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                13 =>
                    array(
                        'id' => 1275,
                        'lang' => 'en',
                        'lang_key' => 'Privacy Policy',
                        'lang_value' => 'Privacy Policy',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                14 =>
                    array(
                        'id' => 1277,
                        'lang' => 'en',
                        'lang_key' => 'Your Email Address',
                        'lang_value' => 'Your Email Address',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                15 =>
                    array(
                        'id' => 1279,
                        'lang' => 'en',
                        'lang_key' => 'Subscribe',
                        'lang_value' => 'Subscribe',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                16 =>
                    array(
                        'id' => 1281,
                        'lang' => 'en',
                        'lang_key' => 'Contact Info',
                        'lang_value' => 'Contact Info',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                17 =>
                    array(
                        'id' => 1283,
                        'lang' => 'en',
                        'lang_key' => 'Address',
                        'lang_value' => 'Address',
                        'created_at' => '2020-11-11 15:10:29',
                        'updated_at' => '2020-11-11 15:10:29',
                    ),
                18 =>
                    array(
                        'id' => 1285,
                        'lang' => 'en',
                        'lang_key' => 'Phone',
                        'lang_value' => 'Phone',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                19 =>
                    array(
                        'id' => 1287,
                        'lang' => 'en',
                        'lang_key' => 'Email',
                        'lang_value' => 'Email',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                20 =>
                    array(
                        'id' => 1288,
                        'lang' => 'en',
                        'lang_key' => 'Login',
                        'lang_value' => 'Login',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                21 =>
                    array(
                        'id' => 1289,
                        'lang' => 'en',
                        'lang_key' => 'My Account',
                        'lang_value' => 'My Account',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                22 =>
                    array(
                        'id' => 1291,
                        'lang' => 'en',
                        'lang_key' => 'Login',
                        'lang_value' => 'Login',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                23 =>
                    array(
                        'id' => 1293,
                        'lang' => 'en',
                        'lang_key' => 'Order History',
                        'lang_value' => 'Order History',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                24 =>
                    array(
                        'id' => 1295,
                        'lang' => 'en',
                        'lang_key' => 'My Wishlist',
                        'lang_value' => 'My Wishlist',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                25 =>
                    array(
                        'id' => 1297,
                        'lang' => 'en',
                        'lang_key' => 'Track Order',
                        'lang_value' => 'Track Order',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                26 =>
                    array(
                        'id' => 1299,
                        'lang' => 'en',
                        'lang_key' => 'Be an affiliate partner',
                        'lang_value' => 'Be an affiliate partner',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                27 =>
                    array(
                        'id' => 1301,
                        'lang' => 'en',
                        'lang_key' => 'Be a Seller',
                        'lang_value' => 'Be a Seller',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                28 =>
                    array(
                        'id' => 1303,
                        'lang' => 'en',
                        'lang_key' => 'Apply Now',
                        'lang_value' => 'Apply Now',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                29 =>
                    array(
                        'id' => 1305,
                        'lang' => 'en',
                        'lang_key' => 'Confirmation',
                        'lang_value' => 'Confirmation',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                30 =>
                    array(
                        'id' => 1307,
                        'lang' => 'en',
                        'lang_key' => 'Delete confirmation message',
                        'lang_value' => 'Delete confirmation message',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                31 =>
                    array(
                        'id' => 1309,
                        'lang' => 'en',
                        'lang_key' => 'Cancel',
                        'lang_value' => 'Cancel',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                32 =>
                    array(
                        'id' => 1312,
                        'lang' => 'en',
                        'lang_key' => 'Delete',
                        'lang_value' => 'Delete',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                33 =>
                    array(
                        'id' => 1313,
                        'lang' => 'en',
                        'lang_key' => 'Item has been added to compare list',
                        'lang_value' => 'Item has been added to compare list',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                34 =>
                    array(
                        'id' => 1314,
                        'lang' => 'en',
                        'lang_key' => 'Please login first',
                        'lang_value' => 'Please login first',
                        'created_at' => '2020-11-11 15:10:30',
                        'updated_at' => '2020-11-11 15:10:30',
                    ),
                35 =>
                    array(
                        'id' => 1315,
                        'lang' => 'en',
                        'lang_key' => 'Total Earnings From',
                        'lang_value' => 'Total Earnings From',
                        'created_at' => '2020-11-12 10:01:11',
                        'updated_at' => '2020-11-12 10:01:11',
                    ),
                36 =>
                    array(
                        'id' => 1316,
                        'lang' => 'en',
                        'lang_key' => 'Client Subscription',
                        'lang_value' => 'Client Subscription',
                        'created_at' => '2020-11-12 10:01:12',
                        'updated_at' => '2020-11-12 10:01:12',
                    ),
                37 =>
                    array(
                        'id' => 1317,
                        'lang' => 'en',
                        'lang_key' => 'Product category',
                        'lang_value' => 'Product category',
                        'created_at' => '2020-11-12 10:03:46',
                        'updated_at' => '2020-11-12 10:03:46',
                    ),
                38 =>
                    array(
                        'id' => 1318,
                        'lang' => 'en',
                        'lang_key' => 'Product sub sub category',
                        'lang_value' => 'Product sub sub category',
                        'created_at' => '2020-11-12 10:03:46',
                        'updated_at' => '2020-11-12 10:03:46',
                    ),
                39 =>
                    array(
                        'id' => 1319,
                        'lang' => 'en',
                        'lang_key' => 'Product sub category',
                        'lang_value' => 'Product sub category',
                        'created_at' => '2020-11-12 10:03:46',
                        'updated_at' => '2020-11-12 10:03:46',
                    ),
                40 =>
                    array(
                        'id' => 1320,
                        'lang' => 'en',
                        'lang_key' => 'Product brand',
                        'lang_value' => 'Product brand',
                        'created_at' => '2020-11-12 10:03:46',
                        'updated_at' => '2020-11-12 10:03:46',
                    ),
                41 =>
                    array(
                        'id' => 1321,
                        'lang' => 'en',
                        'lang_key' => 'Top Client Packages',
                        'lang_value' => 'Top Client Packages',
                        'created_at' => '2020-11-12 10:05:21',
                        'updated_at' => '2020-11-12 10:05:21',
                    ),
                42 =>
                    array(
                        'id' => 1322,
                        'lang' => 'en',
                        'lang_key' => 'Top Freelancer Packages',
                        'lang_value' => 'Top Freelancer Packages',
                        'created_at' => '2020-11-12 10:05:21',
                        'updated_at' => '2020-11-12 10:05:21',
                    ),
                43 =>
                    array(
                        'id' => 1323,
                        'lang' => 'en',
                        'lang_key' => 'Number of sale',
                        'lang_value' => 'Number of sale',
                        'created_at' => '2020-11-12 11:13:09',
                        'updated_at' => '2020-11-12 11:13:09',
                    ),
                44 =>
                    array(
                        'id' => 1324,
                        'lang' => 'en',
                        'lang_key' => 'Number of Stock',
                        'lang_value' => 'Number of Stock',
                        'created_at' => '2020-11-12 11:16:02',
                        'updated_at' => '2020-11-12 11:16:02',
                    ),
                45 =>
                    array(
                        'id' => 1325,
                        'lang' => 'en',
                        'lang_key' => 'Top 10 Products',
                        'lang_value' => 'Top 10 Products',
                        'created_at' => '2020-11-12 12:02:29',
                        'updated_at' => '2020-11-12 12:02:29',
                    ),
                46 =>
                    array(
                        'id' => 1326,
                        'lang' => 'en',
                        'lang_key' => 'Top 12 Products',
                        'lang_value' => 'Top 12 Products',
                        'created_at' => '2020-11-12 12:02:39',
                        'updated_at' => '2020-11-12 12:02:39',
                    ),
                47 =>
                    array(
                        'id' => 1327,
                        'lang' => 'en',
                        'lang_key' => 'Admin can not be a seller',
                        'lang_value' => 'Admin can not be a seller',
                        'created_at' => '2020-11-12 13:30:19',
                        'updated_at' => '2020-11-12 13:30:19',
                    ),
                48 =>
                    array(
                        'id' => 1328,
                        'lang' => 'en',
                        'lang_key' => 'Filter by Rating',
                        'lang_value' => 'Filter by Rating',
                        'created_at' => '2020-11-15 10:01:15',
                        'updated_at' => '2020-11-15 10:01:15',
                    ),
                49 =>
                    array(
                        'id' => 1329,
                        'lang' => 'en',
                        'lang_key' => 'Published reviews updated successfully',
                        'lang_value' => 'Published reviews updated successfully',
                        'created_at' => '2020-11-15 10:01:15',
                        'updated_at' => '2020-11-15 10:01:15',
                    ),
                50 =>
                    array(
                        'id' => 1330,
                        'lang' => 'en',
                        'lang_key' => 'Refund Sticker has been updated successfully',
                        'lang_value' => 'Refund Sticker has been updated successfully',
                        'created_at' => '2020-11-15 10:17:12',
                        'updated_at' => '2020-11-15 10:17:12',
                    ),
                51 =>
                    array(
                        'id' => 1331,
                        'lang' => 'en',
                        'lang_key' => 'Edit Product',
                        'lang_value' => 'Edit Product',
                        'created_at' => '2020-11-15 12:31:54',
                        'updated_at' => '2020-11-15 12:31:54',
                    ),
                52 =>
                    array(
                        'id' => 1332,
                        'lang' => 'en',
                        'lang_key' => 'Meta Images',
                        'lang_value' => 'Meta Images',
                        'created_at' => '2020-11-15 12:32:12',
                        'updated_at' => '2020-11-15 12:32:12',
                    ),
                53 =>
                    array(
                        'id' => 1333,
                        'lang' => 'en',
                        'lang_key' => 'Update Product',
                        'lang_value' => 'Update Product',
                        'created_at' => '2020-11-15 12:32:12',
                        'updated_at' => '2020-11-15 12:32:12',
                    ),
                54 =>
                    array(
                        'id' => 1334,
                        'lang' => 'en',
                        'lang_key' => 'Product has been deleted successfully',
                        'lang_value' => 'Product has been deleted successfully',
                        'created_at' => '2020-11-15 12:32:57',
                        'updated_at' => '2020-11-15 12:32:57',
                    ),
                55 =>
                    array(
                        'id' => 1335,
                        'lang' => 'en',
                        'lang_key' => 'Your Profile has been updated successfully!',
                        'lang_value' => 'Your Profile has been updated successfully!',
                        'created_at' => '2020-11-15 13:10:42',
                        'updated_at' => '2020-11-15 13:10:42',
                    ),
                56 =>
                    array(
                        'id' => 1336,
                        'lang' => 'en',
                        'lang_key' => 'Upload limit has been reached. Please upgrade your package.',
                        'lang_value' => 'Upload limit has been reached. Please upgrade your package.',
                        'created_at' => '2020-11-15 13:13:45',
                        'updated_at' => '2020-11-15 13:13:45',
                    ),
                57 =>
                    array(
                        'id' => 1337,
                        'lang' => 'en',
                        'lang_key' => 'Add Your Product',
                        'lang_value' => 'Add Your Product',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                58 =>
                    array(
                        'id' => 1338,
                        'lang' => 'en',
                        'lang_key' => 'Select a category',
                        'lang_value' => 'Select a category',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                59 =>
                    array(
                        'id' => 1339,
                        'lang' => 'en',
                        'lang_key' => 'Select a brand',
                        'lang_value' => 'Select a brand',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                60 =>
                    array(
                        'id' => 1340,
                        'lang' => 'en',
                        'lang_key' => 'Product Unit',
                        'lang_value' => 'Product Unit',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                61 =>
                    array(
                        'id' => 1341,
                        'lang' => 'en',
                        'lang_key' => 'Minimum Qty.',
                        'lang_value' => 'Minimum Qty.',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                62 =>
                    array(
                        'id' => 1342,
                        'lang' => 'en',
                        'lang_key' => 'Product Tag',
                        'lang_value' => 'Product Tag',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                63 =>
                    array(
                        'id' => 1343,
                        'lang' => 'en',
                        'lang_key' => 'Type & hit enter',
                        'lang_value' => 'Type & hit enter',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                64 =>
                    array(
                        'id' => 1344,
                        'lang' => 'en',
                        'lang_key' => 'Videos',
                        'lang_value' => 'Videos',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                65 =>
                    array(
                        'id' => 1345,
                        'lang' => 'en',
                        'lang_key' => 'Video From',
                        'lang_value' => 'Video From',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                66 =>
                    array(
                        'id' => 1346,
                        'lang' => 'en',
                        'lang_key' => 'Video URL',
                        'lang_value' => 'Video URL',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                67 =>
                    array(
                        'id' => 1347,
                        'lang' => 'en',
                        'lang_key' => 'Customer Choice',
                        'lang_value' => 'Customer Choice',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                68 =>
                    array(
                        'id' => 1348,
                        'lang' => 'en',
                        'lang_key' => 'PDF',
                        'lang_value' => 'PDF',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                69 =>
                    array(
                        'id' => 1349,
                        'lang' => 'en',
                        'lang_key' => 'Choose PDF',
                        'lang_value' => 'Choose PDF',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                70 =>
                    array(
                        'id' => 1350,
                        'lang' => 'en',
                        'lang_key' => 'Select Category',
                        'lang_value' => 'Select Category',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                71 =>
                    array(
                        'id' => 1351,
                        'lang' => 'en',
                        'lang_key' => 'Target Category',
                        'lang_value' => 'Target Category',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                72 =>
                    array(
                        'id' => 1352,
                        'lang' => 'en',
                        'lang_key' => 'subsubcategory',
                        'lang_value' => 'subsubcategory',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                73 =>
                    array(
                        'id' => 1353,
                        'lang' => 'en',
                        'lang_key' => 'Search Category',
                        'lang_value' => 'Search Category',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                74 =>
                    array(
                        'id' => 1354,
                        'lang' => 'en',
                        'lang_key' => 'Search SubCategory',
                        'lang_value' => 'Search SubCategory',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                75 =>
                    array(
                        'id' => 1355,
                        'lang' => 'en',
                        'lang_key' => 'Search SubSubCategory',
                        'lang_value' => 'Search SubSubCategory',
                        'created_at' => '2020-11-15 13:17:56',
                        'updated_at' => '2020-11-15 13:17:56',
                    ),
                76 =>
                    array(
                        'id' => 1356,
                        'lang' => 'en',
                        'lang_key' => 'Update your product',
                        'lang_value' => 'Update your product',
                        'created_at' => '2020-11-15 13:39:14',
                        'updated_at' => '2020-11-15 13:39:14',
                    ),
                77 =>
                    array(
                        'id' => 1357,
                        'lang' => 'en',
                        'lang_key' => 'Product has been updated successfully',
                        'lang_value' => 'Product has been updated successfully',
                        'created_at' => '2020-11-15 13:51:36',
                        'updated_at' => '2020-11-15 13:51:36',
                    ),
                78 =>
                    array(
                        'id' => 1358,
                        'lang' => 'en',
                        'lang_key' => 'Add Your Digital Product',
                        'lang_value' => 'Add Your Digital Product',
                        'created_at' => '2020-11-15 14:24:21',
                        'updated_at' => '2020-11-15 14:24:21',
                    ),
                79 =>
                    array(
                        'id' => 1359,
                        'lang' => 'en',
                        'lang_key' => 'Active eCommerce CMS Update Process',
                        'lang_value' => 'Active eCommerce CMS Update Process',
                        'created_at' => '2020-11-16 09:53:31',
                        'updated_at' => '2020-11-16 09:53:31',
                    ),
                80 =>
                    array(
                        'id' => 1361,
                        'lang' => 'en',
                        'lang_key' => 'Codecanyon purchase code',
                        'lang_value' => 'Codecanyon purchase code',
                        'created_at' => '2020-11-16 09:53:31',
                        'updated_at' => '2020-11-16 09:53:31',
                    ),
                81 =>
                    array(
                        'id' => 1362,
                        'lang' => 'en',
                        'lang_key' => 'Database Name',
                        'lang_value' => 'Database Name',
                        'created_at' => '2020-11-16 09:53:31',
                        'updated_at' => '2020-11-16 09:53:31',
                    ),
                82 =>
                    array(
                        'id' => 1363,
                        'lang' => 'en',
                        'lang_key' => 'Database Username',
                        'lang_value' => 'Database Username',
                        'created_at' => '2020-11-16 09:53:31',
                        'updated_at' => '2020-11-16 09:53:31',
                    ),
                83 =>
                    array(
                        'id' => 1364,
                        'lang' => 'en',
                        'lang_key' => 'Database Password',
                        'lang_value' => 'Database Password',
                        'created_at' => '2020-11-16 09:53:31',
                        'updated_at' => '2020-11-16 09:53:31',
                    ),
                84 =>
                    array(
                        'id' => 1365,
                        'lang' => 'en',
                        'lang_key' => 'Database Hostname',
                        'lang_value' => 'Database Hostname',
                        'created_at' => '2020-11-16 09:53:31',
                        'updated_at' => '2020-11-16 09:53:31',
                    ),
                85 =>
                    array(
                        'id' => 1366,
                        'lang' => 'en',
                        'lang_key' => 'Update Now',
                        'lang_value' => 'Update Now',
                        'created_at' => '2020-11-16 09:53:31',
                        'updated_at' => '2020-11-16 09:53:31',
                    ),
                86 =>
                    array(
                        'id' => 1368,
                        'lang' => 'en',
                        'lang_key' => 'Congratulations',
                        'lang_value' => 'Congratulations',
                        'created_at' => '2020-11-16 09:55:14',
                        'updated_at' => '2020-11-16 09:55:14',
                    ),
                87 =>
                    array(
                        'id' => 1369,
                        'lang' => 'en',
                        'lang_key' => 'You have successfully completed the updating process. Please Login to continue',
                        'lang_value' => 'You have successfully completed the updating process. Please Login to continue',
                        'created_at' => '2020-11-16 09:55:14',
                        'updated_at' => '2020-11-16 09:55:14',
                    ),
                88 =>
                    array(
                        'id' => 1370,
                        'lang' => 'en',
                        'lang_key' => 'Go to Home',
                        'lang_value' => 'Go to Home',
                        'created_at' => '2020-11-16 09:55:14',
                        'updated_at' => '2020-11-16 09:55:14',
                    ),
                89 =>
                    array(
                        'id' => 1371,
                        'lang' => 'en',
                        'lang_key' => 'Login to Admin panel',
                        'lang_value' => 'Login to Admin panel',
                        'created_at' => '2020-11-16 09:55:14',
                        'updated_at' => '2020-11-16 09:55:14',
                    ),
                90 =>
                    array(
                        'id' => 1372,
                        'lang' => 'en',
                        'lang_key' => 'S3 File System Credentials',
                        'lang_value' => 'S3 File System Credentials',
                        'created_at' => '2020-11-16 14:59:57',
                        'updated_at' => '2020-11-16 14:59:57',
                    ),
                91 =>
                    array(
                        'id' => 1373,
                        'lang' => 'en',
                        'lang_key' => 'AWS_ACCESS_KEY_ID',
                        'lang_value' => 'AWS_ACCESS_KEY_ID',
                        'created_at' => '2020-11-16 14:59:57',
                        'updated_at' => '2020-11-16 14:59:57',
                    ),
                92 =>
                    array(
                        'id' => 1374,
                        'lang' => 'en',
                        'lang_key' => 'AWS_SECRET_ACCESS_KEY',
                        'lang_value' => 'AWS_SECRET_ACCESS_KEY',
                        'created_at' => '2020-11-16 14:59:57',
                        'updated_at' => '2020-11-16 14:59:57',
                    ),
                93 =>
                    array(
                        'id' => 1375,
                        'lang' => 'en',
                        'lang_key' => 'AWS_DEFAULT_REGION',
                        'lang_value' => 'AWS_DEFAULT_REGION',
                        'created_at' => '2020-11-16 14:59:57',
                        'updated_at' => '2020-11-16 14:59:57',
                    ),
                94 =>
                    array(
                        'id' => 1376,
                        'lang' => 'en',
                        'lang_key' => 'AWS_BUCKET',
                        'lang_value' => 'AWS_BUCKET',
                        'created_at' => '2020-11-16 14:59:57',
                        'updated_at' => '2020-11-16 14:59:57',
                    ),
                95 =>
                    array(
                        'id' => 1377,
                        'lang' => 'en',
                        'lang_key' => 'AWS_URL',
                        'lang_value' => 'AWS_URL',
                        'created_at' => '2020-11-16 14:59:57',
                        'updated_at' => '2020-11-16 14:59:57',
                    ),
                96 =>
                    array(
                        'id' => 1378,
                        'lang' => 'en',
                        'lang_key' => 'S3 File System Activation',
                        'lang_value' => 'S3 File System Activation',
                        'created_at' => '2020-11-16 14:59:57',
                        'updated_at' => '2020-11-16 14:59:57',
                    ),
                97 =>
                    array(
                        'id' => 1379,
                        'lang' => 'en',
                        'lang_key' => 'Your phone number',
                        'lang_value' => 'Your phone number',
                        'created_at' => '2020-11-17 07:50:10',
                        'updated_at' => '2020-11-17 07:50:10',
                    ),
                98 =>
                    array(
                        'id' => 1380,
                        'lang' => 'en',
                        'lang_key' => 'Zip File',
                        'lang_value' => 'Zip File',
                        'created_at' => '2020-11-17 08:58:45',
                        'updated_at' => '2020-11-17 08:58:45',
                    ),
                99 =>
                    array(
                        'id' => 1381,
                        'lang' => 'en',
                        'lang_key' => 'Install',
                        'lang_value' => 'Install',
                        'created_at' => '2020-11-17 08:58:45',
                        'updated_at' => '2020-11-17 08:58:45',
                    ),
                100 =>
                    array(
                        'id' => 1382,
                        'lang' => 'en',
                        'lang_key' => 'This version is not capable of installing Addons, Please update.',
                        'lang_value' => 'This version is not capable of installing Addons, Please update.',
                        'created_at' => '2020-11-17 08:59:11',
                        'updated_at' => '2020-11-17 08:59:11',
                    ),
                101 =>
                    array(
                        'id' => 1383,
                        'lang' => 'en',
                        'lang_key' => 'Browse All Categories',
                        'lang_value' => 'Browse All Categories',
                        'created_at' => '2021-02-09 11:01:58',
                        'updated_at' => '2021-02-09 11:01:58',
                    ),
                102 =>
                    array(
                        'id' => 1384,
                        'lang' => 'en',
                        'lang_key' => 'Find Our Locations',
                        'lang_value' => 'Find Our Locations',
                        'created_at' => '2021-02-09 11:01:58',
                        'updated_at' => '2021-02-09 11:01:58',
                    ),
                103 =>
                    array(
                        'id' => 1385,
                        'lang' => 'en',
                        'lang_key' => 'To Get More Emersive',
                        'lang_value' => 'To Get More Emersive',
                        'created_at' => '2021-02-09 11:01:58',
                        'updated_at' => '2021-02-09 11:01:58',
                    ),
                104 =>
                    array(
                        'id' => 1386,
                        'lang' => 'en',
                        'lang_key' => 'Something went wrong!',
                        'lang_value' => 'Something went wrong!',
                        'created_at' => '2021-04-08 12:02:28',
                        'updated_at' => '2021-04-08 12:02:28',
                    ),
                105 =>
                    array(
                        'id' => 1387,
                        'lang' => 'en',
                        'lang_key' => 'Sorry for the inconvenience, but we\'re working on it.',
                        'lang_value' => 'Sorry for the inconvenience, but we\'re working on it.',
                        'created_at' => '2021-04-08 12:02:28',
                        'updated_at' => '2021-04-08 12:02:28',
                    ),
                106 =>
                    array(
                        'id' => 1388,
                        'lang' => 'en',
                        'lang_key' => 'Error code',
                        'lang_value' => 'Error code',
                        'created_at' => '2021-04-08 12:02:28',
                        'updated_at' => '2021-04-08 12:02:28',
                    ),
                107 =>
                    array(
                        'id' => 1389,
                        'lang' => 'en',
                        'lang_key' => 'Nothing found',
                        'lang_value' => 'Nothing found',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                108 =>
                    array(
                        'id' => 1390,
                        'lang' => 'en',
                        'lang_key' => 'File selected',
                        'lang_value' => 'File selected',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                109 =>
                    array(
                        'id' => 1391,
                        'lang' => 'en',
                        'lang_key' => 'Files selected',
                        'lang_value' => 'Files selected',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                110 =>
                    array(
                        'id' => 1392,
                        'lang' => 'en',
                        'lang_key' => 'Add more files',
                        'lang_value' => 'Add more files',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                111 =>
                    array(
                        'id' => 1393,
                        'lang' => 'en',
                        'lang_key' => 'Adding more files',
                        'lang_value' => 'Adding more files',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                112 =>
                    array(
                        'id' => 1394,
                        'lang' => 'en',
                        'lang_key' => 'Drop files here, paste or',
                        'lang_value' => 'Drop files here, paste or',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                113 =>
                    array(
                        'id' => 1395,
                        'lang' => 'en',
                        'lang_key' => 'Upload complete',
                        'lang_value' => 'Upload complete',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                114 =>
                    array(
                        'id' => 1396,
                        'lang' => 'en',
                        'lang_key' => 'Upload paused',
                        'lang_value' => 'Upload paused',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                115 =>
                    array(
                        'id' => 1397,
                        'lang' => 'en',
                        'lang_key' => 'Resume upload',
                        'lang_value' => 'Resume upload',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                116 =>
                    array(
                        'id' => 1398,
                        'lang' => 'en',
                        'lang_key' => 'Pause upload',
                        'lang_value' => 'Pause upload',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                117 =>
                    array(
                        'id' => 1399,
                        'lang' => 'en',
                        'lang_key' => 'Retry upload',
                        'lang_value' => 'Retry upload',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                118 =>
                    array(
                        'id' => 1400,
                        'lang' => 'en',
                        'lang_key' => 'Cancel upload',
                        'lang_value' => 'Cancel upload',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                119 =>
                    array(
                        'id' => 1401,
                        'lang' => 'en',
                        'lang_key' => 'Uploading',
                        'lang_value' => 'Uploading',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                120 =>
                    array(
                        'id' => 1402,
                        'lang' => 'en',
                        'lang_key' => 'Processing',
                        'lang_value' => 'Processing',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                121 =>
                    array(
                        'id' => 1403,
                        'lang' => 'en',
                        'lang_key' => 'Complete',
                        'lang_value' => 'Complete',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                122 =>
                    array(
                        'id' => 1404,
                        'lang' => 'en',
                        'lang_key' => 'Files',
                        'lang_value' => 'Files',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                123 =>
                    array(
                        'id' => 1405,
                        'lang' => 'en',
                        'lang_key' => 'Blogs',
                        'lang_value' => 'Blogs',
                        'created_at' => '2021-04-08 12:03:31',
                        'updated_at' => '2021-04-08 12:03:31',
                    ),
                124 =>
                    array(
                        'id' => 1406,
                        'lang' => 'en',
                        'lang_key' => 'View All Sellers',
                        'lang_value' => 'View All Sellers',
                        'created_at' => '2021-04-08 12:06:51',
                        'updated_at' => '2021-04-08 12:06:51',
                    ),
                125 =>
                    array(
                        'id' => 1407,
                        'lang' => 'en',
                        'lang_key' => 'Use Phone Instead',
                        'lang_value' => 'Use Phone Instead',
                        'created_at' => '2021-04-08 12:10:27',
                        'updated_at' => '2021-04-08 12:10:27',
                    ),
                126 =>
                    array(
                        'id' => 1408,
                        'lang' => 'en',
                        'lang_key' => 'Please Configure SMTP Setting to work all email sending functionality',
                        'lang_value' => 'Please Configure SMTP Setting to work all email sending functionality',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                127 =>
                    array(
                        'id' => 1409,
                        'lang' => 'en',
                        'lang_key' => 'Order',
                        'lang_value' => 'Order',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                128 =>
                    array(
                        'id' => 1410,
                        'lang' => 'en',
                        'lang_key' => 'Search in menu',
                        'lang_value' => 'Search in menu',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                129 =>
                    array(
                        'id' => 1411,
                        'lang' => 'en',
                        'lang_key' => 'Uploaded Files',
                        'lang_value' => 'Uploaded Files',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                130 =>
                    array(
                        'id' => 1412,
                        'lang' => 'en',
                        'lang_key' => 'Commission History',
                        'lang_value' => 'Commission History',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                131 =>
                    array(
                        'id' => 1413,
                        'lang' => 'en',
                        'lang_key' => 'Wallet Recharge History',
                        'lang_value' => 'Wallet Recharge History',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                132 =>
                    array(
                        'id' => 1414,
                        'lang' => 'en',
                        'lang_key' => 'Blog System',
                        'lang_value' => 'Blog System',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                133 =>
                    array(
                        'id' => 1415,
                        'lang' => 'en',
                        'lang_key' => 'All Posts',
                        'lang_value' => 'All Posts',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                134 =>
                    array(
                        'id' => 1416,
                        'lang' => 'en',
                        'lang_key' => 'Vat & TAX',
                        'lang_value' => 'Vat & TAX',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                135 =>
                    array(
                        'id' => 1417,
                        'lang' => 'en',
                        'lang_key' => 'Facebook Comment',
                        'lang_value' => 'Facebook Comment',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                136 =>
                    array(
                        'id' => 1418,
                        'lang' => 'en',
                        'lang_key' => 'Shipping Cities',
                        'lang_value' => 'Shipping Cities',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                137 =>
                    array(
                        'id' => 1419,
                        'lang' => 'en',
                        'lang_key' => 'System',
                        'lang_value' => 'System',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                138 =>
                    array(
                        'id' => 1420,
                        'lang' => 'en',
                        'lang_key' => 'Server status',
                        'lang_value' => 'Server status',
                        'created_at' => '2021-04-08 12:10:41',
                        'updated_at' => '2021-04-08 12:10:41',
                    ),
                139 =>
                    array(
                        'id' => 1421,
                        'lang' => 'en',
                        'lang_key' => 'This is used for search. Input those words by which cutomer can find this product.',
                        'lang_value' => 'This is used for search. Input those words by which cutomer can find this product.',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                140 =>
                    array(
                        'id' => 1422,
                        'lang' => 'en',
                        'lang_key' => 'These images are visible in product details page gallery. Use 600x600 sizes images.',
                        'lang_value' => 'These images are visible in product details page gallery. Use 600x600 sizes images.',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                141 =>
                    array(
                        'id' => 1423,
                        'lang' => 'en',
                        'lang_key' => 'This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.',
                        'lang_value' => 'This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                142 =>
                    array(
                        'id' => 1424,
                        'lang' => 'en',
                        'lang_key' => 'Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.',
                        'lang_value' => 'Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                143 =>
                    array(
                        'id' => 1425,
                        'lang' => 'en',
                        'lang_key' => 'Product Wise Shipping',
                        'lang_value' => 'Product Wise Shipping',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                144 =>
                    array(
                        'id' => 1426,
                        'lang' => 'en',
                        'lang_key' => 'Is Product Quantity Mulitiply',
                        'lang_value' => 'Is Product Quantity Mulitiply',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                145 =>
                    array(
                        'id' => 1427,
                        'lang' => 'en',
                        'lang_key' => 'Low Stock Quantity Warning',
                        'lang_value' => 'Low Stock Quantity Warning',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                146 =>
                    array(
                        'id' => 1428,
                        'lang' => 'en',
                        'lang_key' => 'Stock Visibility State',
                        'lang_value' => 'Stock Visibility State',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                147 =>
                    array(
                        'id' => 1429,
                        'lang' => 'en',
                        'lang_key' => 'Show Stock Quantity',
                        'lang_value' => 'Show Stock Quantity',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                148 =>
                    array(
                        'id' => 1430,
                        'lang' => 'en',
                        'lang_key' => 'Show Stock With Text Only',
                        'lang_value' => 'Show Stock With Text Only',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                149 =>
                    array(
                        'id' => 1431,
                        'lang' => 'en',
                        'lang_key' => 'Hide Stock',
                        'lang_value' => 'Hide Stock',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                150 =>
                    array(
                        'id' => 1432,
                        'lang' => 'en',
                        'lang_key' => 'Flash Deal',
                        'lang_value' => 'Flash Deal',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                151 =>
                    array(
                        'id' => 1433,
                        'lang' => 'en',
                        'lang_key' => 'Add To Flash',
                        'lang_value' => 'Add To Flash',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                152 =>
                    array(
                        'id' => 1434,
                        'lang' => 'en',
                        'lang_key' => 'Estimate Shipping Time',
                        'lang_value' => 'Estimate Shipping Time',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                153 =>
                    array(
                        'id' => 1435,
                        'lang' => 'en',
                        'lang_key' => 'Shipping Days',
                        'lang_value' => 'Shipping Days',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                154 =>
                    array(
                        'id' => 1436,
                        'lang' => 'en',
                        'lang_key' => 'Save As Draft',
                        'lang_value' => 'Save As Draft',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                155 =>
                    array(
                        'id' => 1437,
                        'lang' => 'en',
                        'lang_key' => 'Save & Unpublish',
                        'lang_value' => 'Save & Unpublish',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                156 =>
                    array(
                        'id' => 1438,
                        'lang' => 'en',
                        'lang_key' => 'Save & Publish',
                        'lang_value' => 'Save & Publish',
                        'created_at' => '2021-04-08 12:10:50',
                        'updated_at' => '2021-04-08 12:10:50',
                    ),
                157 =>
                    array(
                        'id' => 1439,
                        'lang' => 'en',
                        'lang_key' => 'Add New Seller',
                        'lang_value' => 'Add New Seller',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                158 =>
                    array(
                        'id' => 1440,
                        'lang' => 'en',
                        'lang_key' => 'Filter by Approval',
                        'lang_value' => 'Filter by Approval',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                159 =>
                    array(
                        'id' => 1441,
                        'lang' => 'en',
                        'lang_key' => 'Non-Approved',
                        'lang_value' => 'Non-Approved',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                160 =>
                    array(
                        'id' => 1442,
                        'lang' => 'en',
                        'lang_key' => 'Type name or email & Enter',
                        'lang_value' => 'Type name or email & Enter',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                161 =>
                    array(
                        'id' => 1443,
                        'lang' => 'en',
                        'lang_key' => 'Due to seller',
                        'lang_value' => 'Due to seller',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                162 =>
                    array(
                        'id' => 1444,
                        'lang' => 'en',
                        'lang_key' => 'Log in as this Seller',
                        'lang_value' => 'Log in as this Seller',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                163 =>
                    array(
                        'id' => 1445,
                        'lang' => 'en',
                        'lang_key' => 'Go to Payment',
                        'lang_value' => 'Go to Payment',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                164 =>
                    array(
                        'id' => 1446,
                        'lang' => 'en',
                        'lang_key' => 'Ban this seller',
                        'lang_value' => 'Ban this seller',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                165 =>
                    array(
                        'id' => 1447,
                        'lang' => 'en',
                        'lang_key' => 'Do you really want to ban this seller?',
                        'lang_value' => 'Do you really want to ban this seller?',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                166 =>
                    array(
                        'id' => 1448,
                        'lang' => 'en',
                        'lang_key' => 'Proceed!',
                        'lang_value' => 'Proceed!',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                167 =>
                    array(
                        'id' => 1449,
                        'lang' => 'en',
                        'lang_key' => 'Approved sellers updated successfully',
                        'lang_value' => 'Approved sellers updated successfully',
                        'created_at' => '2021-04-08 12:11:08',
                        'updated_at' => '2021-04-08 12:11:08',
                    ),
                168 =>
                    array(
                        'id' => 1450,
                        'lang' => 'en',
                        'lang_key' => 'Shop Info',
                        'lang_value' => 'Shop Info',
                        'created_at' => '2021-04-08 12:11:11',
                        'updated_at' => '2021-04-08 12:11:11',
                    ),
                169 =>
                    array(
                        'id' => 1451,
                        'lang' => 'en',
                        'lang_key' => 'About',
                        'lang_value' => 'About',
                        'created_at' => '2021-04-08 12:11:22',
                        'updated_at' => '2021-04-08 12:11:22',
                    ),
                170 =>
                    array(
                        'id' => 1452,
                        'lang' => 'en',
                        'lang_key' => 'Payout Info',
                        'lang_value' => 'Payout Info',
                        'created_at' => '2021-04-08 12:11:22',
                        'updated_at' => '2021-04-08 12:11:22',
                    ),
                171 =>
                    array(
                        'id' => 1453,
                        'lang' => 'en',
                        'lang_key' => 'Bank Acc Name',
                        'lang_value' => 'Bank Acc Name',
                        'created_at' => '2021-04-08 12:11:22',
                        'updated_at' => '2021-04-08 12:11:22',
                    ),
                172 =>
                    array(
                        'id' => 1454,
                        'lang' => 'en',
                        'lang_key' => 'Bank Acc Number',
                        'lang_value' => 'Bank Acc Number',
                        'created_at' => '2021-04-08 12:11:22',
                        'updated_at' => '2021-04-08 12:11:22',
                    ),
                173 =>
                    array(
                        'id' => 1455,
                        'lang' => 'en',
                        'lang_key' => 'Total Products',
                        'lang_value' => 'Total Products',
                        'created_at' => '2021-04-08 12:11:22',
                        'updated_at' => '2021-04-08 12:11:22',
                    ),
                174 =>
                    array(
                        'id' => 1456,
                        'lang' => 'en',
                        'lang_key' => 'Total Sold Amount',
                        'lang_value' => 'Total Sold Amount',
                        'created_at' => '2021-04-08 12:11:22',
                        'updated_at' => '2021-04-08 12:11:22',
                    ),
                175 =>
                    array(
                        'id' => 1457,
                        'lang' => 'en',
                        'lang_key' => 'Wallet Balance',
                        'lang_value' => 'Wallet Balance',
                        'created_at' => '2021-04-08 12:11:22',
                        'updated_at' => '2021-04-08 12:11:22',
                    ),
                176 =>
                    array(
                        'id' => 1458,
                        'lang' => 'en',
                        'lang_key' => 'Seller Information',
                        'lang_value' => 'Seller Information',
                        'created_at' => '2021-04-08 12:11:41',
                        'updated_at' => '2021-04-08 12:11:41',
                    ),
                177 =>
                    array(
                        'id' => 1459,
                        'lang' => 'en',
                        'lang_key' => 'Seller has been inserted successfully',
                        'lang_value' => 'Seller has been inserted successfully',
                        'created_at' => '2021-04-08 12:11:52',
                        'updated_at' => '2021-04-08 12:11:52',
                    ),
                178 =>
                    array(
                        'id' => 1460,
                        'lang' => 'en',
                        'lang_key' => 'Edit Seller Information',
                        'lang_value' => 'Edit Seller Information',
                        'created_at' => '2021-04-08 12:11:59',
                        'updated_at' => '2021-04-08 12:11:59',
                    ),
                179 =>
                    array(
                        'id' => 1461,
                        'lang' => 'en',
                        'lang_key' => 'Add New Post',
                        'lang_value' => 'Add New Post',
                        'created_at' => '2021-04-08 12:12:13',
                        'updated_at' => '2021-04-08 12:12:13',
                    ),
                180 =>
                    array(
                        'id' => 1462,
                        'lang' => 'en',
                        'lang_key' => 'All blog posts',
                        'lang_value' => 'All blog posts',
                        'created_at' => '2021-04-08 12:12:13',
                        'updated_at' => '2021-04-08 12:12:13',
                    ),
                181 =>
                    array(
                        'id' => 1463,
                        'lang' => 'en',
                        'lang_key' => 'Short Description',
                        'lang_value' => 'Short Description',
                        'created_at' => '2021-04-08 12:12:14',
                        'updated_at' => '2021-04-08 12:12:14',
                    ),
                182 =>
                    array(
                        'id' => 1464,
                        'lang' => 'en',
                        'lang_key' => 'Change blog status successfully',
                        'lang_value' => 'Change blog status successfully',
                        'created_at' => '2021-04-08 12:12:14',
                        'updated_at' => '2021-04-08 12:12:14',
                    ),
                183 =>
                    array(
                        'id' => 1465,
                        'lang' => 'en',
                        'lang_key' => 'Blog Information',
                        'lang_value' => 'Blog Information',
                        'created_at' => '2021-04-08 12:12:16',
                        'updated_at' => '2021-04-08 12:12:16',
                    ),
                184 =>
                    array(
                        'id' => 1466,
                        'lang' => 'en',
                        'lang_key' => 'Blog Title',
                        'lang_value' => 'Blog Title',
                        'created_at' => '2021-04-08 12:12:16',
                        'updated_at' => '2021-04-08 12:12:16',
                    ),
                185 =>
                    array(
                        'id' => 1467,
                        'lang' => 'en',
                        'lang_key' => 'Meta Keywords',
                        'lang_value' => 'Meta Keywords',
                        'created_at' => '2021-04-08 12:12:16',
                        'updated_at' => '2021-04-08 12:12:16',
                    ),
                186 =>
                    array(
                        'id' => 1468,
                        'lang' => 'en',
                        'lang_key' => 'Install/Update Addon',
                        'lang_value' => 'Install/Update Addon',
                        'created_at' => '2021-04-08 12:12:23',
                        'updated_at' => '2021-04-08 12:12:23',
                    ),
                187 =>
                    array(
                        'id' => 1469,
                        'lang' => 'en',
                        'lang_key' => 'No Addon Installed',
                        'lang_value' => 'No Addon Installed',
                        'created_at' => '2021-04-08 12:12:23',
                        'updated_at' => '2021-04-08 12:12:23',
                    ),
                188 =>
                    array(
                        'id' => 1470,
                        'lang' => 'en',
                        'lang_key' => 'Install/Update',
                        'lang_value' => 'Install/Update',
                        'created_at' => '2021-04-08 12:12:27',
                        'updated_at' => '2021-04-08 12:12:27',
                    ),
                189 =>
                    array(
                        'id' => 1471,
                        'lang' => 'en',
                        'lang_key' => 'Step 1',
                        'lang_value' => 'Step 1',
                        'created_at' => '2021-04-08 12:13:48',
                        'updated_at' => '2021-04-08 12:13:48',
                    ),
                190 =>
                    array(
                        'id' => 1472,
                        'lang' => 'en',
                        'lang_key' => 'Download the skeleton file and fill it with proper data',
                        'lang_value' => 'Download the skeleton file and fill it with proper data',
                        'created_at' => '2021-04-08 12:13:48',
                        'updated_at' => '2021-04-08 12:13:48',
                    ),
                191 =>
                    array(
                        'id' => 1473,
                        'lang' => 'en',
                        'lang_key' => 'You can download the example file to understand how the data must be filled',
                        'lang_value' => 'You can download the example file to understand how the data must be filled',
                        'created_at' => '2021-04-08 12:13:48',
                        'updated_at' => '2021-04-08 12:13:48',
                    ),
                192 =>
                    array(
                        'id' => 1474,
                        'lang' => 'en',
                        'lang_key' => 'Once you have downloaded and filled the skeleton file, upload it in the form below and submit',
                        'lang_value' => 'Once you have downloaded and filled the skeleton file, upload it in the form below and submit',
                        'created_at' => '2021-04-08 12:13:48',
                        'updated_at' => '2021-04-08 12:13:48',
                    ),
                193 =>
                    array(
                        'id' => 1475,
                        'lang' => 'en',
                        'lang_key' => 'After uploading products you need to edit them and set product\'s images and choices',
                        'lang_value' => 'After uploading products you need to edit them and set product\'s images and choices',
                        'created_at' => '2021-04-08 12:13:48',
                        'updated_at' => '2021-04-08 12:13:48',
                    ),
                194 =>
                    array(
                        'id' => 1476,
                        'lang' => 'en',
                        'lang_key' => 'Step 2',
                        'lang_value' => 'Step 2',
                        'created_at' => '2021-04-08 12:13:48',
                        'updated_at' => '2021-04-08 12:13:48',
                    ),
                195 =>
                    array(
                        'id' => 1477,
                        'lang' => 'en',
                        'lang_key' => 'Category and Brand should be in numerical id',
                        'lang_value' => 'Category and Brand should be in numerical id',
                        'created_at' => '2021-04-08 12:13:48',
                        'updated_at' => '2021-04-08 12:13:48',
                    ),
                196 =>
                    array(
                        'id' => 1478,
                        'lang' => 'en',
                        'lang_key' => 'You can download the pdf to get Category and Brand id',
                        'lang_value' => 'You can download the pdf to get Category and Brand id',
                        'created_at' => '2021-04-08 12:13:48',
                        'updated_at' => '2021-04-08 12:13:48',
                    ),
                197 =>
                    array(
                        'id' => 1479,
                        'lang' => 'en',
                        'lang_key' => 'Upload Product File',
                        'lang_value' => 'Upload Product File',
                        'created_at' => '2021-04-08 12:13:48',
                        'updated_at' => '2021-04-08 12:13:48',
                    ),
                198 =>
                    array(
                        'id' => 1480,
                        'lang' => 'en',
                        'lang_key' => 'Header Nav Menu',
                        'lang_value' => 'Header Nav Menu',
                        'created_at' => '2021-04-08 12:17:18',
                        'updated_at' => '2021-04-08 12:17:18',
                    ),
                199 =>
                    array(
                        'id' => 1481,
                        'lang' => 'en',
                        'lang_key' => 'Link with',
                        'lang_value' => 'Link with',
                        'created_at' => '2021-04-08 12:17:18',
                        'updated_at' => '2021-04-08 12:17:18',
                    ),
                200 =>
                    array(
                        'id' => 1482,
                        'lang' => 'en',
                        'lang_key' => 'Search your files',
                        'lang_value' => 'Search your files',
                        'created_at' => '2021-04-08 12:17:20',
                        'updated_at' => '2021-04-08 12:17:20',
                    ),
                201 =>
                    array(
                        'id' => 1483,
                        'lang' => 'en',
                        'lang_key' => 'Product has been inserted successfully',
                        'lang_value' => 'Product has been inserted successfully',
                        'created_at' => '2021-04-08 12:23:15',
                        'updated_at' => '2021-04-08 12:23:15',
                    ),
                202 =>
                    array(
                        'id' => 1484,
                        'lang' => 'en',
                        'lang_key' => 'Info',
                        'lang_value' => 'Info',
                        'created_at' => '2021-04-08 12:23:16',
                        'updated_at' => '2021-04-08 12:23:16',
                    ),
                203 =>
                    array(
                        'id' => 1485,
                        'lang' => 'en',
                        'lang_key' => 'Link copied to clipboard',
                        'lang_value' => 'Link copied to clipboard',
                        'created_at' => '2021-04-08 12:23:35',
                        'updated_at' => '2021-04-08 12:23:35',
                    ),
                204 =>
                    array(
                        'id' => 1486,
                        'lang' => 'en',
                        'lang_key' => 'Oops, unable to copy',
                        'lang_value' => 'Oops, unable to copy',
                        'created_at' => '2021-04-08 12:23:35',
                        'updated_at' => '2021-04-08 12:23:35',
                    ),
                205 =>
                    array(
                        'id' => 1487,
                        'lang' => 'en',
                        'lang_key' => 'Translatable',
                        'lang_value' => 'Translatable',
                        'created_at' => '2021-04-08 12:23:54',
                        'updated_at' => '2021-04-08 12:23:54',
                    ),
                206 =>
                    array(
                        'id' => 1488,
                        'lang' => 'en',
                        'lang_key' => 'Message has been send to seller',
                        'lang_value' => 'Message has been send to seller',
                        'created_at' => '2021-04-08 12:25:18',
                        'updated_at' => '2021-04-08 12:25:18',
                    ),
                207 =>
                    array(
                        'id' => 1489,
                        'lang' => 'en',
                        'lang_key' => 'All Blog Categories',
                        'lang_value' => 'All Blog Categories',
                        'created_at' => '2021-04-08 12:25:35',
                        'updated_at' => '2021-04-08 12:25:35',
                    ),
                208 =>
                    array(
                        'id' => 1490,
                        'lang' => 'en',
                        'lang_key' => 'Blog Categories',
                        'lang_value' => 'Blog Categories',
                        'created_at' => '2021-04-08 12:25:35',
                        'updated_at' => '2021-04-08 12:25:35',
                    ),
                209 =>
                    array(
                        'id' => 1491,
                        'lang' => 'en',
                        'lang_key' => 'Blog Category Information',
                        'lang_value' => 'Blog Category Information',
                        'created_at' => '2021-04-08 12:25:37',
                        'updated_at' => '2021-04-08 12:25:37',
                    ),
                210 =>
                    array(
                        'id' => 1492,
                        'lang' => 'en',
                        'lang_key' => 'Blog category has been created successfully',
                        'lang_value' => 'Blog category has been created successfully',
                        'created_at' => '2021-04-08 12:25:55',
                        'updated_at' => '2021-04-08 12:25:55',
                    ),
                211 =>
                    array(
                        'id' => 1493,
                        'lang' => 'en',
                        'lang_key' => 'Blog post has been created successfully',
                        'lang_value' => 'Blog post has been created successfully',
                        'created_at' => '2021-04-08 12:26:19',
                        'updated_at' => '2021-04-08 12:26:19',
                    ),
                212 =>
                    array(
                        'id' => 1494,
                        'lang' => 'en',
                        'lang_key' => 'Blog',
                        'lang_value' => 'Blog',
                        'created_at' => '2021-04-08 12:26:31',
                        'updated_at' => '2021-04-08 12:26:31',
                    ),
                213 =>
                    array(
                        'id' => 1495,
                        'lang' => 'en',
                        'lang_key' => 'Blog post has been updated successfully',
                        'lang_value' => 'Blog post has been updated successfully',
                        'created_at' => '2021-04-08 12:27:13',
                        'updated_at' => '2021-04-08 12:27:13',
                    ),
                214 =>
                    array(
                        'id' => 1496,
                        'lang' => 'en',
                        'lang_key' => 'Your Shop has been created successfully!',
                        'lang_value' => 'Your Shop has been created successfully!',
                        'created_at' => '2021-04-08 12:30:46',
                        'updated_at' => '2021-04-08 12:30:46',
                    ),
                215 =>
                    array(
                        'id' => 1497,
                        'lang' => 'en',
                        'lang_key' => 'Shop Logo',
                        'lang_value' => 'Shop Logo',
                        'created_at' => '2021-04-08 12:30:46',
                        'updated_at' => '2021-04-08 12:30:46',
                    ),
                216 =>
                    array(
                        'id' => 1498,
                        'lang' => 'en',
                        'lang_key' => 'Shop Address',
                        'lang_value' => 'Shop Address',
                        'created_at' => '2021-04-08 12:30:46',
                        'updated_at' => '2021-04-08 12:30:46',
                    ),
                217 =>
                    array(
                        'id' => 1499,
                        'lang' => 'en',
                        'lang_key' => 'Banner Settings',
                        'lang_value' => 'Banner Settings',
                        'created_at' => '2021-04-08 12:30:46',
                        'updated_at' => '2021-04-08 12:30:46',
                    ),
                218 =>
                    array(
                        'id' => 1500,
                        'lang' => 'en',
                        'lang_key' => 'Banners',
                        'lang_value' => 'Banners',
                        'created_at' => '2021-04-08 12:30:46',
                        'updated_at' => '2021-04-08 12:30:46',
                    ),
                219 =>
                    array(
                        'id' => 1501,
                        'lang' => 'en',
                        'lang_key' => 'We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.',
                        'lang_value' => 'We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.',
                        'created_at' => '2021-04-08 12:30:46',
                        'updated_at' => '2021-04-08 12:30:46',
                    ),
                220 =>
                    array(
                        'id' => 1502,
                        'lang' => 'en',
                        'lang_key' => 'Insert link with https ',
                        'lang_value' => 'Insert link with https ',
                        'created_at' => '2021-04-08 12:30:46',
                        'updated_at' => '2021-04-08 12:30:46',
                    ),
                221 =>
                    array(
                        'id' => 1503,
                        'lang' => 'en',
                        'lang_key' => 'Verify Now',
                        'lang_value' => 'Verify Now',
                        'created_at' => '2021-04-08 12:30:58',
                        'updated_at' => '2021-04-08 12:30:58',
                    ),
                222 =>
                    array(
                        'id' => 1504,
                        'lang' => 'en',
                        'lang_key' => 'Uplaod Product',
                        'lang_value' => 'Uplaod Product',
                        'created_at' => '2021-04-08 12:31:49',
                        'updated_at' => '2021-04-08 12:31:49',
                    ),
                223 =>
                    array(
                        'id' => 1505,
                        'lang' => 'en',
                        'lang_key' => 'You do not have enough balance to send withdraw request',
                        'lang_value' => 'You do not have enough balance to send withdraw request',
                        'created_at' => '2021-04-08 12:33:19',
                        'updated_at' => '2021-04-08 12:33:19',
                    ),
                224 =>
                    array(
                        'id' => 1506,
                        'lang' => 'en',
                        'lang_key' => 'Shop Verification',
                        'lang_value' => 'Shop Verification',
                        'created_at' => '2021-04-08 12:35:22',
                        'updated_at' => '2021-04-08 12:35:22',
                    ),
                225 =>
                    array(
                        'id' => 1507,
                        'lang' => 'en',
                        'lang_key' => 'You have subscribed successfully',
                        'lang_value' => 'You have subscribed successfully',
                        'created_at' => '2021-04-08 12:36:52',
                        'updated_at' => '2021-04-08 12:36:52',
                    ),
                226 =>
                    array(
                        'id' => 1508,
                        'lang' => 'en',
                        'lang_key' => 'Ticket has been sent successfully',
                        'lang_value' => 'Ticket has been sent successfully',
                        'created_at' => '2021-04-08 12:38:20',
                        'updated_at' => '2021-04-08 12:38:20',
                    ),
                227 =>
                    array(
                        'id' => 1509,
                        'lang' => 'en',
                        'lang_key' => 'Send Reply',
                        'lang_value' => 'Send Reply',
                        'created_at' => '2021-04-08 12:38:24',
                        'updated_at' => '2021-04-08 12:38:24',
                    ),
                228 =>
                    array(
                        'id' => 1510,
                        'lang' => 'en',
                        'lang_key' => 'Reply has been sent successfully',
                        'lang_value' => 'Reply has been sent successfully',
                        'created_at' => '2021-04-08 12:38:48',
                        'updated_at' => '2021-04-08 12:38:48',
                    ),
                229 =>
                    array(
                        'id' => 1511,
                        'lang' => 'en',
                        'lang_key' => 'Daterange',
                        'lang_value' => 'Daterange',
                        'created_at' => '2021-04-08 12:38:52',
                        'updated_at' => '2021-04-08 12:38:52',
                    ),
                230 =>
                    array(
                        'id' => 1512,
                        'lang' => 'en',
                        'lang_key' => 'Admin Commission',
                        'lang_value' => 'Admin Commission',
                        'created_at' => '2021-04-08 12:38:52',
                        'updated_at' => '2021-04-08 12:38:52',
                    ),
                231 =>
                    array(
                        'id' => 1513,
                        'lang' => 'en',
                        'lang_key' => 'Seller Earning',
                        'lang_value' => 'Seller Earning',
                        'created_at' => '2021-04-08 12:38:52',
                        'updated_at' => '2021-04-08 12:38:52',
                    ),
                232 =>
                    array(
                        'id' => 1514,
                        'lang' => 'en',
                        'lang_key' => 'Created At',
                        'lang_value' => 'Created At',
                        'created_at' => '2021-04-08 12:38:52',
                        'updated_at' => '2021-04-08 12:38:52',
                    ),
                233 =>
                    array(
                        'id' => 1515,
                        'lang' => 'en',
                        'lang_key' => 'Update your system',
                        'lang_value' => 'Update your system',
                        'created_at' => '2021-04-08 12:40:09',
                        'updated_at' => '2021-04-08 12:40:09',
                    ),
                234 =>
                    array(
                        'id' => 1516,
                        'lang' => 'en',
                        'lang_key' => 'Current verion',
                        'lang_value' => 'Current verion',
                        'created_at' => '2021-04-08 12:40:09',
                        'updated_at' => '2021-04-08 12:40:09',
                    ),
                235 =>
                    array(
                        'id' => 1517,
                        'lang' => 'en',
                        'lang_key' => 'Make sure your server has matched with all requirements.',
                        'lang_value' => 'Make sure your server has matched with all requirements.',
                        'created_at' => '2021-04-08 12:40:09',
                        'updated_at' => '2021-04-08 12:40:09',
                    ),
                236 =>
                    array(
                        'id' => 1518,
                        'lang' => 'en',
                        'lang_key' => 'Check Here',
                        'lang_value' => 'Check Here',
                        'created_at' => '2021-04-08 12:40:09',
                        'updated_at' => '2021-04-08 12:40:09',
                    ),
                237 =>
                    array(
                        'id' => 1519,
                        'lang' => 'en',
                        'lang_key' => 'Download latest version from codecanyon.',
                        'lang_value' => 'Download latest version from codecanyon.',
                        'created_at' => '2021-04-08 12:40:09',
                        'updated_at' => '2021-04-08 12:40:09',
                    ),
                238 =>
                    array(
                        'id' => 1520,
                        'lang' => 'en',
                        'lang_key' => 'Extract downloaded zip. You will find updates.zip file in those extraced files.',
                        'lang_value' => 'Extract downloaded zip. You will find updates.zip file in those extraced files.',
                        'created_at' => '2021-04-08 12:40:09',
                        'updated_at' => '2021-04-08 12:40:09',
                    ),
                239 =>
                    array(
                        'id' => 1521,
                        'lang' => 'en',
                        'lang_key' => 'Upload that zip file here and click update now.',
                        'lang_value' => 'Upload that zip file here and click update now.',
                        'created_at' => '2021-04-08 12:40:09',
                        'updated_at' => '2021-04-08 12:40:09',
                    ),
                240 =>
                    array(
                        'id' => 1522,
                        'lang' => 'en',
                        'lang_key' => 'If you are using any addon make sure to update those addons after updating.',
                        'lang_value' => 'If you are using any addon make sure to update those addons after updating.',
                        'created_at' => '2021-04-08 12:40:09',
                        'updated_at' => '2021-04-08 12:40:09',
                    ),
                241 =>
                    array(
                        'id' => 1523,
                        'lang' => 'en',
                        'lang_key' => 'Server information',
                        'lang_value' => 'Server information',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                242 =>
                    array(
                        'id' => 1524,
                        'lang' => 'en',
                        'lang_key' => 'Current Version',
                        'lang_value' => 'Current Version',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                243 =>
                    array(
                        'id' => 1525,
                        'lang' => 'en',
                        'lang_key' => 'Required Version',
                        'lang_value' => 'Required Version',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                244 =>
                    array(
                        'id' => 1526,
                        'lang' => 'en',
                        'lang_key' => 'php.ini Config',
                        'lang_value' => 'php.ini Config',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                245 =>
                    array(
                        'id' => 1527,
                        'lang' => 'en',
                        'lang_key' => 'Config Name',
                        'lang_value' => 'Config Name',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                246 =>
                    array(
                        'id' => 1528,
                        'lang' => 'en',
                        'lang_key' => 'Current',
                        'lang_value' => 'Current',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                247 =>
                    array(
                        'id' => 1529,
                        'lang' => 'en',
                        'lang_key' => 'Recommended',
                        'lang_value' => 'Recommended',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                248 =>
                    array(
                        'id' => 1530,
                        'lang' => 'en',
                        'lang_key' => 'Extensions information',
                        'lang_value' => 'Extensions information',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                249 =>
                    array(
                        'id' => 1531,
                        'lang' => 'en',
                        'lang_key' => 'Extension Name',
                        'lang_value' => 'Extension Name',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                250 =>
                    array(
                        'id' => 1532,
                        'lang' => 'en',
                        'lang_key' => 'Filesystem Permissions',
                        'lang_value' => 'Filesystem Permissions',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                251 =>
                    array(
                        'id' => 1533,
                        'lang' => 'en',
                        'lang_key' => 'File or Folder',
                        'lang_value' => 'File or Folder',
                        'created_at' => '2021-04-08 12:40:24',
                        'updated_at' => '2021-04-08 12:40:24',
                    ),
                252 =>
                    array(
                        'id' => 1534,
                        'lang' => 'en',
                        'lang_key' => 'Staff Information',
                        'lang_value' => 'Staff Information',
                        'created_at' => '2021-04-08 12:40:31',
                        'updated_at' => '2021-04-08 12:40:31',
                    ),
                253 =>
                    array(
                        'id' => 1535,
                        'lang' => 'en',
                        'lang_key' => 'All Flash Deals',
                        'lang_value' => 'All Flash Deals',
                        'created_at' => '2021-04-08 12:41:36',
                        'updated_at' => '2021-04-08 12:41:36',
                    ),
                254 =>
                    array(
                        'id' => 1536,
                        'lang' => 'en',
                        'lang_key' => 'Create New Flash Deal',
                        'lang_value' => 'Create New Flash Deal',
                        'created_at' => '2021-04-08 12:41:36',
                        'updated_at' => '2021-04-08 12:41:36',
                    ),
                255 =>
                    array(
                        'id' => 1537,
                        'lang' => 'en',
                        'lang_key' => 'Emails',
                        'lang_value' => 'Emails',
                        'created_at' => '2021-04-08 12:41:40',
                        'updated_at' => '2021-04-08 12:41:40',
                    ),
                256 =>
                    array(
                        'id' => 1538,
                        'lang' => 'en',
                        'lang_key' => 'Users',
                        'lang_value' => 'Users',
                        'created_at' => '2021-04-08 12:41:40',
                        'updated_at' => '2021-04-08 12:41:40',
                    ),
                257 =>
                    array(
                        'id' => 1539,
                        'lang' => 'en',
                        'lang_key' => 'Newsletter subject',
                        'lang_value' => 'Newsletter subject',
                        'created_at' => '2021-04-08 12:41:40',
                        'updated_at' => '2021-04-08 12:41:40',
                    ),
                258 =>
                    array(
                        'id' => 1540,
                        'lang' => 'en',
                        'lang_key' => 'Newsletter content',
                        'lang_value' => 'Newsletter content',
                        'created_at' => '2021-04-08 12:41:40',
                        'updated_at' => '2021-04-08 12:41:40',
                    ),
                259 =>
                    array(
                        'id' => 1541,
                        'lang' => 'en',
                        'lang_key' => 'Please configure SMTP first',
                        'lang_value' => 'Please configure SMTP first',
                        'created_at' => '2021-04-08 12:41:59',
                        'updated_at' => '2021-04-08 12:41:59',
                    ),
                260 =>
                    array(
                        'id' => 1542,
                        'lang' => 'en',
                        'lang_key' => 'All Customers',
                        'lang_value' => 'All Customers',
                        'created_at' => '2021-04-08 12:42:16',
                        'updated_at' => '2021-04-08 12:42:16',
                    ),
                261 =>
                    array(
                        'id' => 1543,
                        'lang' => 'en',
                        'lang_key' => 'Type email or name & Enter',
                        'lang_value' => 'Type email or name & Enter',
                        'created_at' => '2021-04-08 12:42:16',
                        'updated_at' => '2021-04-08 12:42:16',
                    ),
                262 =>
                    array(
                        'id' => 1544,
                        'lang' => 'en',
                        'lang_key' => 'Package',
                        'lang_value' => 'Package',
                        'created_at' => '2021-04-08 12:42:16',
                        'updated_at' => '2021-04-08 12:42:16',
                    ),
                263 =>
                    array(
                        'id' => 1545,
                        'lang' => 'en',
                        'lang_key' => 'Log in as this Customer',
                        'lang_value' => 'Log in as this Customer',
                        'created_at' => '2021-04-08 12:42:16',
                        'updated_at' => '2021-04-08 12:42:16',
                    ),
                264 =>
                    array(
                        'id' => 1546,
                        'lang' => 'en',
                        'lang_key' => 'Ban this Customer',
                        'lang_value' => 'Ban this Customer',
                        'created_at' => '2021-04-08 12:42:16',
                        'updated_at' => '2021-04-08 12:42:16',
                    ),
                265 =>
                    array(
                        'id' => 1547,
                        'lang' => 'en',
                        'lang_key' => 'Do you really want to ban this Customer?',
                        'lang_value' => 'Do you really want to ban this Customer?',
                        'created_at' => '2021-04-08 12:42:16',
                        'updated_at' => '2021-04-08 12:42:16',
                    ),
                266 =>
                    array(
                        'id' => 1548,
                        'lang' => 'en',
                        'lang_key' => 'Do you really want to unban this Customer?',
                        'lang_value' => 'Do you really want to unban this Customer?',
                        'created_at' => '2021-04-08 12:42:16',
                        'updated_at' => '2021-04-08 12:42:16',
                    ),
                267 =>
                    array(
                        'id' => 1549,
                        'lang' => 'en',
                        'lang_key' => 'Filter by date',
                        'lang_value' => 'Filter by date',
                        'created_at' => '2021-04-08 12:42:21',
                        'updated_at' => '2021-04-08 12:42:21',
                    ),
                268 =>
                    array(
                        'id' => 1550,
                        'lang' => 'en',
                        'lang_key' => 'Parent Category',
                        'lang_value' => 'Parent Category',
                        'created_at' => '2021-04-08 12:42:58',
                        'updated_at' => '2021-04-08 12:42:58',
                    ),
                269 =>
                    array(
                        'id' => 1551,
                        'lang' => 'en',
                        'lang_key' => 'Order Level',
                        'lang_value' => 'Order Level',
                        'created_at' => '2021-04-08 12:42:58',
                        'updated_at' => '2021-04-08 12:42:58',
                    ),
                270 =>
                    array(
                        'id' => 1552,
                        'lang' => 'en',
                        'lang_key' => 'Level',
                        'lang_value' => 'Level',
                        'created_at' => '2021-04-08 12:42:58',
                        'updated_at' => '2021-04-08 12:42:58',
                    ),
                271 =>
                    array(
                        'id' => 1553,
                        'lang' => 'en',
                        'lang_key' => 'Category Information',
                        'lang_value' => 'Category Information',
                        'created_at' => '2021-04-08 12:43:10',
                        'updated_at' => '2021-04-08 12:43:10',
                    ),
                272 =>
                    array(
                        'id' => 1554,
                        'lang' => 'en',
                        'lang_key' => 'No Parent',
                        'lang_value' => 'No Parent',
                        'created_at' => '2021-04-08 12:43:10',
                        'updated_at' => '2021-04-08 12:43:10',
                    ),
                273 =>
                    array(
                        'id' => 1555,
                        'lang' => 'en',
                        'lang_key' => 'Ordering Number',
                        'lang_value' => 'Ordering Number',
                        'created_at' => '2021-04-08 12:43:11',
                        'updated_at' => '2021-04-08 12:43:11',
                    ),
                274 =>
                    array(
                        'id' => 1556,
                        'lang' => 'en',
                        'lang_key' => 'Physical',
                        'lang_value' => 'Physical',
                        'created_at' => '2021-04-08 12:43:11',
                        'updated_at' => '2021-04-08 12:43:11',
                    ),
                275 =>
                    array(
                        'id' => 1557,
                        'lang' => 'en',
                        'lang_key' => 'Digital',
                        'lang_value' => 'Digital',
                        'created_at' => '2021-04-08 12:43:11',
                        'updated_at' => '2021-04-08 12:43:11',
                    ),
                276 =>
                    array(
                        'id' => 1558,
                        'lang' => 'en',
                        'lang_key' => '200x200',
                        'lang_value' => '200x200',
                        'created_at' => '2021-04-08 12:43:11',
                        'updated_at' => '2021-04-08 12:43:11',
                    ),
                277 =>
                    array(
                        'id' => 1559,
                        'lang' => 'en',
                        'lang_key' => '32x32',
                        'lang_value' => '32x32',
                        'created_at' => '2021-04-08 12:43:11',
                        'updated_at' => '2021-04-08 12:43:11',
                    ),
                278 =>
                    array(
                        'id' => 1560,
                        'lang' => 'en',
                        'lang_key' => 'Category has been inserted successfully',
                        'lang_value' => 'Category has been inserted successfully',
                        'created_at' => '2021-04-08 12:43:25',
                        'updated_at' => '2021-04-08 12:43:25',
                    ),
                279 =>
                    array(
                        'id' => 1561,
                        'lang' => 'en',
                        'lang_key' => 'Category has been updated successfully',
                        'lang_value' => 'Category has been updated successfully',
                        'created_at' => '2021-04-08 12:43:32',
                        'updated_at' => '2021-04-08 12:43:32',
                    ),
                280 =>
                    array(
                        'id' => 1562,
                        'lang' => 'en',
                        'lang_key' => 'All Attributes',
                        'lang_value' => 'All Attributes',
                        'created_at' => '2021-04-08 12:44:32',
                        'updated_at' => '2021-04-08 12:44:32',
                    ),
                281 =>
                    array(
                        'id' => 1563,
                        'lang' => 'en',
                        'lang_key' => 'Add New Attribute',
                        'lang_value' => 'Add New Attribute',
                        'created_at' => '2021-04-08 12:44:32',
                        'updated_at' => '2021-04-08 12:44:32',
                    ),
                282 =>
                    array(
                        'id' => 1564,
                        'lang' => 'en',
                        'lang_key' => 'Attribute has been inserted successfully',
                        'lang_value' => 'Attribute has been inserted successfully',
                        'created_at' => '2021-04-08 12:44:43',
                        'updated_at' => '2021-04-08 12:44:43',
                    ),
                283 =>
                    array(
                        'id' => 1565,
                        'lang' => 'en',
                        'lang_key' => 'Attribute Information',
                        'lang_value' => 'Attribute Information',
                        'created_at' => '2021-04-08 12:44:47',
                        'updated_at' => '2021-04-08 12:44:47',
                    ),
                284 =>
                    array(
                        'id' => 1566,
                        'lang' => 'en',
                        'lang_key' => 'Attribute has been updated successfully',
                        'lang_value' => 'Attribute has been updated successfully',
                        'created_at' => '2021-04-08 12:44:50',
                        'updated_at' => '2021-04-08 12:44:50',
                    ),
                285 =>
                    array(
                        'id' => 1567,
                        'lang' => 'en',
                        'lang_key' => 'Search result for ',
                        'lang_value' => 'Search result for ',
                        'created_at' => '2021-04-08 12:49:30',
                        'updated_at' => '2021-04-08 12:49:30',
                    ),
                286 =>
                    array(
                        'id' => 1568,
                        'lang' => 'en',
                        'lang_key' => 'Support Desk',
                        'lang_value' => 'Support Desk',
                        'created_at' => '2021-04-08 12:56:51',
                        'updated_at' => '2021-04-08 12:56:51',
                    ),
                287 =>
                    array(
                        'id' => 1569,
                        'lang' => 'en',
                        'lang_key' => 'Type ticket code & Enter',
                        'lang_value' => 'Type ticket code & Enter',
                        'created_at' => '2021-04-08 12:56:51',
                        'updated_at' => '2021-04-08 12:56:51',
                    ),
                288 =>
                    array(
                        'id' => 1570,
                        'lang' => 'en',
                        'lang_key' => 'User',
                        'lang_value' => 'User',
                        'created_at' => '2021-04-08 12:56:51',
                        'updated_at' => '2021-04-08 12:56:51',
                    ),
                289 =>
                    array(
                        'id' => 1571,
                        'lang' => 'en',
                        'lang_key' => 'Last reply',
                        'lang_value' => 'Last reply',
                        'created_at' => '2021-04-08 12:56:51',
                        'updated_at' => '2021-04-08 12:56:51',
                    ),
                290 =>
                    array(
                        'id' => 1572,
                        'lang' => 'en',
                        'lang_key' => 'HTTPS Activation',
                        'lang_value' => 'HTTPS Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                291 =>
                    array(
                        'id' => 1573,
                        'lang' => 'en',
                        'lang_key' => 'Maintenance Mode Activation',
                        'lang_value' => 'Maintenance Mode Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                292 =>
                    array(
                        'id' => 1574,
                        'lang' => 'en',
                        'lang_key' => 'Disable image optimization?',
                        'lang_value' => 'Disable image optimization?',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                293 =>
                    array(
                        'id' => 1575,
                        'lang' => 'en',
                        'lang_key' => 'Business Related',
                        'lang_value' => 'Business Related',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                294 =>
                    array(
                        'id' => 1576,
                        'lang' => 'en',
                        'lang_key' => 'Vendor System Activation',
                        'lang_value' => 'Vendor System Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                295 =>
                    array(
                        'id' => 1577,
                        'lang' => 'en',
                        'lang_key' => 'Classified Product',
                        'lang_value' => 'Classified Product',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                296 =>
                    array(
                        'id' => 1578,
                        'lang' => 'en',
                        'lang_key' => 'Wallet System Activation',
                        'lang_value' => 'Wallet System Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                297 =>
                    array(
                        'id' => 1579,
                        'lang' => 'en',
                        'lang_key' => 'Coupon System Activation',
                        'lang_value' => 'Coupon System Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                298 =>
                    array(
                        'id' => 1580,
                        'lang' => 'en',
                        'lang_key' => 'Pickup Point Activation',
                        'lang_value' => 'Pickup Point Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                299 =>
                    array(
                        'id' => 1581,
                        'lang' => 'en',
                        'lang_key' => 'Conversation Activation',
                        'lang_value' => 'Conversation Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                300 =>
                    array(
                        'id' => 1582,
                        'lang' => 'en',
                        'lang_key' => 'Seller Product Manage By Admin',
                        'lang_value' => 'Seller Product Manage By Admin',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                301 =>
                    array(
                        'id' => 1583,
                        'lang' => 'en',
                        'lang_key' => 'After activate this option Cash On Delivery of Seller product will be managed by Admin',
                        'lang_value' => 'After activate this option Cash On Delivery of Seller product will be managed by Admin',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                302 =>
                    array(
                        'id' => 1584,
                        'lang' => 'en',
                        'lang_key' => 'Category-based Commission',
                        'lang_value' => 'Category-based Commission',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                303 =>
                    array(
                        'id' => 1585,
                        'lang' => 'en',
                        'lang_key' => 'After activate this option Seller commision will be disabled and You need to set commission on each category otherwise Admin will not get any commision',
                        'lang_value' => 'After activate this option Seller commision will be disabled and You need to set commission on each category otherwise Admin will not get any commision',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                304 =>
                    array(
                        'id' => 1586,
                        'lang' => 'en',
                        'lang_key' => 'Set Commisssion Now',
                        'lang_value' => 'Set Commisssion Now',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                305 =>
                    array(
                        'id' => 1587,
                        'lang' => 'en',
                        'lang_key' => 'Email Verification',
                        'lang_value' => 'Email Verification',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                306 =>
                    array(
                        'id' => 1588,
                        'lang' => 'en',
                        'lang_key' => 'Payment Related',
                        'lang_value' => 'Payment Related',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                307 =>
                    array(
                        'id' => 1589,
                        'lang' => 'en',
                        'lang_key' => 'Paypal Payment Activation',
                        'lang_value' => 'Paypal Payment Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                308 =>
                    array(
                        'id' => 1590,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure Paypal correctly to enable this feature',
                        'lang_value' => 'You need to configure Paypal correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                309 =>
                    array(
                        'id' => 1591,
                        'lang' => 'en',
                        'lang_key' => 'Stripe Payment Activation',
                        'lang_value' => 'Stripe Payment Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                310 =>
                    array(
                        'id' => 1592,
                        'lang' => 'en',
                        'lang_key' => 'SSlCommerz Activation',
                        'lang_value' => 'SSlCommerz Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                311 =>
                    array(
                        'id' => 1593,
                        'lang' => 'en',
                        'lang_key' => 'Instamojo Payment Activation',
                        'lang_value' => 'Instamojo Payment Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                312 =>
                    array(
                        'id' => 1594,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure Instamojo Payment correctly to enable this feature',
                        'lang_value' => 'You need to configure Instamojo Payment correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                313 =>
                    array(
                        'id' => 1595,
                        'lang' => 'en',
                        'lang_key' => 'Razor Pay Activation',
                        'lang_value' => 'Razor Pay Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                314 =>
                    array(
                        'id' => 1596,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure Razor correctly to enable this feature',
                        'lang_value' => 'You need to configure Razor correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                315 =>
                    array(
                        'id' => 1597,
                        'lang' => 'en',
                        'lang_key' => 'PayStack Activation',
                        'lang_value' => 'PayStack Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                316 =>
                    array(
                        'id' => 1598,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure PayStack correctly to enable this feature',
                        'lang_value' => 'You need to configure PayStack correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                317 =>
                    array(
                        'id' => 1599,
                        'lang' => 'en',
                        'lang_key' => 'VoguePay Activation',
                        'lang_value' => 'VoguePay Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                318 =>
                    array(
                        'id' => 1600,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure VoguePay correctly to enable this feature',
                        'lang_value' => 'You need to configure VoguePay correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                319 =>
                    array(
                        'id' => 1601,
                        'lang' => 'en',
                        'lang_key' => 'Payhere Activation',
                        'lang_value' => 'Payhere Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                320 =>
                    array(
                        'id' => 1602,
                        'lang' => 'en',
                        'lang_key' => 'Ngenius Activation',
                        'lang_value' => 'Ngenius Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                321 =>
                    array(
                        'id' => 1603,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure Ngenius correctly to enable this feature',
                        'lang_value' => 'You need to configure Ngenius correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                322 =>
                    array(
                        'id' => 1604,
                        'lang' => 'en',
                        'lang_key' => 'Iyzico Activation',
                        'lang_value' => 'Iyzico Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                323 =>
                    array(
                        'id' => 1605,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure iyzico correctly to enable this feature',
                        'lang_value' => 'You need to configure iyzico correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                324 =>
                    array(
                        'id' => 1606,
                        'lang' => 'en',
                        'lang_key' => 'Bkash Activation',
                        'lang_value' => 'Bkash Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                325 =>
                    array(
                        'id' => 1607,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure bkash correctly to enable this feature',
                        'lang_value' => 'You need to configure bkash correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                326 =>
                    array(
                        'id' => 1608,
                        'lang' => 'en',
                        'lang_key' => 'Nagad Activation',
                        'lang_value' => 'Nagad Activation',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                327 =>
                    array(
                        'id' => 1609,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure nagad correctly to enable this feature',
                        'lang_value' => 'You need to configure nagad correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:48',
                        'updated_at' => '2021-04-08 12:58:48',
                    ),
                328 =>
                    array(
                        'id' => 1610,
                        'lang' => 'en',
                        'lang_key' => 'Cash Payment Activation',
                        'lang_value' => 'Cash Payment Activation',
                        'created_at' => '2021-04-08 12:58:49',
                        'updated_at' => '2021-04-08 12:58:49',
                    ),
                329 =>
                    array(
                        'id' => 1611,
                        'lang' => 'en',
                        'lang_key' => 'Social Media Login',
                        'lang_value' => 'Social Media Login',
                        'created_at' => '2021-04-08 12:58:49',
                        'updated_at' => '2021-04-08 12:58:49',
                    ),
                330 =>
                    array(
                        'id' => 1612,
                        'lang' => 'en',
                        'lang_key' => 'Facebook login',
                        'lang_value' => 'Facebook login',
                        'created_at' => '2021-04-08 12:58:49',
                        'updated_at' => '2021-04-08 12:58:49',
                    ),
                331 =>
                    array(
                        'id' => 1613,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure Facebook Client correctly to enable this feature',
                        'lang_value' => 'You need to configure Facebook Client correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:49',
                        'updated_at' => '2021-04-08 12:58:49',
                    ),
                332 =>
                    array(
                        'id' => 1614,
                        'lang' => 'en',
                        'lang_key' => 'Google login',
                        'lang_value' => 'Google login',
                        'created_at' => '2021-04-08 12:58:49',
                        'updated_at' => '2021-04-08 12:58:49',
                    ),
                333 =>
                    array(
                        'id' => 1615,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure Google Client correctly to enable this feature',
                        'lang_value' => 'You need to configure Google Client correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:49',
                        'updated_at' => '2021-04-08 12:58:49',
                    ),
                334 =>
                    array(
                        'id' => 1616,
                        'lang' => 'en',
                        'lang_key' => 'Twitter login',
                        'lang_value' => 'Twitter login',
                        'created_at' => '2021-04-08 12:58:49',
                        'updated_at' => '2021-04-08 12:58:49',
                    ),
                335 =>
                    array(
                        'id' => 1617,
                        'lang' => 'en',
                        'lang_key' => 'You need to configure Twitter Client correctly to enable this feature',
                        'lang_value' => 'You need to configure Twitter Client correctly to enable this feature',
                        'created_at' => '2021-04-08 12:58:49',
                        'updated_at' => '2021-04-08 12:58:49',
                    ),
                336 =>
                    array(
                        'id' => 1618,
                        'lang' => 'en',
                        'lang_key' => 'Language has been deleted successfully',
                        'lang_value' => 'Language has been deleted successfully',
                        'created_at' => '2021-04-08 12:59:46',
                        'updated_at' => '2021-04-08 12:59:46',
                    ),
                337 =>
                    array(
                        'id' => 1619,
                        'lang' => 'en',
                        'lang_key' => 'Language has been inserted successfully',
                        'lang_value' => 'Language has been inserted successfully',
                        'created_at' => '2021-04-08 12:59:59',
                        'updated_at' => '2021-04-08 12:59:59',
                    ),
                338 =>
                    array(
                        'id' => 1620,
                        'lang' => 'en',
                        'lang_key' => 'System Default Currency',
                        'lang_value' => 'System Default Currency',
                        'created_at' => '2021-04-08 13:00:11',
                        'updated_at' => '2021-04-08 13:00:11',
                    ),
                339 =>
                    array(
                        'id' => 1621,
                        'lang' => 'en',
                        'lang_key' => 'Set Currency Formats',
                        'lang_value' => 'Set Currency Formats',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                340 =>
                    array(
                        'id' => 1622,
                        'lang' => 'en',
                        'lang_key' => 'Symbol Format',
                        'lang_value' => 'Symbol Format',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                341 =>
                    array(
                        'id' => 1623,
                        'lang' => 'en',
                        'lang_key' => 'Decimal Separator',
                        'lang_value' => 'Decimal Separator',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                342 =>
                    array(
                        'id' => 1624,
                        'lang' => 'en',
                        'lang_key' => 'No of decimals',
                        'lang_value' => 'No of decimals',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                343 =>
                    array(
                        'id' => 1625,
                        'lang' => 'en',
                        'lang_key' => 'All Currencies',
                        'lang_value' => 'All Currencies',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                344 =>
                    array(
                        'id' => 1626,
                        'lang' => 'en',
                        'lang_key' => 'Add New Currency',
                        'lang_value' => 'Add New Currency',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                345 =>
                    array(
                        'id' => 1627,
                        'lang' => 'en',
                        'lang_key' => 'Currency name',
                        'lang_value' => 'Currency name',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                346 =>
                    array(
                        'id' => 1628,
                        'lang' => 'en',
                        'lang_key' => 'Currency symbol',
                        'lang_value' => 'Currency symbol',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                347 =>
                    array(
                        'id' => 1629,
                        'lang' => 'en',
                        'lang_key' => 'Currency code',
                        'lang_value' => 'Currency code',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                348 =>
                    array(
                        'id' => 1630,
                        'lang' => 'en',
                        'lang_key' => 'Currency Status updated successfully',
                        'lang_value' => 'Currency Status updated successfully',
                        'created_at' => '2021-04-08 13:00:12',
                        'updated_at' => '2021-04-08 13:00:12',
                    ),
                349 =>
                    array(
                        'id' => 1631,
                        'lang' => 'en',
                        'lang_key' => 'Facebook Pixel Setting',
                        'lang_value' => 'Facebook Pixel Setting',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                350 =>
                    array(
                        'id' => 1632,
                        'lang' => 'en',
                        'lang_key' => 'Facebook Pixel',
                        'lang_value' => 'Facebook Pixel',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                351 =>
                    array(
                        'id' => 1633,
                        'lang' => 'en',
                        'lang_key' => 'Facebook Pixel ID',
                        'lang_value' => 'Facebook Pixel ID',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                352 =>
                    array(
                        'id' => 1634,
                        'lang' => 'en',
                        'lang_key' => 'Please be carefull when you are configuring Facebook pixel.',
                        'lang_value' => 'Please be carefull when you are configuring Facebook pixel.',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                353 =>
                    array(
                        'id' => 1635,
                        'lang' => 'en',
                        'lang_key' => 'Log in to Facebook and go to your Ads Manager account',
                        'lang_value' => 'Log in to Facebook and go to your Ads Manager account',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                354 =>
                    array(
                        'id' => 1636,
                        'lang' => 'en',
                        'lang_key' => 'Open the Navigation Bar and select Events Manager',
                        'lang_value' => 'Open the Navigation Bar and select Events Manager',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                355 =>
                    array(
                        'id' => 1637,
                        'lang' => 'en',
                        'lang_key' => 'Copy your Pixel ID from underneath your Site Name and paste the number into Facebook Pixel ID field',
                        'lang_value' => 'Copy your Pixel ID from underneath your Site Name and paste the number into Facebook Pixel ID field',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                356 =>
                    array(
                        'id' => 1638,
                        'lang' => 'en',
                        'lang_key' => 'Google Analytics Setting',
                        'lang_value' => 'Google Analytics Setting',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                357 =>
                    array(
                        'id' => 1639,
                        'lang' => 'en',
                        'lang_key' => 'Google Analytics',
                        'lang_value' => 'Google Analytics',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                358 =>
                    array(
                        'id' => 1640,
                        'lang' => 'en',
                        'lang_key' => 'Tracking ID',
                        'lang_value' => 'Tracking ID',
                        'created_at' => '2021-04-08 13:01:04',
                        'updated_at' => '2021-04-08 13:01:04',
                    ),
                359 =>
                    array(
                        'id' => 1641,
                        'lang' => 'en',
                        'lang_key' => 'Bkash Credential',
                        'lang_value' => 'Bkash Credential',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                360 =>
                    array(
                        'id' => 1642,
                        'lang' => 'en',
                        'lang_key' => 'BKASH CHECKOUT APP KEY',
                        'lang_value' => 'BKASH CHECKOUT APP KEY',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                361 =>
                    array(
                        'id' => 1643,
                        'lang' => 'en',
                        'lang_key' => 'BKASH CHECKOUT APP SECRET',
                        'lang_value' => 'BKASH CHECKOUT APP SECRET',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                362 =>
                    array(
                        'id' => 1644,
                        'lang' => 'en',
                        'lang_key' => 'BKASH CHECKOUT USER NAME',
                        'lang_value' => 'BKASH CHECKOUT USER NAME',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                363 =>
                    array(
                        'id' => 1645,
                        'lang' => 'en',
                        'lang_key' => 'BKASH CHECKOUT PASSWORD',
                        'lang_value' => 'BKASH CHECKOUT PASSWORD',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                364 =>
                    array(
                        'id' => 1646,
                        'lang' => 'en',
                        'lang_key' => 'Bkash Sandbox Mode',
                        'lang_value' => 'Bkash Sandbox Mode',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                365 =>
                    array(
                        'id' => 1647,
                        'lang' => 'en',
                        'lang_key' => 'Nagad Credential',
                        'lang_value' => 'Nagad Credential',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                366 =>
                    array(
                        'id' => 1648,
                        'lang' => 'en',
                        'lang_key' => 'NAGAD MODE',
                        'lang_value' => 'NAGAD MODE',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                367 =>
                    array(
                        'id' => 1649,
                        'lang' => 'en',
                        'lang_key' => 'NAGAD MERCHANT ID',
                        'lang_value' => 'NAGAD MERCHANT ID',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                368 =>
                    array(
                        'id' => 1650,
                        'lang' => 'en',
                        'lang_key' => 'NAGAD MERCHANT NUMBER',
                        'lang_value' => 'NAGAD MERCHANT NUMBER',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                369 =>
                    array(
                        'id' => 1651,
                        'lang' => 'en',
                        'lang_key' => 'NAGAD PG PUBLIC KEY',
                        'lang_value' => 'NAGAD PG PUBLIC KEY',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                370 =>
                    array(
                        'id' => 1652,
                        'lang' => 'en',
                        'lang_key' => 'NAGAD MERCHANT PRIVATE KEY',
                        'lang_value' => 'NAGAD MERCHANT PRIVATE KEY',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                371 =>
                    array(
                        'id' => 1653,
                        'lang' => 'en',
                        'lang_key' => 'PAYSTACK CURRENCY CODE',
                        'lang_value' => 'PAYSTACK CURRENCY CODE',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                372 =>
                    array(
                        'id' => 1654,
                        'lang' => 'en',
                        'lang_key' => 'Iyzico Credential',
                        'lang_value' => 'Iyzico Credential',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                373 =>
                    array(
                        'id' => 1655,
                        'lang' => 'en',
                        'lang_key' => 'IYZICO_API_KEY',
                        'lang_value' => 'IYZICO_API_KEY',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                374 =>
                    array(
                        'id' => 1656,
                        'lang' => 'en',
                        'lang_key' => 'IYZICO API KEY',
                        'lang_value' => 'IYZICO API KEY',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                375 =>
                    array(
                        'id' => 1657,
                        'lang' => 'en',
                        'lang_key' => 'IYZICO_SECRET_KEY',
                        'lang_value' => 'IYZICO_SECRET_KEY',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                376 =>
                    array(
                        'id' => 1658,
                        'lang' => 'en',
                        'lang_key' => 'IYZICO SECRET KEY',
                        'lang_value' => 'IYZICO SECRET KEY',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                377 =>
                    array(
                        'id' => 1659,
                        'lang' => 'en',
                        'lang_key' => 'IYZICO Sandbox Mode',
                        'lang_value' => 'IYZICO Sandbox Mode',
                        'created_at' => '2021-04-08 13:01:21',
                        'updated_at' => '2021-04-08 13:01:21',
                    ),
                378 =>
                    array(
                        'id' => 1660,
                        'lang' => 'en',
                        'lang_key' => 'Area Wise Flat Shipping Cost',
                        'lang_value' => 'Area Wise Flat Shipping Cost',
                        'created_at' => '2021-04-08 13:01:36',
                        'updated_at' => '2021-04-08 13:01:36',
                    ),
                379 =>
                    array(
                        'id' => 1661,
                        'lang' => 'en',
                        'lang_key' => 'Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If customers purchase 2 product from two seller shipping cost is calculated by addition of each seller flat shipping cost',
                        'lang_value' => 'Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If customers purchase 2 product from two seller shipping cost is calculated by addition of each seller flat shipping cost',
                        'created_at' => '2021-04-08 13:01:36',
                        'updated_at' => '2021-04-08 13:01:36',
                    ),
                380 =>
                    array(
                        'id' => 1662,
                        'lang' => 'en',
                        'lang_key' => 'Area Wise Flat Shipping Cost calulation: Fixed rate for each area. If customers purchase multiple products from one seller shipping cost is calculated by the customer shipping area. To configure area wise shipping cost go to ',
                        'lang_value' => 'Area Wise Flat Shipping Cost calulation: Fixed rate for each area. If customers purchase multiple products from one seller shipping cost is calculated by the customer shipping area. To configure area wise shipping cost go to ',
                        'created_at' => '2021-04-08 13:01:36',
                        'updated_at' => '2021-04-08 13:01:36',
                    ),
                381 =>
                    array(
                        'id' => 1663,
                        'lang' => 'en',
                        'lang_key' => '1. Flat rate shipping cost is applicable if Flat rate shipping is enabled.',
                        'lang_value' => '1. Flat rate shipping cost is applicable if Flat rate shipping is enabled.',
                        'created_at' => '2021-04-08 13:01:36',
                        'updated_at' => '2021-04-08 13:01:36',
                    ),
                382 =>
                    array(
                        'id' => 1664,
                        'lang' => 'en',
                        'lang_key' => '1. Shipping cost for admin is applicable if Seller wise shipping cost is enabled.',
                        'lang_value' => '1. Shipping cost for admin is applicable if Seller wise shipping cost is enabled.',
                        'created_at' => '2021-04-08 13:01:36',
                        'updated_at' => '2021-04-08 13:01:36',
                    ),
                383 =>
                    array(
                        'id' => 1665,
                        'lang' => 'en',
                        'lang_key' => 'Cookies Agreement',
                        'lang_value' => 'Cookies Agreement',
                        'created_at' => '2021-04-08 13:32:21',
                        'updated_at' => '2021-04-08 13:32:21',
                    ),
                384 =>
                    array(
                        'id' => 1666,
                        'lang' => 'en',
                        'lang_key' => 'Cookies Agreement Text',
                        'lang_value' => 'Cookies Agreement Text',
                        'created_at' => '2021-04-08 13:32:21',
                        'updated_at' => '2021-04-08 13:32:21',
                    ),
                385 =>
                    array(
                        'id' => 1667,
                        'lang' => 'en',
                        'lang_key' => 'Show Cookies Agreement?',
                        'lang_value' => 'Show Cookies Agreement?',
                        'created_at' => '2021-04-08 13:32:21',
                        'updated_at' => '2021-04-08 13:32:21',
                    ),
                386 =>
                    array(
                        'id' => 1668,
                        'lang' => 'en',
                        'lang_key' => 'Custom Script',
                        'lang_value' => 'Custom Script',
                        'created_at' => '2021-04-08 13:32:21',
                        'updated_at' => '2021-04-08 13:32:21',
                    ),
                387 =>
                    array(
                        'id' => 1669,
                        'lang' => 'en',
                        'lang_key' => 'Header custom script - before </head>',
                        'lang_value' => 'Header custom script - before </head>',
                        'created_at' => '2021-04-08 13:32:21',
                        'updated_at' => '2021-04-08 13:32:21',
                    ),
                388 =>
                    array(
                        'id' => 1670,
                        'lang' => 'en',
                        'lang_key' => 'Write script with <script> tag',
                        'lang_value' => 'Write script with <script> tag',
                        'created_at' => '2021-04-08 13:32:21',
                        'updated_at' => '2021-04-08 13:32:21',
                    ),
                389 =>
                    array(
                        'id' => 1671,
                        'lang' => 'en',
                        'lang_key' => 'Footer custom script - before </body>',
                        'lang_value' => 'Footer custom script - before </body>',
                        'created_at' => '2021-04-08 13:32:21',
                        'updated_at' => '2021-04-08 13:32:21',
                    ),
                390 =>
                    array(
                        'id' => 1672,
                        'lang' => 'en',
                        'lang_key' => 'Featured Companies',
                        'lang_value' => 'Featured Companies',
                        'created_at' => '2021-04-08 13:37:05',
                        'updated_at' => '2021-04-08 13:37:05',
                    ),
                391 =>
                    array(
                        'id' => 1673,
                        'lang' => 'en',
                        'lang_key' => 'Todays News',
                        'lang_value' => 'Todays News',
                        'created_at' => '2021-04-08 13:41:33',
                        'updated_at' => '2021-04-08 13:41:33',
                    ),
                392 =>
                    array(
                        'id' => 1674,
                        'lang' => 'en',
                        'lang_key' => 'We have limited banner height to maintain UI. We had to crop from both left & right side in view for different devices to make it responsive. Before designing banner keep these points in mind.',
                        'lang_value' => 'We have limited banner height to maintain UI. We had to crop from both left & right side in view for different devices to make it responsive. Before designing banner keep these points in mind.',
                        'created_at' => '2021-04-08 13:42:55',
                        'updated_at' => '2021-04-08 13:42:55',
                    ),
                393 =>
                    array(
                        'id' => 1675,
                        'lang' => 'en',
                        'lang_key' => 'Home Banner 3 (Max 3)',
                        'lang_value' => 'Home Banner 3 (Max 3)',
                        'created_at' => '2021-04-08 13:42:55',
                        'updated_at' => '2021-04-08 13:42:55',
                    ),
                394 =>
                    array(
                        'id' => 1676,
                        'lang' => 'en',
                        'lang_key' => 'Matches',
                        'lang_value' => 'Matches',
                        'created_at' => '2021-04-08 13:50:27',
                        'updated_at' => '2021-04-08 13:50:27',
                    ),
                395 =>
                    array(
                        'id' => 1677,
                        'lang' => 'en',
                        'lang_key' => 'Company Matches',
                        'lang_value' => 'Company Matches',
                        'created_at' => '2021-04-08 13:50:36',
                        'updated_at' => '2021-04-08 13:50:36',
                    ),
                396 =>
                    array(
                        'id' => 1678,
                        'lang' => 'en',
                        'lang_key' => 'Browse for companies or industries...',
                        'lang_value' => 'Browse for companies or industries...',
                        'created_at' => '2021-04-08 13:58:39',
                        'updated_at' => '2021-04-08 13:58:39',
                    ),
                397 =>
                    array(
                        'id' => 1679,
                        'lang' => 'en',
                        'lang_key' => 'Browse for companies or industries. Example: Wood mills',
                        'lang_value' => 'Browse for companies or industries. Example: Wood mills',
                        'created_at' => '2021-04-08 13:58:52',
                        'updated_at' => '2021-04-08 13:58:52',
                    ),
                398 =>
                    array(
                        'id' => 1680,
                        'lang' => 'en',
                        'lang_key' => 'Companies',
                        'lang_value' => 'Companies',
                        'created_at' => '2021-04-08 14:00:13',
                        'updated_at' => '2021-04-08 14:00:13',
                    ),
                399 =>
                    array(
                        'id' => 1681,
                        'lang' => 'en',
                        'lang_key' => 'News',
                        'lang_value' => 'News',
                        'created_at' => '2021-04-08 14:00:13',
                        'updated_at' => '2021-04-08 14:00:13',
                    ),
                400 =>
                    array(
                        'id' => 1682,
                        'lang' => 'en',
                        'lang_key' => 'Sendmail',
                        'lang_value' => 'Sendmail',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                401 =>
                    array(
                        'id' => 1683,
                        'lang' => 'en',
                        'lang_key' => 'Mailgun',
                        'lang_value' => 'Mailgun',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                402 =>
                    array(
                        'id' => 1684,
                        'lang' => 'en',
                        'lang_key' => 'MAIL HOST',
                        'lang_value' => 'MAIL HOST',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                403 =>
                    array(
                        'id' => 1685,
                        'lang' => 'en',
                        'lang_key' => 'MAIL PORT',
                        'lang_value' => 'MAIL PORT',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                404 =>
                    array(
                        'id' => 1686,
                        'lang' => 'en',
                        'lang_key' => 'MAIL USERNAME',
                        'lang_value' => 'MAIL USERNAME',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                405 =>
                    array(
                        'id' => 1687,
                        'lang' => 'en',
                        'lang_key' => 'MAIL PASSWORD',
                        'lang_value' => 'MAIL PASSWORD',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                406 =>
                    array(
                        'id' => 1688,
                        'lang' => 'en',
                        'lang_key' => 'MAIL ENCRYPTION',
                        'lang_value' => 'MAIL ENCRYPTION',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                407 =>
                    array(
                        'id' => 1689,
                        'lang' => 'en',
                        'lang_key' => 'MAIL FROM ADDRESS',
                        'lang_value' => 'MAIL FROM ADDRESS',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                408 =>
                    array(
                        'id' => 1690,
                        'lang' => 'en',
                        'lang_key' => 'MAIL FROM NAME',
                        'lang_value' => 'MAIL FROM NAME',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                409 =>
                    array(
                        'id' => 1691,
                        'lang' => 'en',
                        'lang_key' => 'MAILGUN DOMAIN',
                        'lang_value' => 'MAILGUN DOMAIN',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                410 =>
                    array(
                        'id' => 1692,
                        'lang' => 'en',
                        'lang_key' => 'MAILGUN SECRET',
                        'lang_value' => 'MAILGUN SECRET',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                411 =>
                    array(
                        'id' => 1693,
                        'lang' => 'en',
                        'lang_key' => 'Save Configuration',
                        'lang_value' => 'Save Configuration',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                412 =>
                    array(
                        'id' => 1694,
                        'lang' => 'en',
                        'lang_key' => 'Test SMTP configuration',
                        'lang_value' => 'Test SMTP configuration',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                413 =>
                    array(
                        'id' => 1695,
                        'lang' => 'en',
                        'lang_key' => 'Enter your email address',
                        'lang_value' => 'Enter your email address',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                414 =>
                    array(
                        'id' => 1696,
                        'lang' => 'en',
                        'lang_key' => 'Send test email',
                        'lang_value' => 'Send test email',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                415 =>
                    array(
                        'id' => 1697,
                        'lang' => 'en',
                        'lang_key' => 'Instruction',
                        'lang_value' => 'Instruction',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                416 =>
                    array(
                        'id' => 1698,
                        'lang' => 'en',
                        'lang_key' => 'Please be carefull when you are configuring SMTP. For incorrect configuration you will get error at the time of order place, new registration, sending newsletter.',
                        'lang_value' => 'Please be carefull when you are configuring SMTP. For incorrect configuration you will get error at the time of order place, new registration, sending newsletter.',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                417 =>
                    array(
                        'id' => 1699,
                        'lang' => 'en',
                        'lang_key' => 'For Non-SSL',
                        'lang_value' => 'For Non-SSL',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                418 =>
                    array(
                        'id' => 1700,
                        'lang' => 'en',
                        'lang_key' => 'Select sendmail for Mail Driver if you face any issue after configuring smtp as Mail Driver ',
                        'lang_value' => 'Select sendmail for Mail Driver if you face any issue after configuring smtp as Mail Driver ',
                        'created_at' => '2021-04-08 14:08:40',
                        'updated_at' => '2021-04-08 14:08:40',
                    ),
                419 =>
                    array(
                        'id' => 1701,
                        'lang' => 'en',
                        'lang_key' => 'Set Mail Host according to your server Mail Client Manual Settings',
                        'lang_value' => 'Set Mail Host according to your server Mail Client Manual Settings',
                        'created_at' => '2021-04-08 14:08:41',
                        'updated_at' => '2021-04-08 14:08:41',
                    ),
                420 =>
                    array(
                        'id' => 1702,
                        'lang' => 'en',
                        'lang_key' => 'Set Mail port as 587',
                        'lang_value' => 'Set Mail port as 587',
                        'created_at' => '2021-04-08 14:08:41',
                        'updated_at' => '2021-04-08 14:08:41',
                    ),
                421 =>
                    array(
                        'id' => 1703,
                        'lang' => 'en',
                        'lang_key' => 'Set Mail Encryption as ssl if you face issue with tls',
                        'lang_value' => 'Set Mail Encryption as ssl if you face issue with tls',
                        'created_at' => '2021-04-08 14:08:41',
                        'updated_at' => '2021-04-08 14:08:41',
                    ),
                422 =>
                    array(
                        'id' => 1704,
                        'lang' => 'en',
                        'lang_key' => 'For SSL',
                        'lang_value' => 'For SSL',
                        'created_at' => '2021-04-08 14:08:41',
                        'updated_at' => '2021-04-08 14:08:41',
                    ),
                423 =>
                    array(
                        'id' => 1705,
                        'lang' => 'en',
                        'lang_key' => 'Set Mail port as 465',
                        'lang_value' => 'Set Mail port as 465',
                        'created_at' => '2021-04-08 14:08:41',
                        'updated_at' => '2021-04-08 14:08:41',
                    ),
                424 =>
                    array(
                        'id' => 1706,
                        'lang' => 'en',
                        'lang_key' => 'Set Mail Encryption as ssl',
                        'lang_value' => 'Set Mail Encryption as ssl',
                        'created_at' => '2021-04-08 14:08:41',
                        'updated_at' => '2021-04-08 14:08:41',
                    ),
                425 =>
                    array(
                        'id' => 1707,
                        'lang' => 'en',
                        'lang_key' => 'Complete Your Profile',
                        'lang_value' => 'Complete Your Profile',
                        'created_at' => '2021-04-08 16:11:46',
                        'updated_at' => '2021-04-08 16:11:46',
                    ),
                426 =>
                    array(
                        'id' => 1708,
                        'lang' => 'en',
                        'lang_key' => 'Conversations With ',
                        'lang_value' => 'Conversations With ',
                        'created_at' => '2021-04-08 16:20:50',
                        'updated_at' => '2021-04-08 16:20:50',
                    ),
                427 =>
                    array(
                        'id' => 1709,
                        'lang' => 'en',
                        'lang_key' => 'Between you and',
                        'lang_value' => 'Between you and',
                        'created_at' => '2021-04-08 16:20:50',
                        'updated_at' => '2021-04-08 16:20:50',
                    ),
                428 =>
                    array(
                        'id' => 1710,
                        'lang' => 'en',
                        'lang_key' => 'has not been verified yet.',
                        'lang_value' => 'has not been verified yet.',
                        'created_at' => '2021-04-08 17:07:54',
                        'updated_at' => '2021-04-08 17:07:54',
                    ),
                429 =>
                    array(
                        'id' => 1711,
                        'lang' => 'en',
                        'lang_key' => 'Your Shop has been updated successfully!',
                        'lang_value' => 'Your Shop has been updated successfully!',
                        'created_at' => '2021-04-08 17:08:22',
                        'updated_at' => '2021-04-08 17:08:22',
                    ),
                430 =>
                    array(
                        'id' => 1712,
                        'lang' => 'en',
                        'lang_key' => 'Recharge Wallet',
                        'lang_value' => 'Recharge Wallet',
                        'created_at' => '2021-04-08 17:08:28',
                        'updated_at' => '2021-04-08 17:08:28',
                    ),
                431 =>
                    array(
                        'id' => 1713,
                        'lang' => 'en',
                        'lang_key' => 'Iyzico',
                        'lang_value' => 'Iyzico',
                        'created_at' => '2021-04-08 17:08:28',
                        'updated_at' => '2021-04-08 17:08:28',
                    ),
                432 =>
                    array(
                        'id' => 1714,
                        'lang' => 'en',
                        'lang_key' => 'Offline Recharge Wallet',
                        'lang_value' => 'Offline Recharge Wallet',
                        'created_at' => '2021-04-08 17:08:28',
                        'updated_at' => '2021-04-08 17:08:28',
                    ),
                433 =>
                    array(
                        'id' => 1715,
                        'lang' => 'en',
                        'lang_key' => 'Seller has been updated successfully',
                        'lang_value' => 'Seller has been updated successfully',
                        'created_at' => '2021-04-08 17:28:51',
                        'updated_at' => '2021-04-08 17:28:51',
                    ),
                434 =>
                    array(
                        'id' => 1716,
                        'lang' => 'en',
                        'lang_key' => 'Join The Club',
                        'lang_value' => 'Join The Club',
                        'created_at' => '2021-04-09 12:59:19',
                        'updated_at' => '2021-04-09 12:59:19',
                    ),
                435 =>
                    array(
                        'id' => 1717,
                        'lang' => 'en',
                        'lang_key' => 'Forgot password ?',
                        'lang_value' => 'Forgot password ?',
                        'created_at' => '2021-04-09 13:32:21',
                        'updated_at' => '2021-04-09 13:32:21',
                    ),
                436 =>
                    array(
                        'id' => 1718,
                        'lang' => 'en',
                        'lang_key' => 'Please add shipping address',
                        'lang_value' => 'Please add shipping address',
                        'created_at' => '2021-04-09 13:38:18',
                        'updated_at' => '2021-04-09 13:38:18',
                    ),
                437 =>
                    array(
                        'id' => 1719,
                        'lang' => 'en',
                        'lang_key' => 'Your order has been placed',
                        'lang_value' => 'Your order has been placed',
                        'created_at' => '2021-04-09 13:40:03',
                        'updated_at' => '2021-04-09 13:40:03',
                    ),
                438 =>
                    array(
                        'id' => 1720,
                        'lang' => 'en',
                        'lang_key' => 'Payment completed',
                        'lang_value' => 'Payment completed',
                        'created_at' => '2021-04-09 13:40:30',
                        'updated_at' => '2021-04-09 13:40:30',
                    ),
                439 =>
                    array(
                        'id' => 1721,
                        'lang' => 'en',
                        'lang_key' => 'Top 10 Companies',
                        'lang_value' => 'Top 10 Companies',
                        'created_at' => '2021-04-09 13:42:53',
                        'updated_at' => '2021-04-09 13:42:53',
                    ),
                440 =>
                    array(
                        'id' => 1722,
                        'lang' => 'en',
                        'lang_key' => 'B2BWood Top 10',
                        'lang_value' => 'B2BWood Top 10',
                        'created_at' => '2021-04-09 13:43:05',
                        'updated_at' => '2021-04-09 13:43:05',
                    ),
                441 =>
                    array(
                        'id' => 1723,
                        'lang' => 'en',
                        'lang_key' => 'Type and hit enter',
                        'lang_value' => 'Type and hit enter',
                        'created_at' => '2021-04-09 20:32:07',
                        'updated_at' => '2021-04-09 20:32:07',
                    ),
                442 =>
                    array(
                        'id' => 1724,
                        'lang' => 'en',
                        'lang_key' => 'Save Product',
                        'lang_value' => 'Save Product',
                        'created_at' => '2021-04-09 20:32:07',
                        'updated_at' => '2021-04-09 20:32:07',
                    ),
                443 =>
                    array(
                        'id' => 1725,
                        'lang' => 'en',
                        'lang_key' => 'Marketplace',
                        'lang_value' => 'Marketplace',
                        'created_at' => '2021-04-10 11:56:31',
                        'updated_at' => '2021-04-10 11:56:31',
                    ),
                444 =>
                    array(
                        'id' => 1726,
                        'lang' => 'en',
                        'lang_key' => 'Events',
                        'lang_value' => 'Events',
                        'created_at' => '2021-04-10 11:56:31',
                        'updated_at' => '2021-04-10 11:56:31',
                    ),
                445 =>
                    array(
                        'id' => 1727,
                        'lang' => 'en',
                        'lang_key' => 'Calendar',
                        'lang_value' => 'Calendar',
                        'created_at' => '2021-04-10 11:56:31',
                        'updated_at' => '2021-04-10 11:56:31',
                    ),
                446 =>
                    array(
                        'id' => 1728,
                        'lang' => 'en',
                        'lang_key' => 'Business For Sale',
                        'lang_value' => 'Business For Sale',
                        'created_at' => '2021-04-10 11:56:31',
                        'updated_at' => '2021-04-10 11:56:31',
                    ),
                447 =>
                    array(
                        'id' => 1729,
                        'lang' => 'en',
                        'lang_key' => 'Investments',
                        'lang_value' => 'Investments',
                        'created_at' => '2021-04-10 11:56:31',
                        'updated_at' => '2021-04-10 11:56:31',
                    ),
                448 =>
                    array(
                        'id' => 1730,
                        'lang' => 'en',
                        'lang_key' => 'Jobs',
                        'lang_value' => 'Jobs',
                        'created_at' => '2021-04-10 11:56:31',
                        'updated_at' => '2021-04-10 11:56:31',
                    ),
                449 =>
                    array(
                        'id' => 1731,
                        'lang' => 'en',
                        'lang_key' => 'Education',
                        'lang_value' => 'Education',
                        'created_at' => '2021-04-10 11:56:31',
                        'updated_at' => '2021-04-10 11:56:31',
                    ),
                450 =>
                    array(
                        'id' => 1732,
                        'lang' => 'en',
                        'lang_key' => 'Registration successfull.',
                        'lang_value' => 'Registration successfull.',
                        'created_at' => '2021-04-12 14:45:14',
                        'updated_at' => '2021-04-12 14:45:14',
                    ),
                451 =>
                    array(
                        'id' => 1733,
                        'lang' => 'en',
                        'lang_key' => 'Company Info',
                        'lang_value' => 'Company Info',
                        'created_at' => '2021-04-12 15:00:42',
                        'updated_at' => '2021-04-12 15:00:42',
                    ),
                452 =>
                    array(
                        'id' => 1734,
                        'lang' => 'en',
                        'lang_key' => '1. Category and Brand should be in numerical id.',
                        'lang_value' => '1. Category and Brand should be in numerical id.',
                        'created_at' => '2021-04-13 17:13:38',
                        'updated_at' => '2021-04-13 17:13:38',
                    ),
                453 =>
                    array(
                        'id' => 1735,
                        'lang' => 'en',
                        'lang_key' => '2. You can download the pdf to get Category and Brand id.',
                        'lang_value' => '2. You can download the pdf to get Category and Brand id.',
                        'created_at' => '2021-04-13 17:13:38',
                        'updated_at' => '2021-04-13 17:13:38',
                    ),
                454 =>
                    array(
                        'id' => 1736,
                        'lang' => 'en',
                        'lang_key' => 'Verified? Companies',
                        'lang_value' => 'Verified? Companies',
                        'created_at' => '2021-04-16 15:25:32',
                        'updated_at' => '2021-04-16 15:25:32',
                    ),
                455 =>
                    array(
                        'id' => 1737,
                        'lang' => 'en',
                        'lang_key' => 'New B2BWood Members',
                        'lang_value' => 'New B2BWood Members',
                        'created_at' => '2021-04-16 15:25:45',
                        'updated_at' => '2021-04-16 15:25:45',
                    ),
                456 =>
                    array(
                        'id' => 1738,
                        'lang' => 'en',
                        'lang_key' => 'New B2BWood Club Members',
                        'lang_value' => 'New B2BWood Club Members',
                        'created_at' => '2021-04-16 15:25:55',
                        'updated_at' => '2021-04-16 15:25:55',
                    ),
                457 =>
                    array(
                        'id' => 1739,
                        'lang' => 'en',
                        'lang_key' => 'View All Companies',
                        'lang_value' => 'View All Companies',
                        'created_at' => '2021-04-16 15:27:54',
                        'updated_at' => '2021-04-16 15:27:54',
                    ),
                458 =>
                    array(
                        'id' => 1740,
                        'lang' => 'en',
                        'lang_key' => 'Premium Packages for Customers',
                        'lang_value' => 'Premium Packages for Customers',
                        'created_at' => '2021-04-20 16:24:35',
                        'updated_at' => '2021-04-20 16:24:35',
                    ),
                459 =>
                    array(
                        'id' => 1741,
                        'lang' => 'en',
                        'lang_key' => 'Offline Package Purchase ',
                        'lang_value' => 'Offline Package Purchase ',
                        'created_at' => '2021-04-20 16:24:35',
                        'updated_at' => '2021-04-20 16:24:35',
                    ),
                460 =>
                    array(
                        'id' => 1742,
                        'lang' => 'en',
                        'lang_key' => 'Latest wood industry news',
                        'lang_value' => 'Latest wood industry news',
                        'created_at' => '2021-04-20 21:38:23',
                        'updated_at' => '2021-04-20 21:38:23',
                    ),
                461 =>
                    array(
                        'id' => 1743,
                        'lang' => 'en',
                        'lang_key' => 'Registered Companies',
                        'lang_value' => 'Registered Companies',
                        'created_at' => '2021-04-20 21:42:20',
                        'updated_at' => '2021-04-20 21:42:20',
                    ),
                462 =>
                    array(
                        'id' => 1744,
                        'lang' => 'en',
                        'lang_key' => 'Categories:',
                        'lang_value' => 'Categories:',
                        'created_at' => '2021-05-03 13:03:39',
                        'updated_at' => '2021-05-03 13:03:39',
                    ),
                463 =>
                    array(
                        'id' => 1745,
                        'lang' => 'en',
                        'lang_key' => 'Search articles',
                        'lang_value' => 'Search articles',
                        'created_at' => '2021-05-03 13:03:39',
                        'updated_at' => '2021-05-03 13:03:39',
                    ),
                464 =>
                    array(
                        'id' => 1746,
                        'lang' => 'en',
                        'lang_key' => 'Latest news',
                        'lang_value' => 'Latest news',
                        'created_at' => '2021-05-03 13:03:39',
                        'updated_at' => '2021-05-03 13:03:39',
                    ),
                465 =>
                    array(
                        'id' => 1747,
                        'lang' => 'en',
                        'lang_key' => 'View all ',
                        'lang_value' => 'View all ',
                        'created_at' => '2021-05-03 13:03:39',
                        'updated_at' => '2021-05-03 13:03:39',
                    ),
                466 =>
                    array(
                        'id' => 1748,
                        'lang' => 'en',
                        'lang_key' => 'Register to B2BWood',
                        'lang_value' => 'Register to B2BWood',
                        'created_at' => '2021-05-03 13:03:39',
                        'updated_at' => '2021-05-03 13:03:39',
                    ),
                467 =>
                    array(
                        'id' => 1749,
                        'lang' => 'en',
                        'lang_key' => 'Building brands people can\'t live without is how our clients grow.',
                        'lang_value' => 'Building brands people can\'t live without is how our clients grow.',
                        'created_at' => '2021-05-03 13:03:39',
                        'updated_at' => '2021-05-03 13:03:39',
                    ),
                468 =>
                    array(
                        'id' => 1750,
                        'lang' => 'en',
                        'lang_key' => 'Try it out',
                        'lang_value' => 'Try it out',
                        'created_at' => '2021-05-03 13:03:39',
                        'updated_at' => '2021-05-03 13:03:39',
                    ),
                469 =>
                    array(
                        'id' => 1751,
                        'lang' => 'en',
                        'lang_key' => 'All uploaded files',
                        'lang_value' => 'All uploaded files',
                        'created_at' => '2021-05-03 13:47:45',
                        'updated_at' => '2021-05-03 13:47:45',
                    ),
                470 =>
                    array(
                        'id' => 1752,
                        'lang' => 'en',
                        'lang_key' => 'Upload New File',
                        'lang_value' => 'Upload New File',
                        'created_at' => '2021-05-03 13:47:45',
                        'updated_at' => '2021-05-03 13:47:45',
                    ),
                471 =>
                    array(
                        'id' => 1753,
                        'lang' => 'en',
                        'lang_key' => 'All files',
                        'lang_value' => 'All files',
                        'created_at' => '2021-05-03 13:47:45',
                        'updated_at' => '2021-05-03 13:47:45',
                    ),
                472 =>
                    array(
                        'id' => 1754,
                        'lang' => 'en',
                        'lang_key' => 'Search',
                        'lang_value' => 'Search',
                        'created_at' => '2021-05-03 13:47:45',
                        'updated_at' => '2021-05-03 13:47:45',
                    ),
                473 =>
                    array(
                        'id' => 1755,
                        'lang' => 'en',
                        'lang_key' => 'Details Info',
                        'lang_value' => 'Details Info',
                        'created_at' => '2021-05-03 13:47:45',
                        'updated_at' => '2021-05-03 13:47:45',
                    ),
                474 =>
                    array(
                        'id' => 1756,
                        'lang' => 'en',
                        'lang_key' => 'Copy Link',
                        'lang_value' => 'Copy Link',
                        'created_at' => '2021-05-03 13:47:45',
                        'updated_at' => '2021-05-03 13:47:45',
                    ),
                475 =>
                    array(
                        'id' => 1757,
                        'lang' => 'en',
                        'lang_key' => 'Are you sure to delete this file?',
                        'lang_value' => 'Are you sure to delete this file?',
                        'created_at' => '2021-05-03 13:47:45',
                        'updated_at' => '2021-05-03 13:47:45',
                    ),
                476 =>
                    array(
                        'id' => 1758,
                        'lang' => 'en',
                        'lang_key' => 'File Info',
                        'lang_value' => 'File Info',
                        'created_at' => '2021-05-03 13:47:45',
                        'updated_at' => '2021-05-03 13:47:45',
                    ),
                477 =>
                    array(
                        'id' => 1759,
                        'lang' => 'en',
                        'lang_key' => 'All Countries',
                        'lang_value' => 'All Countries',
                        'created_at' => '2021-05-03 13:57:10',
                        'updated_at' => '2021-05-03 13:57:10',
                    ),
                478 =>
                    array(
                        'id' => 1760,
                        'lang' => 'en',
                        'lang_key' => 'Yearly Income',
                        'lang_value' => 'Yearly Income',
                        'created_at' => '2021-05-03 13:57:10',
                        'updated_at' => '2021-05-03 13:57:10',
                    ),
                479 =>
                    array(
                        'id' => 1761,
                        'lang' => 'en',
                        'lang_key' => 'Company Size',
                        'lang_value' => 'Company Size',
                        'created_at' => '2021-05-03 13:57:10',
                        'updated_at' => '2021-05-03 13:57:10',
                    ),
                480 =>
                    array(
                        'id' => 1762,
                        'lang' => 'en',
                        'lang_key' => 'Find',
                        'lang_value' => 'Find',
                        'created_at' => '2021-05-10 07:46:37',
                        'updated_at' => '2021-05-10 07:46:37',
                    ),
                481 =>
                    array(
                        'id' => 1763,
                        'lang' => 'en',
                        'lang_key' => 'in',
                        'lang_value' => 'in',
                        'created_at' => '2021-05-10 07:46:37',
                        'updated_at' => '2021-05-10 07:46:37',
                    ),
                482 =>
                    array(
                        'id' => 1764,
                        'lang' => 'en',
                        'lang_key' => 'Search through over',
                        'lang_value' => 'Search through over',
                        'created_at' => '2021-05-10 07:46:37',
                        'updated_at' => '2021-05-10 07:46:37',
                    ),
                483 =>
                    array(
                        'id' => 1765,
                        'lang' => 'en',
                        'lang_key' => 'Join The Club!',
                        'lang_value' => 'Join The Club!',
                        'created_at' => '2021-05-10 07:46:37',
                        'updated_at' => '2021-05-10 07:46:37',
                    ),
                484 =>
                    array(
                        'id' => 1766,
                        'lang' => 'en',
                        'lang_key' => 'Views',
                        'lang_value' => 'Views',
                        'created_at' => '2021-05-11 16:47:44',
                        'updated_at' => '2021-05-11 16:47:44',
                    ),
                485 =>
                    array(
                        'id' => 1767,
                        'lang' => 'en',
                        'lang_key' => 'Comments',
                        'lang_value' => 'Comments',
                        'created_at' => '2021-05-11 16:47:44',
                        'updated_at' => '2021-05-11 16:47:44',
                    ),
                486 =>
                    array(
                        'id' => 1768,
                        'lang' => 'en',
                        'lang_key' => 'min. Read',
                        'lang_value' => 'min. Read',
                        'created_at' => '2021-05-11 16:48:24',
                        'updated_at' => '2021-05-11 16:48:24',
                    ),
                487 =>
                    array(
                        'id' => 1769,
                        'lang' => 'en',
                        'lang_key' => 'Manage Attributes',
                        'lang_value' => 'Manage Attributes',
                        'created_at' => '2021-05-13 12:17:59',
                        'updated_at' => '2021-05-13 12:17:59',
                    ),
                488 =>
                    array(
                        'id' => 1770,
                        'lang' => 'en',
                        'lang_key' => 'Company Attributes',
                        'lang_value' => 'Company Attributes',
                        'created_at' => '2021-05-13 12:18:04',
                        'updated_at' => '2021-05-13 12:18:04',
                    ),
                489 =>
                    array(
                        'id' => 1771,
                        'lang' => 'en',
                        'lang_key' => 'ID',
                        'lang_value' => 'ID',
                        'created_at' => '2021-05-13 12:20:50',
                        'updated_at' => '2021-05-13 12:20:50',
                    ),
            ));

        }
    }
}
