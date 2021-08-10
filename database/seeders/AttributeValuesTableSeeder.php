<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeValuesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('attribute_values')->count() == 0) {
            \DB::table('attribute_values')->delete();

            \DB::table('attribute_values')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'attribute_id' => 1,
                        'values' => 'Private',
                        'created_at' => '2021-05-19 12:09:10',
                        'updated_at' => '2021-06-01 15:26:27',
                    ),
                1 =>
                    array(
                        'id' => 4,
                        'attribute_id' => 1,
                        'values' => 'Individual entrepreneur',
                        'created_at' => '2021-06-01 15:28:41',
                        'updated_at' => '2021-06-01 15:28:41',
                    ),
                2 =>
                    array(
                        'id' => 5,
                        'attribute_id' => 1,
                        'values' => 'Public',
                        'created_at' => '2021-06-01 15:28:54',
                        'updated_at' => '2021-06-01 15:28:54',
                    ),
                3 =>
                    array(
                        'id' => 6,
                        'attribute_id' => 1,
                        'values' => 'Other',
                        'created_at' => '2021-06-01 15:29:04',
                        'updated_at' => '2021-06-01 15:29:04',
                    ),
                4 =>
                    array(
                        'id' => 7,
                        'attribute_id' => 1,
                        'values' => 'State',
                        'created_at' => '2021-06-01 15:29:20',
                        'updated_at' => '2021-06-01 15:29:20',
                    ),
                5 =>
                    array(
                        'id' => 8,
                        'attribute_id' => 9,
                        'values' => 'Manufacturer',
                        'created_at' => '2021-06-01 15:30:13',
                        'updated_at' => '2021-06-01 15:30:13',
                    ),
                6 =>
                    array(
                        'id' => 9,
                        'attribute_id' => 9,
                        'values' => 'Consumer',
                        'created_at' => '2021-06-01 15:31:17',
                        'updated_at' => '2021-06-01 15:31:17',
                    ),
                7 =>
                    array(
                        'id' => 10,
                        'attribute_id' => 9,
                        'values' => 'Services',
                        'created_at' => '2021-06-01 15:31:27',
                        'updated_at' => '2021-06-01 15:31:27',
                    ),
                8 =>
                    array(
                        'id' => 11,
                        'attribute_id' => 9,
                        'values' => 'Technical support',
                        'created_at' => '2021-06-01 15:31:34',
                        'updated_at' => '2021-06-01 15:31:34',
                    ),
                9 =>
                    array(
                        'id' => 12,
                        'attribute_id' => 9,
                        'values' => 'Technical support',
                        'created_at' => '2021-06-01 15:32:27',
                        'updated_at' => '2021-06-01 15:32:27',
                    ),
                10 =>
                    array(
                        'id' => 13,
                        'attribute_id' => 9,
                        'values' => 'Nonprofit',
                        'created_at' => '2021-06-01 15:32:52',
                        'updated_at' => '2021-06-01 15:32:52',
                    ),
                11 =>
                    array(
                        'id' => 14,
                        'attribute_id' => 9,
                        'values' => 'Services',
                        'created_at' => '2021-06-01 15:32:59',
                        'updated_at' => '2021-06-01 15:32:59',
                    ),
                12 =>
                    array(
                        'id' => 15,
                        'attribute_id' => 9,
                        'values' => 'Other',
                        'created_at' => '2021-06-01 15:33:05',
                        'updated_at' => '2021-06-01 15:33:05',
                    ),
                13 =>
                    array(
                        'id' => 16,
                        'attribute_id' => 14,
                        'values' => 'Micro (<9)',
                        'created_at' => '2021-06-01 15:35:45',
                        'updated_at' => '2021-06-01 15:35:45',
                    ),
                14 =>
                    array(
                        'id' => 17,
                        'attribute_id' => 14,
                        'values' => 'Small (10 - 49)',
                        'created_at' => '2021-06-01 15:35:51',
                        'updated_at' => '2021-06-01 15:35:51',
                    ),
                15 =>
                    array(
                        'id' => 18,
                        'attribute_id' => 14,
                        'values' => 'Medium (50 - 249)',
                        'created_at' => '2021-06-01 15:35:57',
                        'updated_at' => '2021-06-01 15:35:57',
                    ),
                16 =>
                    array(
                        'id' => 19,
                        'attribute_id' => 14,
                        'values' => 'Large (249-999)',
                        'created_at' => '2021-06-01 15:36:06',
                        'updated_at' => '2021-06-01 15:36:06',
                    ),
                17 =>
                    array(
                        'id' => 20,
                        'attribute_id' => 14,
                        'values' => 'Huge (1000+)',
                        'created_at' => '2021-06-01 15:36:15',
                        'updated_at' => '2021-06-01 15:36:15',
                    ),
                18 =>
                    array(
                        'id' => 21,
                        'attribute_id' => 15,
                        'values' => 'Micro (<9.000)',
                        'created_at' => '2021-06-01 15:37:12',
                        'updated_at' => '2021-06-01 15:37:12',
                    ),
                19 =>
                    array(
                        'id' => 22,
                        'attribute_id' => 15,
                        'values' => 'Small (10 - 49.000)',
                        'created_at' => '2021-06-01 15:37:18',
                        'updated_at' => '2021-06-01 15:37:18',
                    ),
                20 =>
                    array(
                        'id' => 23,
                        'attribute_id' => 15,
                        'values' => 'Medium (50 - 249.000)',
                        'created_at' => '2021-06-01 15:37:47',
                        'updated_at' => '2021-06-01 15:37:47',
                    ),
                21 =>
                    array(
                        'id' => 24,
                        'attribute_id' => 15,
                        'values' => 'Large (249-999.000)',
                        'created_at' => '2021-06-01 15:37:52',
                        'updated_at' => '2021-06-01 15:37:52',
                    ),
                22 =>
                    array(
                        'id' => 25,
                        'attribute_id' => 15,
                        'values' => 'Huge (1.000.000+)',
                        'created_at' => '2021-06-01 15:37:58',
                        'updated_at' => '2021-06-01 15:37:58',
                    ),
                23 =>
                    array(
                        'id' => 26,
                        'attribute_id' => 17,
                        'values' => 'A',
                        'created_at' => '2021-06-01 15:38:42',
                        'updated_at' => '2021-06-01 15:38:42',
                    ),
                24 =>
                    array(
                        'id' => 27,
                        'attribute_id' => 17,
                        'values' => 'B',
                        'created_at' => '2021-06-01 15:40:06',
                        'updated_at' => '2021-06-01 15:40:06',
                    ),
                25 =>
                    array(
                        'id' => 28,
                        'attribute_id' => 17,
                        'values' => 'C',
                        'created_at' => '2021-06-01 15:40:12',
                        'updated_at' => '2021-06-01 15:40:12',
                    ),
                26 =>
                    array(
                        'id' => 29,
                        'attribute_id' => 17,
                        'values' => 'D',
                        'created_at' => '2021-06-01 15:40:18',
                        'updated_at' => '2021-06-01 15:40:18',
                    ),
                27 =>
                    array(
                        'id' => 30,
                        'attribute_id' => 17,
                        'values' => 'E',
                        'created_at' => '2021-06-01 15:40:24',
                        'updated_at' => '2021-06-01 15:40:24',
                    ),
                28 =>
                    array(
                        'id' => 31,
                        'attribute_id' => 18,
                        'values' => 'FSC',
                        'created_at' => '2021-06-01 15:40:50',
                        'updated_at' => '2021-06-01 15:40:50',
                    ),
                29 =>
                    array(
                        'id' => 32,
                        'attribute_id' => 18,
                        'values' => 'ISO (9000 or 14001)',
                        'created_at' => '2021-06-01 15:40:57',
                        'updated_at' => '2021-06-01 15:40:57',
                    ),
                30 =>
                    array(
                        'id' => 33,
                        'attribute_id' => 18,
                        'values' => 'CE',
                        'created_at' => '2021-06-01 15:41:05',
                        'updated_at' => '2021-06-01 15:41:05',
                    ),
                31 =>
                    array(
                        'id' => 34,
                        'attribute_id' => 18,
                        'values' => 'ENplus',
                        'created_at' => '2021-06-01 15:41:11',
                        'updated_at' => '2021-06-01 15:41:11',
                    ),
                32 =>
                    array(
                        'id' => 35,
                        'attribute_id' => 18,
                        'values' => 'PEFC',
                        'created_at' => '2021-06-01 15:41:22',
                        'updated_at' => '2021-06-01 15:41:22',
                    ),
                33 =>
                    array(
                        'id' => 36,
                        'attribute_id' => 18,
                        'values' => 'ISPM 15',
                        'created_at' => '2021-06-01 15:41:28',
                        'updated_at' => '2021-06-01 15:41:28',
                    ),
                34 =>
                    array(
                        'id' => 37,
                        'attribute_id' => 18,
                        'values' => 'CARB',
                        'created_at' => '2021-06-01 15:41:36',
                        'updated_at' => '2021-06-01 15:41:36',
                    ),
                35 =>
                    array(
                        'id' => 38,
                        'attribute_id' => 18,
                        'values' => 'EN+',
                        'created_at' => '2021-06-01 15:41:42',
                        'updated_at' => '2021-06-01 15:41:42',
                    ),
                36 =>
                    array(
                        'id' => 39,
                        'attribute_id' => 18,
                        'values' => 'GOST',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                37 =>
                    array(
                        'id' => 40,
                        'attribute_id' => 23,
                        'values' => 'Online',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                38 =>
                    array(
                        'id' => 41,
                        'attribute_id' => 23,
                        'values' => 'Offline',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                39 =>
                    array(
                        'id' => 42,
                        'attribute_id' => 37,
                        'values' => 'Group',
                        'created_at' => '2021-06-01 15:41:50',
                        'updated_at' => '2021-06-01 15:41:50',
                    ),
                40 =>
                    array(
                        'id' => 43,
                        'attribute_id' => 37,
                        'values' => 'Person',
                        'created_at' => '2021-06-01 15:41:52',
                        'updated_at' => '2021-06-01 15:41:52',
                    ),
                41 =>
                    array(
                        'id' => 44,
                        'attribute_id' => 39,
                        'values' => 'Full-time',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ), 
                42 =>
                    array(
                        'id' => 45,
                        'attribute_id' => 39,
                        'values' => 'Part-time',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                43 =>
                    array(
                        'id' => 46,
                        'attribute_id' => 39,
                        'values' => 'Seasonal',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                44 =>
                    array(
                        'id' => 47,
                        'attribute_id' => 39,
                        'values' => 'Temporary',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                45 =>
                    array(
                        'id' => 48,
                        'attribute_id' => 39,
                        'values' => 'Seasonal',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                46 =>
                    array(
                        'id' => 49,
                        'attribute_id' => 39,
                        'values' => 'Internship',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                47 =>
                    array(
                        'id' => 50,
                        'attribute_id' => 40,
                        'values' => 'Remote',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                48 =>
                    array(
                        'id' => 51,
                        'attribute_id' => 40,
                        'values' => 'Office',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                49 =>
                    array(
                        'id' => 52,
                        'attribute_id' => 40,
                        'values' => 'Mixed',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                50 =>
                    array(
                        'id' => 53,
                        'attribute_id' => 41,
                        'values' => 'None',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                51 =>
                    array(
                        'id' => 54,
                        'attribute_id' => 41,
                        'values' => 'Restrict to selected Country',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                52 =>
                    array(
                        'id' => 55,
                        'attribute_id' => 46,
                        'values' => 'Educational',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                53 =>
                    array(
                        'id' => 56,
                        'attribute_id' => 46,
                        'values' => 'Occupational',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                54 =>
                    array(
                        'id' => 57,
                        'attribute_id' => 46,
                        'values' => 'Credential',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                55 =>
                    array(
                        'id' => 58,
                        'attribute_id' => 47,
                        'values' => 'MERN Stack',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                56 =>
                    array(
                        'id' => 59,
                        'attribute_id' => 47,
                        'values' => 'MEAN Stack',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ), 
                57 =>
                    array(
                        'id' => 60,
                        'attribute_id' => 47,
                        'values' => 'React.js',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),     
                58 =>
                    array(
                        'id' => 61,
                        'attribute_id' => 47,
                        'values' => 'Vue.js',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ), 
                59 =>
                    array(
                        'id' => 62,
                        'attribute_id' => 47,
                        'values' => 'Angular.js',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),     
                60 =>
                    array(
                        'id' => 63,
                        'attribute_id' => 47,
                        'values' => 'Elastic Search',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),     
                61 =>
                    array(
                        'id' => 64,
                        'attribute_id' => 47,
                        'values' => 'Node.js',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),  
                62 =>
                    array(
                        'id' => 65,
                        'attribute_id' => 47,
                        'values' => 'Laravel',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),  
                63 =>
                    array(
                        'id' => 66,
                        'attribute_id' => 47,
                        'values' => 'Wordpress',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),  
                64 =>
                    array(
                        'id' => 67,
                        'attribute_id' => 48,
                        'values' => 'Team Leader',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),  
                65 =>
                    array(
                        'id' => 68,
                        'attribute_id' => 48,
                        'values' => 'Designer',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),  
                66 =>
                    array(
                        'id' => 69,
                        'attribute_id' => 48,
                        'values' => 'Full-stack developer',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),                                                                                  
                67 =>
                    array(
                        'id' => 70,
                        'attribute_id' => 48,
                        'values' => 'Front-End developer',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ), 
                68 =>
                    array(
                        'id' => 71,
                        'attribute_id' => 48,
                        'values' => 'Back-End developer',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ), 
                69 =>
                    array(
                        'id' => 72,
                        'attribute_id' => 49,
                        'values' => 'Hour',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ), 
                70 =>
                    array(
                        'id' => 73,
                        'attribute_id' => 49,
                        'values' => 'Hour',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ), 
                71 =>
                    array(
                        'id' => 74,
                        'attribute_id' => 49,
                        'values' => 'day',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ), 
                72 =>
                    array(
                        'id' => 75,
                        'attribute_id' => 49,
                        'values' => 'week',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ), 
                73 =>
                    array(
                        'id' => 76,
                        'attribute_id' => 49,
                        'values' => 'month',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),
                74 =>
                    array(
                        'id' => 77,
                        'attribute_id' => 49,
                        'values' => 'annual',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),        
                75 =>
                    array(
                        'id' => 78,
                        'attribute_id' => 51,
                        'values' => 'USD',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),   
                76 =>
                    array(
                        'id' => 79,
                        'attribute_id' => 51,
                        'values' => 'Euro',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),   
                77 =>
                    array(
                        'id' => 80,
                        'attribute_id' => 51,
                        'values' => 'CAD',
                        'created_at' => '2021-06-01 15:41:48',
                        'updated_at' => '2021-06-01 15:41:48',
                    ),                                                                                                                                            

            ));
        }

    }
}
