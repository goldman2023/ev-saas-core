<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('roles')->count() == 0) {
            \DB::table('roles')->delete();

            \DB::table('roles')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'name' => 'Manager',
                        'permissions' => '["1","2","4"]',
                        'created_at' => '2018-10-10 07:39:47',
                        'updated_at' => '2018-10-10 07:51:37',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'name' => 'Accountant',
                        'permissions' => '["2","3"]',
                        'created_at' => '2018-10-10 07:52:09',
                        'updated_at' => '2018-10-10 07:52:09',
                    ),
            ));
        }

    }
}
