<?php

use Illuminate\Database\Seeder;

class SourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sourceTypes = [
            [ 'name' => 'Offizielle Doku' ],
            [ 'name' => 'Internet Forum' ],
            [ 'name' => 'Video-Tutorial' ],
            [ 'name' => 'E-Leaning Plattform' ],
            [ 'name' => 'Code-Beispiele' ],
        ];

        foreach ($sourceTypes as $sourceType) {
            DB::table('source_types')->insert($sourceType);
        }
    }
}
