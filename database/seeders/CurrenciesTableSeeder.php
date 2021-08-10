<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('currencies')->count() == 0) {
            \DB::table('currencies')->delete();

            \DB::table('currencies')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'name' => 'U.S. Dollar',
                        'symbol' => '$',
                        'exchange_rate' => 1.0,
                        'status' => 1,
                        'code' => 'USD',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2018-10-17 08:50:52',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'name' => 'Australian Dollar',
                        'symbol' => '$',
                        'exchange_rate' => 1.28,
                        'status' => 0,
                        'code' => 'AUD',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:19',
                    ),
                2 =>
                    array(
                        'id' => 5,
                        'name' => 'Brazilian Real',
                        'symbol' => 'R$',
                        'exchange_rate' => 3.25,
                        'status' => 0,
                        'code' => 'BRL',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:19',
                    ),
                3 =>
                    array(
                        'id' => 6,
                        'name' => 'Canadian Dollar',
                        'symbol' => '$',
                        'exchange_rate' => 1.27,
                        'status' => 0,
                        'code' => 'CAD',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:20',
                    ),
                4 =>
                    array(
                        'id' => 7,
                        'name' => 'Czech Koruna',
                        'symbol' => 'Kč',
                        'exchange_rate' => 20.65,
                        'status' => 0,
                        'code' => 'CZK',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:21',
                    ),
                5 =>
                    array(
                        'id' => 8,
                        'name' => 'Danish Krone',
                        'symbol' => 'kr',
                        'exchange_rate' => 6.05,
                        'status' => 0,
                        'code' => 'DKK',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:22',
                    ),
                6 =>
                    array(
                        'id' => 9,
                        'name' => 'Euro',
                        'symbol' => '€',
                        'exchange_rate' => 0.85,
                        'status' => 1,
                        'code' => 'EUR',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2018-10-09 14:35:08',
                    ),
                7 =>
                    array(
                        'id' => 10,
                        'name' => 'Hong Kong Dollar',
                        'symbol' => '$',
                        'exchange_rate' => 7.83,
                        'status' => 0,
                        'code' => 'HKD',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:24',
                    ),
                8 =>
                    array(
                        'id' => 11,
                        'name' => 'Hungarian Forint',
                        'symbol' => 'Ft',
                        'exchange_rate' => 255.24,
                        'status' => 0,
                        'code' => 'HUF',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:24',
                    ),
                9 =>
                    array(
                        'id' => 12,
                        'name' => 'Israeli New Sheqel',
                        'symbol' => '₪',
                        'exchange_rate' => 3.48,
                        'status' => 0,
                        'code' => 'ILS',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:33',
                    ),
                10 =>
                    array(
                        'id' => 13,
                        'name' => 'Japanese Yen',
                        'symbol' => '¥',
                        'exchange_rate' => 107.12,
                        'status' => 0,
                        'code' => 'JPY',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:33',
                    ),
                11 =>
                    array(
                        'id' => 14,
                        'name' => 'Malaysian Ringgit',
                        'symbol' => 'RM',
                        'exchange_rate' => 3.91,
                        'status' => 0,
                        'code' => 'MYR',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:34',
                    ),
                12 =>
                    array(
                        'id' => 15,
                        'name' => 'Mexican Peso',
                        'symbol' => '$',
                        'exchange_rate' => 18.72,
                        'status' => 0,
                        'code' => 'MXN',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:35',
                    ),
                13 =>
                    array(
                        'id' => 16,
                        'name' => 'Norwegian Krone',
                        'symbol' => 'kr',
                        'exchange_rate' => 7.83,
                        'status' => 0,
                        'code' => 'NOK',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:36',
                    ),
                14 =>
                    array(
                        'id' => 17,
                        'name' => 'New Zealand Dollar',
                        'symbol' => '$',
                        'exchange_rate' => 1.38,
                        'status' => 0,
                        'code' => 'NZD',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:36',
                    ),
                15 =>
                    array(
                        'id' => 18,
                        'name' => 'Philippine Peso',
                        'symbol' => '₱',
                        'exchange_rate' => 52.26,
                        'status' => 0,
                        'code' => 'PHP',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:36',
                    ),
                16 =>
                    array(
                        'id' => 19,
                        'name' => 'Polish Zloty',
                        'symbol' => 'zł',
                        'exchange_rate' => 3.39,
                        'status' => 0,
                        'code' => 'PLN',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:37',
                    ),
                17 =>
                    array(
                        'id' => 20,
                        'name' => 'Pound Sterling',
                        'symbol' => '£',
                        'exchange_rate' => 0.72,
                        'status' => 0,
                        'code' => 'GBP',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:37',
                    ),
                18 =>
                    array(
                        'id' => 21,
                        'name' => 'Russian Ruble',
                        'symbol' => 'руб',
                        'exchange_rate' => 55.93,
                        'status' => 0,
                        'code' => 'RUB',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:38',
                    ),
                19 =>
                    array(
                        'id' => 22,
                        'name' => 'Singapore Dollar',
                        'symbol' => '$',
                        'exchange_rate' => 1.32,
                        'status' => 0,
                        'code' => 'SGD',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:50',
                    ),
                20 =>
                    array(
                        'id' => 23,
                        'name' => 'Swedish Krona',
                        'symbol' => 'kr',
                        'exchange_rate' => 8.19,
                        'status' => 0,
                        'code' => 'SEK',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:51',
                    ),
                21 =>
                    array(
                        'id' => 24,
                        'name' => 'Swiss Franc',
                        'symbol' => 'CHF',
                        'exchange_rate' => 0.94,
                        'status' => 0,
                        'code' => 'CHF',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:52',
                    ),
                22 =>
                    array(
                        'id' => 26,
                        'name' => 'Thai Baht',
                        'symbol' => '฿',
                        'exchange_rate' => 31.39,
                        'status' => 0,
                        'code' => 'THB',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:53',
                    ),
                23 =>
                    array(
                        'id' => 27,
                        'name' => 'Taka',
                        'symbol' => '৳',
                        'exchange_rate' => 84.0,
                        'status' => 0,
                        'code' => 'BDT',
                        'created_at' => '2018-10-09 14:35:08',
                        'updated_at' => '2021-04-08 13:00:54',
                    ),
                24 =>
                    array(
                        'id' => 28,
                        'name' => 'Indian Rupee',
                        'symbol' => 'Rs',
                        'exchange_rate' => 68.45,
                        'status' => 0,
                        'code' => 'Rupee',
                        'created_at' => '2019-07-07 13:33:46',
                        'updated_at' => '2021-04-08 13:00:18',
                    ),
            ));
        }


    }
}
