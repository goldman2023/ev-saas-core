<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('categories')->count() == 0) {
            \DB::table('categories')->delete();

            \DB::table('categories')->insert([
                0 => [
                        'id' => 1,
                        'parent_id' => null,
                        'level' => 0,
                        'name' => 'Category 1',
                        'slug' => 'category-1',
                        'order_level' => 0,
                        'commision_rate' => 0.0,
                        // 'banner' => null,
                        // 'icon' => null,
                        'featured' => 1,
                        'top' => 1,
                        'digital' => 0,
                        'description' => '',
                        'meta_title' => null,
                        'meta_description' => null,
                        'created_at' => '2021-04-08 17:25:04',
                        'updated_at' => '2021-04-08 14:25:04',
                    ],
            ]);
        }
    }
}
