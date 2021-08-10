<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PoliciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('policies')->count() == 0) {
            \DB::table('policies')->delete();

            \DB::table('policies')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'name' => 'support_policy',
                        'content' => NULL,
                        'created_at' => '2019-10-29 14:54:45',
                        'updated_at' => '2019-01-22 07:13:15',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'name' => 'return_policy',
                        'content' => NULL,
                        'created_at' => '2019-10-29 14:54:47',
                        'updated_at' => '2019-01-24 07:40:11',
                    ),
                2 =>
                    array(
                        'id' => 4,
                        'name' => 'seller_policy',
                        'content' => NULL,
                        'created_at' => '2019-10-29 14:54:49',
                        'updated_at' => '2019-02-04 19:50:15',
                    ),
                3 =>
                    array(
                        'id' => 5,
                        'name' => 'terms',
                        'content' => NULL,
                        'created_at' => '2019-10-29 14:54:51',
                        'updated_at' => '2019-10-28 20:00:00',
                    ),
                4 =>
                    array(
                        'id' => 6,
                        'name' => 'privacy_policy',
                        'content' => NULL,
                        'created_at' => '2019-10-29 14:54:54',
                        'updated_at' => '2019-10-28 20:00:00',
                    ),
            ));
        }

    }
}
