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
                        'category_name' => 'Demo',
                        'slug' => 'Demo',
                        'created_at' => '2021-04-08 12:25:55',
                        'updated_at' => '2021-04-08 12:25:55',
                        'deleted_at' => NULL,
                    ),
            ));
        }

    }
}
