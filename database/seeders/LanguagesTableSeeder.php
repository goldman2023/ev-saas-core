<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('languages')->count() == 0) {
            \DB::table('languages')->delete();

            \DB::table('languages')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'name' => 'English',
                        'code' => 'en',
                        'rtl' => 0,
                        'created_at' => '2019-01-20 14:13:20',
                        'updated_at' => '2019-01-20 14:13:20',
                    ),
                1 =>
                    array(
                        'id' => 5,
                        'name' => 'Lithuanian',
                        'code' => 'lt',
                        'rtl' => 0,
                        'created_at' => '2021-04-08 12:59:59',
                        'updated_at' => '2021-04-08 12:59:59',
                    ),
                2 =>
                    array(
                        'id' => 6,
                        'name' => 'Russian',
                        'code' => 'ru',
                        'rtl' => 0,
                        'created_at' => '2021-04-08 13:00:07',
                        'updated_at' => '2021-04-08 13:00:07',
                    ),
            ));

        }
    }
}
