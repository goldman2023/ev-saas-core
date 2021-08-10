<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('blog_categories')->count() == 0) {
            \DB::table('blog_categories')->delete();

            \DB::table('blog_categories')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'category_name' => 'Forestry',
                        'slug' => 'Forestry',
                        'created_at' => '2021-04-08 12:25:55',
                        'updated_at' => '2021-04-08 12:25:55',
                        'deleted_at' => NULL,
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'category_name' => 'Wood Trade',
                        'slug' => 'Wood-Trade',
                        'created_at' => '2021-04-08 12:26:05',
                        'updated_at' => '2021-04-08 12:26:05',
                        'deleted_at' => NULL,
                    ),
            ));
        }

    }
}
