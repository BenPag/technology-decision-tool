<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            [ 'name' => 'Einrichtung' ],
            [ 'name' => 'Datenbank-Anbindung' ],
            [ 'name' => 'REST' ],
            [ 'name' => 'PayPal' ],
        ];

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert($subject);
        }
    }
}
