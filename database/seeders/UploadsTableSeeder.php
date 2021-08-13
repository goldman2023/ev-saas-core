<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UploadsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('uploads')->count() == 0) {
            \DB::table('uploads')->delete();
            /* TODO: Generate reasonable uploads for initial version of an instance*/
            \DB::table('uploads')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'file_original_name' => '121118803_128490085644586_232495690390175688_n',
                        'file_name' => 'uploads/all/77wPMeOabVB8EP82gzdTqKiT1OzdEgbvtvcjpK7t.png',
                        'user_id' => 1,
                        'file_size' => 108507,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:17:45',
                        'updated_at' => '2021-04-08 12:17:45',
                        'deleted_at' => NULL,
                    ),
            ));
        }

    }
}
