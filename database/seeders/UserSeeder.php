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

            \DB::table('users')->insert(array(
                0 =>
                    array(
                        'id' => 4,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 1',
                        'email' => 'seller1@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                1 =>
                    array(
                        'id' => 5,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 2',
                        'email' => 'seller2@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                2 =>
                    array(
                        'id' => 6,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 3',
                        'email' => 'seller3@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                3 =>
                    array(
                        'id' => 7,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 4',
                        'email' => 'seller4@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                4 =>
                    array(
                        'id' => 8,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 5',
                        'email' => 'seller5@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                5 =>
                    array(
                        'id' => 9,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 6',
                        'email' => 'seller6@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                6 =>
                    array(
                        'id' => 10,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 7',
                        'email' => 'seller7@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                7 =>
                    array(
                        'id' => 11,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 8',
                        'email' => 'seller8@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                8 =>
                    array(
                        'id' => 12,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 9',
                        'email' => 'seller9@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                9 =>
                    array(
                        'id' => 13,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 10',
                        'email' => 'seller10@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                10 =>
                    array(
                        'id' => 14,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 11',
                        'email' => 'seller11@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                11 =>
                    array(
                        'id' => 15,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 12',
                        'email' => 'seller12@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                12 =>
                    array(
                        'id' => 16,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 13',
                        'email' => 'seller13@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                13 =>
                    array(
                        'id' => 17,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 14',
                        'email' => 'seller14@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                14 =>
                    array(
                        'id' => 18,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 15',
                        'email' => 'seller15@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                15 =>
                    array(
                        'id' => 19,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 16',
                        'email' => 'seller16@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                16 =>
                    array(
                        'id' => 20,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 17',
                        'email' => 'seller17@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                17 =>
                    array(
                        'id' => 21,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 18',
                        'email' => 'seller18@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                18 =>
                    array(
                        'id' => 22,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 19',
                        'email' => 'seller19@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
                19 =>
                    array(
                        'id' => 23,
                        'user_type' => 'seller',
                        'name' => 'Seller Example 20',
                        'email' => 'seller20@example.com',
                        'password' => Hash::make('123456'),
                        'email_verified_at' => '2021-06-01 15:35:41',
                        'verification_code' => 'eyJpdiI6InhqWGNTejBNS1NiMDVuN0trelJER3c9PSIsInZhbHVlIjoiaGYxc0xBQUN1UWRXQ1grN2cvcnlsUT09IiwibWFjIjoiZDA5NDNmZWVhMjkwOWI3MDg1NzRmYTVlMjBmM2NhOGE4OTZlNTk1Y2Y5ZThlN2JkMzU3YjE3YmFhOWIyZjhmMCJ9',
                    ),
            ));
        }
    }
}
