<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(SourceTypeSeeder::class);
        $this->call(QuestionTableSeeder::class);
    }
}
