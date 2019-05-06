<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'QQ2 Test Admin',
                'username' => 'qq2_test',
                'password' => bcrypt('AdMin@QQ2')
            ]
        ];

        foreach ($users as $user) {
            $user['progress'] = 1;
            DB::table('users')->insert($user);
        }
        if (file_exists(base_path('teilnehmer.csv')) && ($handle = fopen(base_path('teilnehmer.csv'), 'rb')) !== FALSE) {
            $rowCount = 0;
            while (($row = fgetcsv($handle, 1000, ';')) !== FALSE) {
                $rowCount++;
                if ($rowCount === 1) {
                    continue;
                }
                DB::table('users')->insert([
                    'name' => utf8_encode($row[4]) . ' ' . utf8_decode($row[5]),
                    'username' => $row[3],
                    'password' => bcrypt($row[1] . '_' . $row[2]),
                    'progress' => 1
                ]);
            }
            fclose($handle);
        }

    }
}
