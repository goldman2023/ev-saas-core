<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('attributes')->count() == 0) {
            \DB::table('attributes')->delete();

            \DB::table('attributes')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'name' => 'Demo Attribute',
                        'type' => 'dropdown',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
            ));
        }
    }
}
