<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BusinessSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('business_settings')->count() == 0) {
            \DB::table('business_settings')->delete();

            \DB::table('business_settings')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'type' => 'home_default_currency',
                        'value' => '9',
                        'created_at' => '2018-10-16 04:35:52',
                        'updated_at' => '2021-04-08 12:02:45',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'type' => 'system_default_currency',
                        'value' => '9',
                        'created_at' => '2018-10-16 04:36:58',
                        'updated_at' => '2021-04-08 12:02:45',
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'type' => 'currency_format',
                        'value' => '1',
                        'created_at' => '2018-10-17 06:01:59',
                        'updated_at' => '2018-10-17 06:01:59',
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'type' => 'symbol_format',
                        'value' => '1',
                        'created_at' => '2018-10-17 06:01:59',
                        'updated_at' => '2019-01-20 04:10:55',
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'type' => 'no_of_decimals',
                        'value' => '3',
                        'created_at' => '2018-10-17 06:01:59',
                        'updated_at' => '2020-03-04 02:57:16',
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'type' => 'product_activation',
                        'value' => '1',
                        'created_at' => '2018-10-28 03:38:37',
                        'updated_at' => '2019-02-04 03:11:41',
                    ),
                6 =>
                    array(
                        'id' => 7,
                        'type' => 'vendor_system_activation',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:44:16',
                        'updated_at' => '2019-02-04 03:11:38',
                    ),
                7 =>
                    array(
                        'id' => 8,
                        'type' => 'show_vendors',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:44:47',
                        'updated_at' => '2019-02-04 03:11:13',
                    ),
                8 =>
                    array(
                        'id' => 9,
                        'type' => 'paypal_payment',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:45:16',
                        'updated_at' => '2021-04-08 12:59:12',
                    ),
                9 =>
                    array(
                        'id' => 10,
                        'type' => 'stripe_payment',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:45:47',
                        'updated_at' => '2021-04-08 12:59:08',
                    ),
                10 =>
                    array(
                        'id' => 11,
                        'type' => 'cash_payment',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:46:05',
                        'updated_at' => '2019-01-24 05:40:18',
                    ),
                11 =>
                    array(
                        'id' => 12,
                        'type' => 'payumoney_payment',
                        'value' => '0',
                        'created_at' => '2018-10-28 09:46:27',
                        'updated_at' => '2019-03-05 07:41:36',
                    ),
                12 =>
                    array(
                        'id' => 13,
                        'type' => 'best_selling',
                        'value' => '1',
                        'created_at' => '2018-12-24 10:13:44',
                        'updated_at' => '2019-02-14 07:29:13',
                    ),
                13 =>
                    array(
                        'id' => 14,
                        'type' => 'paypal_sandbox',
                        'value' => '0',
                        'created_at' => '2019-01-16 14:44:18',
                        'updated_at' => '2019-01-16 14:44:18',
                    ),
                14 =>
                    array(
                        'id' => 15,
                        'type' => 'sslcommerz_sandbox',
                        'value' => '1',
                        'created_at' => '2019-01-16 14:44:18',
                        'updated_at' => '2019-03-14 02:07:26',
                    ),
                15 =>
                    array(
                        'id' => 16,
                        'type' => 'sslcommerz_payment',
                        'value' => '0',
                        'created_at' => '2019-01-24 11:39:07',
                        'updated_at' => '2019-01-29 08:13:46',
                    ),
                16 =>
                    array(
                        'id' => 17,
                        'type' => 'vendor_commission',
                        'value' => '20',
                        'created_at' => '2019-01-31 08:18:04',
                        'updated_at' => '2019-04-13 09:49:26',
                    ),
                17 =>
                    array(
                        'id' => 18,
                        'type' => 'verification_form',
                        'value' => '[{"type":"text","label":"Your name"},{"type":"text","label":"Shop name"},{"type":"text","label":"Email"},{"type":"text","label":"License No"},{"type":"text","label":"Full Address"},{"type":"text","label":"Phone Number"},{"type":"file","label":"Tax Papers"}]',
                        'created_at' => '2019-02-03 13:36:58',
                        'updated_at' => '2019-02-16 08:14:42',
                    ),
                18 =>
                    array(
                        'id' => 19,
                        'type' => 'google_analytics',
                        'value' => '0',
                        'created_at' => '2019-02-06 14:22:35',
                        'updated_at' => '2019-02-06 14:22:35',
                    ),
                19 =>
                    array(
                        'id' => 20,
                        'type' => 'facebook_login',
                        'value' => '1',
                        'created_at' => '2019-02-07 14:51:59',
                        'updated_at' => '2021-04-08 12:59:23',
                    ),
                20 =>
                    array(
                        'id' => 21,
                        'type' => 'google_login',
                        'value' => '1',
                        'created_at' => '2019-02-07 14:52:10',
                        'updated_at' => '2021-04-08 12:59:24',
                    ),
                21 =>
                    array(
                        'id' => 22,
                        'type' => 'twitter_login',
                        'value' => '1',
                        'created_at' => '2019-02-07 14:52:20',
                        'updated_at' => '2021-04-08 12:59:25',
                    ),
                22 =>
                    array(
                        'id' => 23,
                        'type' => 'payumoney_payment',
                        'value' => '1',
                        'created_at' => '2019-03-05 13:38:17',
                        'updated_at' => '2019-03-05 13:38:17',
                    ),
                23 =>
                    array(
                        'id' => 24,
                        'type' => 'payumoney_sandbox',
                        'value' => '1',
                        'created_at' => '2019-03-05 13:38:17',
                        'updated_at' => '2019-03-05 07:39:18',
                    ),
                24 =>
                    array(
                        'id' => 36,
                        'type' => 'facebook_chat',
                        'value' => '0',
                        'created_at' => '2019-04-15 14:45:04',
                        'updated_at' => '2019-04-15 14:45:04',
                    ),
                25 =>
                    array(
                        'id' => 37,
                        'type' => 'email_verification',
                        'value' => '0',
                        'created_at' => '2019-04-30 10:30:07',
                        'updated_at' => '2019-04-30 10:30:07',
                    ),
                26 =>
                    array(
                        'id' => 38,
                        'type' => 'wallet_system',
                        'value' => '1',
                        'created_at' => '2019-05-19 11:05:44',
                        'updated_at' => '2021-04-08 12:58:55',
                    ),
                27 =>
                    array(
                        'id' => 39,
                        'type' => 'coupon_system',
                        'value' => '1',
                        'created_at' => '2019-06-11 12:46:18',
                        'updated_at' => '2021-04-08 12:59:03',
                    ),
                28 =>
                    array(
                        'id' => 40,
                        'type' => 'current_version',
                        'value' => '4.3',
                        'created_at' => '2019-06-11 12:46:18',
                        'updated_at' => '2019-06-11 12:46:18',
                    ),
                29 =>
                    array(
                        'id' => 41,
                        'type' => 'instamojo_payment',
                        'value' => '0',
                        'created_at' => '2019-07-06 12:58:03',
                        'updated_at' => '2019-07-06 12:58:03',
                    ),
                30 =>
                    array(
                        'id' => 42,
                        'type' => 'instamojo_sandbox',
                        'value' => '1',
                        'created_at' => '2019-07-06 12:58:43',
                        'updated_at' => '2019-07-06 12:58:43',
                    ),
                31 =>
                    array(
                        'id' => 43,
                        'type' => 'razorpay',
                        'value' => '0',
                        'created_at' => '2019-07-06 12:58:43',
                        'updated_at' => '2019-07-06 12:58:43',
                    ),
                32 =>
                    array(
                        'id' => 44,
                        'type' => 'paystack',
                        'value' => '0',
                        'created_at' => '2019-07-21 16:00:38',
                        'updated_at' => '2019-07-21 16:00:38',
                    ),
                33 =>
                    array(
                        'id' => 45,
                        'type' => 'pickup_point',
                        'value' => '1',
                        'created_at' => '2019-10-17 14:50:39',
                        'updated_at' => '2021-04-08 12:59:37',
                    ),
                34 =>
                    array(
                        'id' => 46,
                        'type' => 'maintenance_mode',
                        'value' => '0',
                        'created_at' => '2019-10-17 14:51:04',
                        'updated_at' => '2019-10-17 14:51:04',
                    ),
                35 =>
                    array(
                        'id' => 47,
                        'type' => 'voguepay',
                        'value' => '0',
                        'created_at' => '2019-10-17 14:51:24',
                        'updated_at' => '2019-10-17 14:51:24',
                    ),
                36 =>
                    array(
                        'id' => 48,
                        'type' => 'voguepay_sandbox',
                        'value' => '0',
                        'created_at' => '2019-10-17 14:51:38',
                        'updated_at' => '2019-10-17 14:51:38',
                    ),
                37 =>
                    array(
                        'id' => 50,
                        'type' => 'category_wise_commission',
                        'value' => '0',
                        'created_at' => '2020-01-21 09:22:47',
                        'updated_at' => '2020-01-21 09:22:47',
                    ),
                38 =>
                    array(
                        'id' => 51,
                        'type' => 'conversation_system',
                        'value' => '1',
                        'created_at' => '2020-01-21 09:23:21',
                        'updated_at' => '2020-01-21 09:23:21',
                    ),
                39 =>
                    array(
                        'id' => 52,
                        'type' => 'guest_checkout_active',
                        'value' => '1',
                        'created_at' => '2020-01-22 09:36:38',
                        'updated_at' => '2020-01-22 09:36:38',
                    ),
                40 =>
                    array(
                        'id' => 53,
                        'type' => 'facebook_pixel',
                        'value' => '0',
                        'created_at' => '2020-01-22 13:43:58',
                        'updated_at' => '2020-01-22 13:43:58',
                    ),
                41 =>
                    array(
                        'id' => 55,
                        'type' => 'classified_product',
                        'value' => '1',
                        'created_at' => '2020-05-13 16:01:05',
                        'updated_at' => '2021-04-08 12:58:57',
                    ),
                42 =>
                    array(
                        'id' => 56,
                        'type' => 'pos_activation_for_seller',
                        'value' => '1',
                        'created_at' => '2020-06-11 12:45:02',
                        'updated_at' => '2020-06-11 12:45:02',
                    ),
                43 =>
                    array(
                        'id' => 57,
                        'type' => 'shipping_type',
                        'value' => 'product_wise_shipping',
                        'created_at' => '2020-07-01 16:49:56',
                        'updated_at' => '2020-07-01 16:49:56',
                    ),
                44 =>
                    array(
                        'id' => 58,
                        'type' => 'flat_rate_shipping_cost',
                        'value' => '0',
                        'created_at' => '2020-07-01 16:49:56',
                        'updated_at' => '2020-07-01 16:49:56',
                    ),
                45 =>
                    array(
                        'id' => 59,
                        'type' => 'shipping_cost_admin',
                        'value' => '0',
                        'created_at' => '2020-07-01 16:49:56',
                        'updated_at' => '2020-07-01 16:49:56',
                    ),
                46 =>
                    array(
                        'id' => 60,
                        'type' => 'payhere_sandbox',
                        'value' => '0',
                        'created_at' => '2020-07-30 21:23:53',
                        'updated_at' => '2020-07-30 21:23:53',
                    ),
                47 =>
                    array(
                        'id' => 61,
                        'type' => 'payhere',
                        'value' => '0',
                        'created_at' => '2020-07-30 21:23:53',
                        'updated_at' => '2020-07-30 21:23:53',
                    ),
                48 =>
                    array(
                        'id' => 62,
                        'type' => 'google_recaptcha',
                        'value' => '0',
                        'created_at' => '2020-08-17 10:13:37',
                        'updated_at' => '2020-08-17 10:13:37',
                    ),
                49 =>
                    array(
                        'id' => 63,
                        'type' => 'ngenius',
                        'value' => '0',
                        'created_at' => '2020-09-22 13:58:21',
                        'updated_at' => '2020-09-22 13:58:21',
                    ),
                50 =>
                    array(
                        'id' => 64,
                        'type' => 'header_logo',
                        'value' => '11',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:26:22',
                    ),
                51 =>
                    array(
                        'id' => 65,
                        'type' => 'show_language_switcher',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:17:57',
                    ),
                52 =>
                    array(
                        'id' => 66,
                        'type' => 'show_currency_switcher',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:17:57',
                    ),
                53 =>
                    array(
                        'id' => 67,
                        'type' => 'header_stikcy',
                        'value' => 'on',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                54 =>
                    array(
                        'id' => 68,
                        'type' => 'footer_logo',
                        'value' => '11',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:34:42',
                    ),
                55 =>
                    array(
                        'id' => 69,
                        'type' => 'about_us_description',
                        'value' => 'B2BWood platform helps to increase sales. You can promote your products on the platform, many simple users will see furniture products from different countries, so you will be know for global market.',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:34:42',
                    ),
                56 =>
                    array(
                        'id' => 70,
                        'type' => 'contact_address',
                        'value' => 'Laisvės alėja 59',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:52',
                    ),
                57 =>
                    array(
                        'id' => 71,
                        'type' => 'contact_phone',
                        'value' => '+37061187792',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:52',
                    ),
                58 =>
                    array(
                        'id' => 72,
                        'type' => 'contact_email',
                        'value' => 'support@b2bwood.com',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:52',
                    ),
                59 =>
                    array(
                        'id' => 73,
                        'type' => 'widget_one_labels',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                60 =>
                    array(
                        'id' => 74,
                        'type' => 'widget_one_links',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                61 =>
                    array(
                        'id' => 75,
                        'type' => 'widget_one',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                62 =>
                    array(
                        'id' => 76,
                        'type' => 'frontend_copyright_text',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                63 =>
                    array(
                        'id' => 77,
                        'type' => 'show_social_links',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                64 =>
                    array(
                        'id' => 78,
                        'type' => 'facebook_link',
                        'value' => 'https://www.facebook.com/B2BWood/',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:02:50',
                    ),
                65 =>
                    array(
                        'id' => 79,
                        'type' => 'twitter_link',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                66 =>
                    array(
                        'id' => 80,
                        'type' => 'instagram_link',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                67 =>
                    array(
                        'id' => 81,
                        'type' => 'youtube_link',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                68 =>
                    array(
                        'id' => 82,
                        'type' => 'linkedin_link',
                        'value' => 'https://www.linkedin.com/company/uab-b2b-wood/',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:02:50',
                    ),
                69 =>
                    array(
                        'id' => 83,
                        'type' => 'payment_method_images',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                70 =>
                    array(
                        'id' => 84,
                        'type' => 'home_slider_images',
                        'value' => '["24"]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 14:38:00',
                    ),
                71 =>
                    array(
                        'id' => 85,
                        'type' => 'home_slider_links',
                        'value' => '["https:\\/\\/b2bwood.com"]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:43:09',
                    ),
                72 =>
                    array(
                        'id' => 86,
                        'type' => 'home_banner1_images',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 14:37:21',
                    ),
                73 =>
                    array(
                        'id' => 87,
                        'type' => 'home_banner1_links',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 14:37:21',
                    ),
                74 =>
                    array(
                        'id' => 88,
                        'type' => 'home_banner2_images',
                        'value' => '[]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                75 =>
                    array(
                        'id' => 89,
                        'type' => 'home_banner2_links',
                        'value' => '[]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                76 =>
                    array(
                        'id' => 90,
                        'type' => 'home_categories',
                        'value' => '[]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                77 =>
                    array(
                        'id' => 91,
                        'type' => 'top10_categories',
                        'value' => '["1","2","3","5","6"]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 14:37:18',
                    ),
                78 =>
                    array(
                        'id' => 92,
                        'type' => 'top10_brands',
                        'value' => '["1"]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:43:40',
                    ),
                79 =>
                    array(
                        'id' => 93,
                        'type' => 'website_name',
                        'value' => 'B2BWood',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:04',
                    ),
                80 =>
                    array(
                        'id' => 94,
                        'type' => 'site_motto',
                        'value' => 'Wood Industry News And Companies catalog',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:04',
                    ),
                81 =>
                    array(
                        'id' => 95,
                        'type' => 'site_icon',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                82 =>
                    array(
                        'id' => 96,
                        'type' => 'base_color',
                        'value' => '#cfa16d',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:35:59',
                    ),
                83 =>
                    array(
                        'id' => 97,
                        'type' => 'base_hov_color',
                        'value' => '#032c2a',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:04',
                    ),
                84 =>
                    array(
                        'id' => 98,
                        'type' => 'meta_title',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                85 =>
                    array(
                        'id' => 99,
                        'type' => 'meta_description',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                86 =>
                    array(
                        'id' => 100,
                        'type' => 'meta_keywords',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                87 =>
                    array(
                        'id' => 101,
                        'type' => 'meta_image',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                88 =>
                    array(
                        'id' => 102,
                        'type' => 'site_name',
                        'value' => 'B2BWood',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:58:39',
                    ),
                89 =>
                    array(
                        'id' => 103,
                        'type' => 'system_logo_white',
                        'value' => '9',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:58:39',
                    ),
                90 =>
                    array(
                        'id' => 104,
                        'type' => 'system_logo_black',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                91 =>
                    array(
                        'id' => 105,
                        'type' => 'timezone',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                92 =>
                    array(
                        'id' => 106,
                        'type' => 'admin_login_background',
                        'value' => '10',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:58:39',
                    ),
                93 =>
                    array(
                        'id' => 107,
                        'type' => 'iyzico_sandbox',
                        'value' => '1',
                        'created_at' => '2020-12-30 18:45:56',
                        'updated_at' => '2020-12-30 18:45:56',
                    ),
                94 =>
                    array(
                        'id' => 108,
                        'type' => 'iyzico',
                        'value' => '1',
                        'created_at' => '2020-12-30 18:45:56',
                        'updated_at' => '2020-12-30 18:45:56',
                    ),
                95 =>
                    array(
                        'id' => 109,
                        'type' => 'decimal_separator',
                        'value' => '1',
                        'created_at' => '2020-12-30 18:45:56',
                        'updated_at' => '2020-12-30 18:45:56',
                    ),
                96 =>
                    array(
                        'id' => 110,
                        'type' => 'nagad',
                        'value' => '0',
                        'created_at' => '2021-01-22 12:30:03',
                        'updated_at' => '2021-01-22 12:30:03',
                    ),
                97 =>
                    array(
                        'id' => 111,
                        'type' => 'bkash',
                        'value' => '0',
                        'created_at' => '2021-01-22 12:30:03',
                        'updated_at' => '2021-01-22 12:30:03',
                    ),
                98 =>
                    array(
                        'id' => 112,
                        'type' => 'bkash_sandbox',
                        'value' => '1',
                        'created_at' => '2021-01-22 12:30:03',
                        'updated_at' => '2021-01-22 12:30:03',
                    ),
                99 =>
                    array(
                        'id' => 113,
                        'type' => 'header_menu_labels',
                        'value' => '["Home","News","Marketplace","Companies","Events","Calendar","Business For Sale","Investments","Jobs","Education"]',
                        'created_at' => '2021-02-16 04:43:11',
                        'updated_at' => '2021-04-10 11:57:02',
                    ),
                100 =>
                    array(
                        'id' => 114,
                        'type' => 'header_menu_links',
                        'value' => '["\\/","\\/news","\\/search","\\/sellers","\\/events","\\/calendar","\\/business-for-sale","\\/investments","\\/jobs","\\/education"]',
                        'created_at' => '2021-02-16 04:43:11',
                        'updated_at' => '2021-05-10 09:12:27',
                    ),
                101 =>
                    array(
                        'id' => 115,
                        'type' => 'product_manage_by_admin',
                        'value' => '1',
                        'created_at' => '2021-04-08 12:59:02',
                        'updated_at' => '2021-04-08 12:59:02',
                    ),
            ));

        }
    }
}
