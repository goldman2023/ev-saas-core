<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TenantSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('tenant_settings')->count() == 0) {
            \DB::table('tenant_settings')->delete();

            \DB::table('tenant_settings')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'setting' => 'home_default_currency',
                        'value' => '9',
                        'created_at' => '2018-10-16 04:35:52',
                        'updated_at' => '2021-04-08 12:02:45',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'setting' => 'system_default_currency',
                        'value' => '9',
                        'created_at' => '2018-10-16 04:36:58',
                        'updated_at' => '2021-04-08 12:02:45',
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'setting' => 'currency_format',
                        'value' => '1',
                        'created_at' => '2018-10-17 06:01:59',
                        'updated_at' => '2018-10-17 06:01:59',
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'setting' => 'symbol_format',
                        'value' => '1',
                        'created_at' => '2018-10-17 06:01:59',
                        'updated_at' => '2019-01-20 04:10:55',
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'setting' => 'no_of_decimals',
                        'value' => '3',
                        'created_at' => '2018-10-17 06:01:59',
                        'updated_at' => '2020-03-04 02:57:16',
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'setting' => 'product_activation',
                        'value' => '1',
                        'created_at' => '2018-10-28 03:38:37',
                        'updated_at' => '2019-02-04 03:11:41',
                    ),
                6 =>
                    array(
                        'id' => 7,
                        'setting' => 'vendor_system_activation',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:44:16',
                        'updated_at' => '2019-02-04 03:11:38',
                    ),
                7 =>
                    array(
                        'id' => 8,
                        'setting' => 'show_vendors',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:44:47',
                        'updated_at' => '2019-02-04 03:11:13',
                    ),
                8 =>
                    array(
                        'id' => 9,
                        'setting' => 'paypal_payment',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:45:16',
                        'updated_at' => '2021-04-08 12:59:12',
                    ),
                9 =>
                    array(
                        'id' => 10,
                        'setting' => 'stripe_payment',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:45:47',
                        'updated_at' => '2021-04-08 12:59:08',
                    ),
                10 =>
                    array(
                        'id' => 11,
                        'setting' => 'cash_payment',
                        'value' => '1',
                        'created_at' => '2018-10-28 09:46:05',
                        'updated_at' => '2019-01-24 05:40:18',
                    ),
                11 =>
                    array(
                        'id' => 12,
                        'setting' => 'payumoney_payment',
                        'value' => '0',
                        'created_at' => '2018-10-28 09:46:27',
                        'updated_at' => '2019-03-05 07:41:36',
                    ),
                12 =>
                    array(
                        'id' => 13,
                        'setting' => 'best_selling',
                        'value' => '1',
                        'created_at' => '2018-12-24 10:13:44',
                        'updated_at' => '2019-02-14 07:29:13',
                    ),
                13 =>
                    array(
                        'id' => 14,
                        'setting' => 'paypal_sandbox',
                        'value' => '0',
                        'created_at' => '2019-01-16 14:44:18',
                        'updated_at' => '2019-01-16 14:44:18',
                    ),
                14 =>
                    array(
                        'id' => 15,
                        'setting' => 'sslcommerz_sandbox',
                        'value' => '1',
                        'created_at' => '2019-01-16 14:44:18',
                        'updated_at' => '2019-03-14 02:07:26',
                    ),
                15 =>
                    array(
                        'id' => 16,
                        'setting' => 'sslcommerz_payment',
                        'value' => '0',
                        'created_at' => '2019-01-24 11:39:07',
                        'updated_at' => '2019-01-29 08:13:46',
                    ),
                16 =>
                    array(
                        'id' => 17,
                        'setting' => 'vendor_commission',
                        'value' => '20',
                        'created_at' => '2019-01-31 08:18:04',
                        'updated_at' => '2019-04-13 09:49:26',
                    ),
                17 =>
                    array(
                        'id' => 18,
                        'setting' => 'verification_form',
                        'value' => '[{"setting":"text","label":"Your name"},{"setting":"text","label":"Shop name"},{"setting":"text","label":"Email"},{"setting":"text","label":"License No"},{"setting":"text","label":"Full Address"},{"setting":"text","label":"Phone Number"},{"setting":"file","label":"Tax Papers"}]',
                        'created_at' => '2019-02-03 13:36:58',
                        'updated_at' => '2019-02-16 08:14:42',
                    ),
                18 =>
                    array(
                        'id' => 19,
                        'setting' => 'google_analytics',
                        'value' => '0',
                        'created_at' => '2019-02-06 14:22:35',
                        'updated_at' => '2019-02-06 14:22:35',
                    ),
                19 =>
                    array(
                        'id' => 20,
                        'setting' => 'facebook_login',
                        'value' => '1',
                        'created_at' => '2019-02-07 14:51:59',
                        'updated_at' => '2021-04-08 12:59:23',
                    ),
                20 =>
                    array(
                        'id' => 21,
                        'setting' => 'google_login',
                        'value' => '1',
                        'created_at' => '2019-02-07 14:52:10',
                        'updated_at' => '2021-04-08 12:59:24',
                    ),
                21 =>
                    array(
                        'id' => 22,
                        'setting' => 'twitter_login',
                        'value' => '1',
                        'created_at' => '2019-02-07 14:52:20',
                        'updated_at' => '2021-04-08 12:59:25',
                    ),
                22 =>
                    array(
                        'id' => 23,
                        'setting' => 'payumoney_payment',
                        'value' => '1',
                        'created_at' => '2019-03-05 13:38:17',
                        'updated_at' => '2019-03-05 13:38:17',
                    ),
                23 =>
                    array(
                        'id' => 24,
                        'setting' => 'payumoney_sandbox',
                        'value' => '1',
                        'created_at' => '2019-03-05 13:38:17',
                        'updated_at' => '2019-03-05 07:39:18',
                    ),
                24 =>
                    array(
                        'id' => 36,
                        'setting' => 'facebook_chat',
                        'value' => '0',
                        'created_at' => '2019-04-15 14:45:04',
                        'updated_at' => '2019-04-15 14:45:04',
                    ),
                25 =>
                    array(
                        'id' => 37,
                        'setting' => 'email_verification',
                        'value' => '0',
                        'created_at' => '2019-04-30 10:30:07',
                        'updated_at' => '2019-04-30 10:30:07',
                    ),
                26 =>
                    array(
                        'id' => 38,
                        'setting' => 'wallet_system',
                        'value' => '1',
                        'created_at' => '2019-05-19 11:05:44',
                        'updated_at' => '2021-04-08 12:58:55',
                    ),
                27 =>
                    array(
                        'id' => 39,
                        'setting' => 'coupon_system',
                        'value' => '1',
                        'created_at' => '2019-06-11 12:46:18',
                        'updated_at' => '2021-04-08 12:59:03',
                    ),
                28 =>
                    array(
                        'id' => 40,
                        'setting' => 'current_version',
                        'value' => '4.3',
                        'created_at' => '2019-06-11 12:46:18',
                        'updated_at' => '2019-06-11 12:46:18',
                    ),
                29 =>
                    array(
                        'id' => 41,
                        'setting' => 'instamojo_payment',
                        'value' => '0',
                        'created_at' => '2019-07-06 12:58:03',
                        'updated_at' => '2019-07-06 12:58:03',
                    ),
                30 =>
                    array(
                        'id' => 42,
                        'setting' => 'instamojo_sandbox',
                        'value' => '1',
                        'created_at' => '2019-07-06 12:58:43',
                        'updated_at' => '2019-07-06 12:58:43',
                    ),
                31 =>
                    array(
                        'id' => 43,
                        'setting' => 'razorpay',
                        'value' => '0',
                        'created_at' => '2019-07-06 12:58:43',
                        'updated_at' => '2019-07-06 12:58:43',
                    ),
                32 =>
                    array(
                        'id' => 44,
                        'setting' => 'paystack',
                        'value' => '0',
                        'created_at' => '2019-07-21 16:00:38',
                        'updated_at' => '2019-07-21 16:00:38',
                    ),
                33 =>
                    array(
                        'id' => 45,
                        'setting' => 'pickup_point',
                        'value' => '1',
                        'created_at' => '2019-10-17 14:50:39',
                        'updated_at' => '2021-04-08 12:59:37',
                    ),
                34 =>
                    array(
                        'id' => 46,
                        'setting' => 'maintenance_mode',
                        'value' => '0',
                        'created_at' => '2019-10-17 14:51:04',
                        'updated_at' => '2019-10-17 14:51:04',
                    ),
                35 =>
                    array(
                        'id' => 47,
                        'setting' => 'voguepay',
                        'value' => '0',
                        'created_at' => '2019-10-17 14:51:24',
                        'updated_at' => '2019-10-17 14:51:24',
                    ),
                36 =>
                    array(
                        'id' => 48,
                        'setting' => 'voguepay_sandbox',
                        'value' => '0',
                        'created_at' => '2019-10-17 14:51:38',
                        'updated_at' => '2019-10-17 14:51:38',
                    ),
                37 =>
                    array(
                        'id' => 50,
                        'setting' => 'category_wise_commission',
                        'value' => '0',
                        'created_at' => '2020-01-21 09:22:47',
                        'updated_at' => '2020-01-21 09:22:47',
                    ),
                38 =>
                    array(
                        'id' => 51,
                        'setting' => 'conversation_system',
                        'value' => '1',
                        'created_at' => '2020-01-21 09:23:21',
                        'updated_at' => '2020-01-21 09:23:21',
                    ),
                39 =>
                    array(
                        'id' => 52,
                        'setting' => 'guest_checkout_active',
                        'value' => '1',
                        'created_at' => '2020-01-22 09:36:38',
                        'updated_at' => '2020-01-22 09:36:38',
                    ),
                40 =>
                    array(
                        'id' => 53,
                        'setting' => 'facebook_pixel',
                        'value' => '0',
                        'created_at' => '2020-01-22 13:43:58',
                        'updated_at' => '2020-01-22 13:43:58',
                    ),
                41 =>
                    array(
                        'id' => 55,
                        'setting' => 'classified_product',
                        'value' => '1',
                        'created_at' => '2020-05-13 16:01:05',
                        'updated_at' => '2021-04-08 12:58:57',
                    ),
                42 =>
                    array(
                        'id' => 56,
                        'setting' => 'pos_activation_for_seller',
                        'value' => '1',
                        'created_at' => '2020-06-11 12:45:02',
                        'updated_at' => '2020-06-11 12:45:02',
                    ),
                43 =>
                    array(
                        'id' => 57,
                        'setting' => 'shipping_setting',
                        'value' => 'product_wise_shipping',
                        'created_at' => '2020-07-01 16:49:56',
                        'updated_at' => '2020-07-01 16:49:56',
                    ),
                44 =>
                    array(
                        'id' => 58,
                        'setting' => 'flat_rate_shipping_cost',
                        'value' => '0',
                        'created_at' => '2020-07-01 16:49:56',
                        'updated_at' => '2020-07-01 16:49:56',
                    ),
                45 =>
                    array(
                        'id' => 59,
                        'setting' => 'shipping_cost_admin',
                        'value' => '0',
                        'created_at' => '2020-07-01 16:49:56',
                        'updated_at' => '2020-07-01 16:49:56',
                    ),
                46 =>
                    array(
                        'id' => 60,
                        'setting' => 'payhere_sandbox',
                        'value' => '0',
                        'created_at' => '2020-07-30 21:23:53',
                        'updated_at' => '2020-07-30 21:23:53',
                    ),
                47 =>
                    array(
                        'id' => 61,
                        'setting' => 'payhere',
                        'value' => '0',
                        'created_at' => '2020-07-30 21:23:53',
                        'updated_at' => '2020-07-30 21:23:53',
                    ),
                48 =>
                    array(
                        'id' => 62,
                        'setting' => 'google_recaptcha',
                        'value' => '0',
                        'created_at' => '2020-08-17 10:13:37',
                        'updated_at' => '2020-08-17 10:13:37',
                    ),
                49 =>
                    array(
                        'id' => 63,
                        'setting' => 'ngenius',
                        'value' => '0',
                        'created_at' => '2020-09-22 13:58:21',
                        'updated_at' => '2020-09-22 13:58:21',
                    ),
                51 =>
                    array(
                        'id' => 65,
                        'setting' => 'show_language_switcher',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:17:57',
                    ),
                52 =>
                    array(
                        'id' => 66,
                        'setting' => 'show_currency_switcher',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:17:57',
                    ),
                53 =>
                    array(
                        'id' => 67,
                        'setting' => 'header_stikcy',
                        'value' => 'on',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),

                55 =>
                    array(
                        'id' => 69,
                        'setting' => 'about_us_description',
                        'value' => 'Your business idea description',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:34:42',
                    ),
                56 =>
                    array(
                        'id' => 70,
                        'setting' => 'contact_address',
                        'value' => 'Your Address',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:52',
                    ),
                57 =>
                    array(
                        'id' => 71,
                        'setting' => 'contact_phone',
                        'value' => '+37061187792',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:52',
                    ),
                58 =>
                    array(
                        'id' => 72,
                        'setting' => 'contact_email',
                        'value' => 'support@we-saas.com',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:52',
                    ),
                59 =>
                    array(
                        'id' => 73,
                        'setting' => 'widget_one_labels',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                60 =>
                    array(
                        'id' => 74,
                        'setting' => 'widget_one_links',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                61 =>
                    array(
                        'id' => 75,
                        'setting' => 'widget_one',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                62 =>
                    array(
                        'id' => 76,
                        'setting' => 'frontend_copyright_text',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                63 =>
                    array(
                        'id' => 77,
                        'setting' => 'show_social_links',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                64 =>
                    array(
                        'id' => 78,
                        'setting' => 'facebook_link',
                        'value' => 'https://www.facebook.com/',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:02:50',
                    ),
                65 =>
                    array(
                        'id' => 79,
                        'setting' => 'twitter_link',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                66 =>
                    array(
                        'id' => 80,
                        'setting' => 'instagram_link',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                67 =>
                    array(
                        'id' => 81,
                        'setting' => 'youtube_link',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                68 =>
                    array(
                        'id' => 82,
                        'setting' => 'linkedin_link',
                        'value' => '#',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:02:50',
                    ),
                69 =>
                    array(
                        'id' => 83,
                        'setting' => 'payment_method_images',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                70 =>
                    array(
                        'id' => 84,
                        'setting' => 'home_slider_images',
                        'value' => '["24"]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 14:38:00',
                    ),
                71 =>
                    array(
                        'id' => 85,
                        'setting' => 'home_slider_links',
                        'value' => '["https:\\/\\/ev-saas.com"]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:43:09',
                    ),
                72 =>
                    array(
                        'id' => 86,
                        'setting' => 'home_banner1_images',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 14:37:21',
                    ),
                73 =>
                    array(
                        'id' => 87,
                        'setting' => 'home_banner1_links',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 14:37:21',
                    ),
                74 =>
                    array(
                        'id' => 88,
                        'setting' => 'home_banner2_images',
                        'value' => '[]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                75 =>
                    array(
                        'id' => 89,
                        'setting' => 'home_banner2_links',
                        'value' => '[]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                76 =>
                    array(
                        'id' => 90,
                        'setting' => 'home_categories',
                        'value' => '[]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                77 =>
                    array(
                        'id' => 91,
                        'setting' => 'top10_categories',
                        'value' => '["1","2","3","5","6"]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 14:37:18',
                    ),
                78 =>
                    array(
                        'id' => 92,
                        'setting' => 'top10_brands',
                        'value' => '["1"]',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:43:40',
                    ),
                79 =>
                    array(
                        'id' => 93,
                        'setting' => 'website_name',
                        'value' => 'EV SaaS App',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:04',
                    ),
                80 =>
                    array(
                        'id' => 94,
                        'setting' => 'site_motto',
                        'value' => 'Perfect canvas for your great business idea',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:04',
                    ),
                81 =>
                    array(
                        'id' => 95,
                        'setting' => 'site_icon',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                82 =>
                    array(
                        'id' => 96,
                        'setting' => 'base_color',
                        'value' => '#cfa16d',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:35:59',
                    ),
                83 =>
                    array(
                        'id' => 97,
                        'setting' => 'base_hov_color',
                        'value' => '#032c2a',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 13:33:04',
                    ),
                84 =>
                    array(
                        'id' => 98,
                        'setting' => 'meta_title',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                85 =>
                    array(
                        'id' => 99,
                        'setting' => 'meta_description',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                86 =>
                    array(
                        'id' => 100,
                        'setting' => 'meta_keywords',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                87 =>
                    array(
                        'id' => 101,
                        'setting' => 'meta_image',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                88 =>
                    array(
                        'id' => 102,
                        'setting' => 'site_name',
                        'value' => 'EV-SaaS Demo',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:58:39',
                    ),
                89 =>
                    array(
                        'id' => 103,
                        'setting' => 'system_logo_white',
                        'value' => '9',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:58:39',
                    ),
                90 =>
                    array(
                        'id' => 104,
                        'setting' => 'system_logo_black',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                91 =>
                    array(
                        'id' => 105,
                        'setting' => 'timezone',
                        'value' => NULL,
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2020-11-16 09:26:36',
                    ),
                92 =>
                    array(
                        'id' => 106,
                        'setting' => 'admin_login_background',
                        'value' => '10',
                        'created_at' => '2020-11-16 09:26:36',
                        'updated_at' => '2021-04-08 12:58:39',
                    ),
                93 =>
                    array(
                        'id' => 107,
                        'setting' => 'iyzico_sandbox',
                        'value' => '1',
                        'created_at' => '2020-12-30 18:45:56',
                        'updated_at' => '2020-12-30 18:45:56',
                    ),
                94 =>
                    array(
                        'id' => 108,
                        'setting' => 'iyzico',
                        'value' => '1',
                        'created_at' => '2020-12-30 18:45:56',
                        'updated_at' => '2020-12-30 18:45:56',
                    ),
                95 =>
                    array(
                        'id' => 109,
                        'setting' => 'decimal_separator',
                        'value' => '1',
                        'created_at' => '2020-12-30 18:45:56',
                        'updated_at' => '2020-12-30 18:45:56',
                    ),
                96 =>
                    array(
                        'id' => 110,
                        'setting' => 'nagad',
                        'value' => '0',
                        'created_at' => '2021-01-22 12:30:03',
                        'updated_at' => '2021-01-22 12:30:03',
                    ),
                97 =>
                    array(
                        'id' => 111,
                        'setting' => 'bkash',
                        'value' => '0',
                        'created_at' => '2021-01-22 12:30:03',
                        'updated_at' => '2021-01-22 12:30:03',
                    ),
                98 =>
                    array(
                        'id' => 112,
                        'setting' => 'bkash_sandbox',
                        'value' => '1',
                        'created_at' => '2021-01-22 12:30:03',
                        'updated_at' => '2021-01-22 12:30:03',
                    ),
                99 =>
                    array(
                        'id' => 113,
                        'setting' => 'header_menu_labels',
                        'value' => '["Home","News","Marketplace","Companies"]',
                        'created_at' => '2021-02-16 04:43:11',
                        'updated_at' => '2021-04-10 11:57:02',
                    ),
                100 =>
                    array(
                        'id' => 114,
                        'setting' => 'header_menu_links',
                        'value' => '["\\/","\\/news","\\/search","\\/sellers"]',
                        'created_at' => '2021-02-16 04:43:11',
                        'updated_at' => '2021-05-10 09:12:27',
                    ),
                101 =>
                    array(
                        'id' => 115,
                        'setting' => 'product_manage_by_admin',
                        'value' => '1',
                        'created_at' => '2021-04-08 12:59:02',
                        'updated_at' => '2021-04-08 12:59:02',
                    ),
            ));

        }
    }
}
