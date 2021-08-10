<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeneralSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('general_settings')->count() == 0) {
            \DB::table('general_settings')->delete();

            \DB::table('general_settings')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'frontend_color' => 'default',
                        'logo' => 'uploads/logo/pfdIuiMeXGkDAIpPEUrvUCbQrOHu484nbGfz77zB.png',
                        'footer_logo' => NULL,
                        'admin_logo' => 'uploads/admin_logo/wCgHrz0Q5QoL1yu4vdrNnQIr4uGuNL48CXfcxOuS.png',
                        'admin_login_background' => NULL,
                        'admin_login_sidebar' => NULL,
                        'favicon' => 'uploads/favicon/uHdGidSaRVzvPgDj6JFtntMqzJkwDk9659233jrb.png',
                        'site_name' => 'Active Ecommerce CMS',
                        'address' => 'Demo Address',
                        'description' => 'Active eCommerce CMS is a Multi vendor system is such a platform to build a border less marketplace.',
                        'phone' => '1234567890',
                        'email' => 'admin@example.com',
                        'facebook' => 'https://www.facebook.com',
                        'instagram' => 'https://www.instagram.com',
                        'twitter' => 'https://www.twitter.com',
                        'youtube' => 'https://www.youtube.com',
                        'google_plus' => 'https://www.googleplus.com',
                        'created_at' => '2019-03-13 10:01:06',
                        'updated_at' => '2019-03-13 04:01:06',
                    ),
            ));
        }

    }
}
