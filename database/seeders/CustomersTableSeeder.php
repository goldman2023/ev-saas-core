<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('customers')->count() == 0) {
            \DB::table('customers')->delete();

            \DB::table('customers')->insert(array(
                0 =>
                    array(
                        'id' => 4,
                        'user_id' => 3,
                        'created_at' => '2019-08-01 13:35:09',
                        'updated_at' => '2019-08-01 13:35:09',
                    ),
            ));
        }

    }
}
