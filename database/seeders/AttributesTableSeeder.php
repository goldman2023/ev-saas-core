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
                        'name' => 'Company Size',
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
                1 =>
                    array(
                        'id' => 9,
                        'name' => 'Activity type',
                        'type' => 'checkbox',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                2 =>
                    array(
                        'id' => 10,
                        'name' => 'Creation date',
                        'type' => 'number',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                3 =>
                    array(
                        'id' => 11,
                        'name' => 'Country',
                        'type' => 'country',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'addressCountry',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                4 =>
                    array(
                        'id' => 12,
                        'name' => 'City',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'addressLocality',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                5 =>
                    array(
                        'id' => 14,
                        'name' => 'Number Of Employees',
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
                6 =>
                    array(
                        'id' => 15,
                        'name' => 'Capacity (Manufacturing, consumption, purchasing, trade ):',
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
                7 =>
                    array(
                        'id' => 16,
                        'name' => 'Turnover',
                        'type' => 'number',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                8 =>
                    array(
                        'id' => 17,
                        'name' => 'Credit Rating',
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
                9 =>
                    array(
                        'id' => 18,
                        'name' => 'Certification',
                        'type' => 'checkbox',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                11 =>
                    array(
                        'id' => 20,
                        'name' => 'Country',
                        'type' => 'country',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                12 =>
                    array(
                        'id' => 21,
                        'name' => 'Date',
                        'type' => 'date',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                13 =>
                    array(
                        'id' => 22,
                        'name' => 'Price',
                        'type' => 'number',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'price',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                14 =>
                    array(
                        'id' => 23,
                        'name' => 'Event type',
                        'type' => 'dropdown',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'eventAttendanceMode',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                15 =>
                    array(
                        'id' => 24,
                        'name' => 'Zipcode',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'postalCode',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                16 =>
                    array(
                        'id' => 25,
                        'name' => 'Website',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'url',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                17 =>
                    array(
                        'id' => 26,
                        'name' => 'Contact email',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'email',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                18 =>
                    array(
                        'id' => 27,
                        'name' => 'Contact phone',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'telephone',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                19 =>
                    array(
                        'id' => 28,
                        'name' => 'VAT Code',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Seller',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'vatID',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                20 =>
                    array(
                        'id' => 29,
                        'name' => 'Start Date',
                        'type' => 'date',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'startDate',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                21 =>
                    array(
                        'id' => 30,
                        'name' => 'End Date',
                        'type' => 'date',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'endDate',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                22 =>
                    array(
                        'id' => 31,
                        'name' => 'JoinURL',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'url',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                23 =>
                    array(
                        'id' => 32,
                        'name' => 'Location name',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'name',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                24 =>
                    array(
                        'id' => 33,
                        'name' => 'Location address',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'streetAddress',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                25 =>
                    array(
                        'id' => 34,
                        'name' => 'Location city',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'addressLocality',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                26 =>
                    array(
                        'id' => 35,
                        'name' => 'Location country',
                        'type' => 'country',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'addressCountry',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                27 =>
                    array(
                        'id' => 36,
                        'name' => 'Location zip code',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'postalCode',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                28 =>
                    array(
                        'id' => 37,
                        'name' => 'Performer type',
                        'type' => 'dropdown',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'type',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                29 =>
                    array(
                        'id' => 38,
                        'name' => 'Performer name',
                        'type' => 'plain_text',
                        'content_type' => 'App\\Models\\Event',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => true,
                        'schema_key' => 'name',
                        'schema_value' => null,
                        'is_default' => true
                    ),
                30 =>
                    array(
                        'id' => 39,
                        'name' => 'Employment Type',
                        'type' => 'dropdown',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                31 =>
                    array(
                        'id' => 40,
                        'name' => 'Type',
                        'type' => 'dropdown',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                32 =>
                    array(
                        'id' => 41,
                        'name' => 'Applicant Location Requirement',
                        'type' => 'dropdown',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                33 =>
                    array(
                        'id' => 42,
                        'name' => 'Country',
                        'type' => 'country',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                34 =>
                    array(
                        'id' => 43,
                        'name' => 'City',
                        'type' => 'plain_text',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                35 =>
                    array(
                        'id' => 44,
                        'name' => 'Street Address',
                        'type' => 'plain_text',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                36 =>
                    array(
                        'id' => 45,
                        'name' => 'ZIP Code',
                        'type' => 'plain_text',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                37 =>
                    array(
                        'id' => 46,
                        'name' => 'Qualifications',
                        'type' => 'text_list',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                38 =>
                    array(
                        'id' => 47,
                        'name' => 'Skills',
                        'type' => 'text_list',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                39 =>
                    array(
                        'id' => 48,
                        'name' => 'Responsibilities',
                        'type' => 'text_list',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                40 =>
                    array(
                        'id' => 49,
                        'name' => 'Base Salary Type',
                        'type' => 'dropdown',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                41 =>
                    array(
                        'id' => 50,
                        'name' => 'Base Salary Value',
                        'type' => 'number',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                42 =>
                    array(
                        'id' => 51,
                        'name' => 'Base Salary Currency',
                        'type' => 'dropdown',
                        'content_type' => 'App\Models\Job',
                        'filterable' => 1,
                        'is_admin' => false,
                        'custom_properties' => '',
                        'is_schema' => false,
                        'schema_key' => null,
                        'schema_value' => null,
                        'is_default' => true
                    ),
                43 =>
                    array(
                        'id' => 52,
                        'name' => 'Valid Through',
                        'type' => 'date',
                        'content_type' => 'App\Models\Job',
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
