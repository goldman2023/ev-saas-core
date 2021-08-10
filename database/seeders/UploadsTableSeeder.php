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
                1 =>
                    array(
                        'id' => 2,
                        'file_original_name' => '121118803_128490085644586_232495690390175688_n',
                        'file_name' => 'uploads/all/zOySTzth5otiqZhF0CIofECzPplwvEF3V4E5hHL8.png',
                        'user_id' => 2,
                        'file_size' => 108507,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:18:51',
                        'updated_at' => '2021-04-08 12:18:51',
                        'deleted_at' => NULL,
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'file_original_name' => 'Screenshot 2021-03-24 at 12.01.39',
                        'file_name' => 'uploads/all/3Zz854BTARLOWeVPr6Sf4Aoj6TVvpH26WnVNQ65H.png',
                        'user_id' => 2,
                        'file_size' => 36600,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:20:42',
                        'updated_at' => '2021-04-08 12:20:42',
                        'deleted_at' => NULL,
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'file_original_name' => 'Screenshot 2021-03-24 at 11.43.11',
                        'file_name' => 'uploads/all/G7k6JRWBAFKtpxmWVLApC7WuS2APG87Fm5aF2zRw.png',
                        'user_id' => 2,
                        'file_size' => 36975,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:20:42',
                        'updated_at' => '2021-04-08 12:20:42',
                        'deleted_at' => NULL,
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'file_original_name' => 'Screenshot 2021-03-24 at 11.43.53',
                        'file_name' => 'uploads/all/EIgna3Fmqu3QotSgGPFfrCPlT1KPo1JVIs9L4r8n.png',
                        'user_id' => 1,
                        'file_size' => 78686,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:20:43',
                        'updated_at' => '2021-04-08 12:20:43',
                        'deleted_at' => NULL,
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'file_original_name' => 'Screenshot 2021-03-23 at 11.54',
                        'file_name' => 'uploads/all/E3If2ohLoe3Sm863G0UtrP4hTff8S5qCAwRk0Yte.png',
                        'user_id' => 1,
                        'file_size' => 619557,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:20:43',
                        'updated_at' => '2021-04-08 12:20:43',
                        'deleted_at' => NULL,
                    ),
                6 =>
                    array(
                        'id' => 7,
                        'file_original_name' => 'Screenshot 2021-03-23 at 11.54.17',
                        'file_name' => 'uploads/all/mOmQwV0mjnYxNB9bTGZt9kETrF6AGt6QBaUUX0AZ.png',
                        'user_id' => 1,
                        'file_size' => 624374,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:20:44',
                        'updated_at' => '2021-04-08 12:20:44',
                        'deleted_at' => NULL,
                    ),
                7 =>
                    array(
                        'id' => 8,
                        'file_original_name' => 'Screenshot 2021-04-08 at 11.51.59',
                        'file_name' => 'uploads/all/Yyu4pFrvBJpbbPoHGBDZ3ZK4rCLlRn7De63KgwBK.png',
                        'user_id' => 3,
                        'file_size' => 528846,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:38:15',
                        'updated_at' => '2021-04-08 12:38:15',
                        'deleted_at' => NULL,
                    ),
                8 =>
                    array(
                        'id' => 9,
                        'file_original_name' => 'commodity-logo (1)',
                        'file_name' => 'uploads/all/DzmVmYo0LsqaznluUkg1qjsKglimutHhfTye5zWY.png',
                        'user_id' => 3,
                        'file_size' => 85843,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:57:50',
                        'updated_at' => '2021-04-08 12:57:50',
                        'deleted_at' => NULL,
                    ),
                9 =>
                    array(
                        'id' => 10,
                        'file_original_name' => 'hero-bg',
                        'file_name' => 'uploads/all/YlkBbzjJRqmJHTtlcz7nEgH67AvlPzv4FPAlluhV.jpg',
                        'user_id' => 3,
                        'file_size' => 365010,
                        'extension' => 'jpeg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 12:58:33',
                        'updated_at' => '2021-04-08 12:58:33',
                        'deleted_at' => NULL,
                    ),
                10 =>
                    array(
                        'id' => 11,
                        'file_original_name' => 'commodity-logo (1)',
                        'file_name' => 'uploads/all/rHQ3jEN4LhkzpHQ5kKdvBPLEbXTiqFobLUkJKVTH.png',
                        'user_id' => 1,
                        'file_size' => 85843,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 13:26:16',
                        'updated_at' => '2021-04-08 13:26:16',
                        'deleted_at' => NULL,
                    ),
                11 =>
                    array(
                        'id' => 12,
                        'file_original_name' => 'sector-img-23',
                        'file_name' => 'uploads/all/4pOw92Clf9VKhVyVoqVrXiVHdQdrgWEPtMEFMSFw.jpg',
                        'user_id' => 1,
                        'file_size' => 14057,
                        'extension' => 'jpeg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 13:48:11',
                        'updated_at' => '2021-04-08 13:48:11',
                        'deleted_at' => NULL,
                    ),
                12 =>
                    array(
                        'id' => 13,
                        'file_original_name' => 'sector-img-15',
                        'file_name' => 'uploads/all/F75Il3WM6qUhp9ahtp8kOgnC9fFwTeAuY1dVJDir.jpg',
                        'user_id' => 1,
                        'file_size' => 15293,
                        'extension' => 'jpeg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 13:48:11',
                        'updated_at' => '2021-04-08 13:48:11',
                        'deleted_at' => NULL,
                    ),
                13 =>
                    array(
                        'id' => 14,
                        'file_original_name' => 'sector-img-13a',
                        'file_name' => 'uploads/all/tPrsAhgDaNtJG6LFdJ1Cy5HdrqG7izlXBl8RuxMJ.jpg',
                        'user_id' => 1,
                        'file_size' => 11426,
                        'extension' => 'jpeg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 13:48:12',
                        'updated_at' => '2021-04-08 13:48:12',
                        'deleted_at' => NULL,
                    ),
                14 =>
                    array(
                        'id' => 15,
                        'file_original_name' => 'sector-img-09',
                        'file_name' => 'uploads/all/2vXKqM9VUymdrrczqgEsePcmN4wGVqlR6AmnYYov.jpg',
                        'user_id' => 1,
                        'file_size' => 22048,
                        'extension' => 'jpeg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 13:48:12',
                        'updated_at' => '2021-04-08 13:48:12',
                        'deleted_at' => NULL,
                    ),
                15 =>
                    array(
                        'id' => 16,
                        'file_original_name' => 'sector-img-06',
                        'file_name' => 'uploads/all/5OGE5Ub0BLaFVgKsiwIBVvBTJLqKMjvWI4LOBuO6.jpg',
                        'user_id' => 1,
                        'file_size' => 12263,
                        'extension' => 'jpeg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 13:48:12',
                        'updated_at' => '2021-04-08 13:48:12',
                        'deleted_at' => NULL,
                    ),
                16 =>
                    array(
                        'id' => 17,
                        'file_original_name' => 'Screenshot 2021-04-08 at 16.55.42',
                        'file_name' => 'uploads/all/d9y1uZf7YrnKdBahL5CSyZJh0MwE9AD1yCS0GluK.png',
                        'user_id' => 3,
                        'file_size' => 34022,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 13:55:53',
                        'updated_at' => '2021-04-08 13:55:53',
                        'deleted_at' => NULL,
                    ),
                17 =>
                    array(
                        'id' => 18,
                        'file_original_name' => 'Screenshot 2021-04-08 at 17.02.17',
                        'file_name' => 'uploads/all/qYGpJY60XeM1StaQ60eWixzopzXR8ny78Xak82TM.png',
                        'user_id' => 1,
                        'file_size' => 34893,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 14:02:53',
                        'updated_at' => '2021-04-08 14:02:53',
                        'deleted_at' => NULL,
                    ),
                18 =>
                    array(
                        'id' => 19,
                        'file_original_name' => 'forest',
                        'file_name' => 'uploads/all/iJ5PynzdiEz83QxldYISx54L7SZRNbIAajREvDZF.svg',
                        'user_id' => 2,
                        'file_size' => 1479,
                        'extension' => 'svg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 14:23:31',
                        'updated_at' => '2021-04-08 14:23:31',
                        'deleted_at' => NULL,
                    ),
                19 =>
                    array(
                        'id' => 20,
                        'file_original_name' => 'truck',
                        'file_name' => 'uploads/all/5V1LQy8it69jSqdQqfSvUzVp5gv4WQ80wGGHXkaY.svg',
                        'user_id' => 1,
                        'file_size' => 1514,
                        'extension' => 'svg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 14:24:51',
                        'updated_at' => '2021-04-08 14:24:51',
                        'deleted_at' => NULL,
                    ),
                20 =>
                    array(
                        'id' => 21,
                        'file_original_name' => 'bank',
                        'file_name' => 'uploads/all/aXdyeL1qq1jtYJGnK1yAWxRSCGN670Nwf3z2WMMM.svg',
                        'user_id' => 1,
                        'file_size' => 1643,
                        'extension' => 'svg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 14:26:57',
                        'updated_at' => '2021-04-08 14:26:57',
                        'deleted_at' => NULL,
                    ),
                21 =>
                    array(
                        'id' => 22,
                        'file_original_name' => 'cardiogram',
                        'file_name' => 'uploads/all/9uUufvfJP6X2k0y4kjBMkeLodtcNsLM0zPBzuVDx.svg',
                        'user_id' => 1,
                        'file_size' => 1557,
                        'extension' => 'svg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 14:29:59',
                        'updated_at' => '2021-04-08 14:29:59',
                        'deleted_at' => NULL,
                    ),
                22 =>
                    array(
                        'id' => 23,
                        'file_original_name' => 'file',
                        'file_name' => 'uploads/all/ajAidDZCIaJOvbIYS9p2EwjzqxPYM453ILOzoY5k.svg',
                        'user_id' => 1,
                        'file_size' => 1183,
                        'extension' => 'svg',
                        'type' => 'image',
                        'created_at' => '2021-04-08 14:31:15',
                        'updated_at' => '2021-04-08 14:31:15',
                        'deleted_at' => NULL,
                    ),
                23 =>
                    array(
                        'id' => 24,
                        'file_original_name' => 'Screenshot 2021-04-08 at 17.35.39',
                        'file_name' => 'uploads/all/AtyODHTSPaiMsGv8XZs9FwZBTSzcWgPpG3AOek7a.png',
                        'user_id' => 1,
                        'file_size' => 333834,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 14:36:30',
                        'updated_at' => '2021-04-08 14:36:30',
                        'deleted_at' => NULL,
                    ),
                24 =>
                    array(
                        'id' => 25,
                        'file_original_name' => 'Screenshot 2021-04-08 at 17.02.17',
                        'file_name' => 'uploads/all/K1xSOTELJjlPcabpuSh6u4TXwkLMEePzUAfbz9Xm.png',
                        'user_id' => 1,
                        'file_size' => 34893,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-08 17:09:19',
                        'updated_at' => '2021-04-08 17:09:19',
                        'deleted_at' => NULL,
                    ),
                25 =>
                    array(
                        'id' => 26,
                        'file_original_name' => 'Screenshot 2021-04-10 at 18.44.16',
                        'file_name' => 'uploads/all/nPxcml2Nishcyjp0sZylqPyGJL0iUVvJ7eBL03XA.png',
                        'user_id' => 1,
                        'file_size' => 259069,
                        'extension' => 'png',
                        'type' => 'image',
                        'created_at' => '2021-04-12 15:04:47',
                        'updated_at' => '2021-04-12 15:04:47',
                        'deleted_at' => NULL,
                    ),
            ));
        }

    }
}
