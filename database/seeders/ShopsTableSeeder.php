<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('shops')->count() == 0) {
            \DB::table('shops')->delete();

            /* TODO: Create reasonable shop seeder - Admin user, main tenant, should have default shop on seeder */
            \DB::table('shops')->insert([
                [
                    'id' => 1,
                    'name' => 'Demo shop 1',
                    'slug' => 'demo-shop-1',
                    'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget dolor quis ex sodales dictum. Suspendisse sed massa lorem',
                    'content' => null,
                ]
            ]); 

            \DB::table('user_relationships')->insert([
                [
                    'id' => 1,
                    'user_id' => 1, // admin
                    'subject_id' => 1,
                    'subject_type' => 'App\\Models\\Shop',
                ],
                [
                    'id' => 2,
                    'user_id' => 2, // seller
                    'subject_id' => 1,
                    'subject_type' => 'App\\Models\\Shop',
                ]
            ]);

        }
    }
}
