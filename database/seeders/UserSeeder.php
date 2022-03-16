<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('users')->count() == 0) {
            \DB::table('users')->delete();

            DB::table('users')->insert([
                'id' => 1,
                'user_type' => 'admin',
                'name' => "EIM Solutions",
                'email' => 'team@eim.solutions',
                'password' => Hash::make('123456'),
                'email_verified_at' => '2021-06-01 15:35:41',
                'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
            ]);

            DB::table('users')->insert([
                'id' => 2,
                'user_type' => 'seller',
                'name' => "Mr Seller",
                'email' => 'seller@eim.solutions',
                'password' => Hash::make('123456'),
                'email_verified_at' => '2021-06-01 15:35:41',
                'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
            ]);
            DB::table('users')->insert([
                'id' => 3,
                'user_type' => 'customer',
                'name' => "Mr Customer",
                'email' => 'customer@eim.solutions',
                'password' => Hash::make('123456'),
                'email_verified_at' => '2021-06-01 15:35:41',
                'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
            ]);

            /* TODO: Add this data only for multi-vendor marketplace instances */
            // \DB::table('users')->insert(array(
            //     0 =>
            //         array(
            //             'id' => 4,
            //             'user_type' => 'seller',
            //             'name' => 'Shop 1',
            //             'email' => 'seller1@example.com',
            //             'password' => Hash::make('123456'),
            //             'email_verified_at' => '2021-06-01 15:35:41',
            //             'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
            //         ),
            //     1 =>
            //         array(
            //             'id' => 5,
            //             'user_type' => 'seller',
            //             'name' => 'Shop 2',
            //             'email' => 'seller2@example.com',
            //             'password' => Hash::make('123456'),
            //             'email_verified_at' => '2021-06-01 15:35:41',
            //             'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
            //         ),
            //     2 =>
            //         array(
            //             'id' => 6,
            //             'user_type' => 'seller',
            //             'name' => 'Shop 3',
            //             'email' => 'seller3@example.com',
            //             'password' => Hash::make('123456'),
            //             'email_verified_at' => '2021-06-01 15:35:41',
            //             'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
            //         ),
            // ));
        }
    }
}
