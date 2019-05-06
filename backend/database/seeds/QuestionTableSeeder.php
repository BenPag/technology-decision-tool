<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = self::getQuestions();

        foreach ($questions as $question) {
            $question['created_at'] = Carbon::now();
            DB::table('questions')->insert($question);
        }
    }

    public static function getQuestions(): array
    {
        return [
            [
                'question' => 'Wie lange haben Sie gebraucht um die Aufgabe zu bearbeiten? (in Minuten)',
                'type' => 'number',
                'options' => json_encode([]),
                'required' => 1
            ], [
                'question' => 'Wie viele Zeilen Code haben sie bisher geschrieben? (Nur Quellcode!)',
                'type' => 'number',
                'options' => json_encode([]),
                'required' => 1
            ], [
                'question' => 'Was hat sie bei der Berarbeitung der Aufgabe am meisten unterstützt?',
                'type' => 'select',
                'options' => json_encode([
                    'Pers. Gespräch',
                    'Online Tutorial',
                    'Internetforen',
                    'Youtube Videos',
                    'Online Dokumentation'
                ]),
                'required' => 1
            ], [
                'question' => 'Haben Sie bei einem Problem das Fachgepäch mit einer anderen Person gesucht?',
                'type' => 'radio',
                'options' => json_encode([
                    ['description' => 'Ja', 'value' => '1'],
                    ['description' => 'Nein', 'value' => '0']
                ]),
                'required' => 1
            ], [
                'question' => 'Konnten Sie Ihrer Meinung nach schnell Antworten auf Ihren Fragen finden?',
                'type' => 'radio',
                'options' => json_encode([
                    ['description' => 'Ja', 'value' => '1'],
                    ['description' => 'Nein', 'value' => '0']
                ]),
                'required' => 1
            ], [
                'question' => 'Was hat sehr gut funktioniert?',
                'type' => 'textarea',
                'options' => json_encode([]),
                'required' => 1
            ], [
                'question' => 'Womit hatten Sie am meisten Probleme?',
                'type' => 'textarea',
                'options' => json_encode([]),
                'required' => 1
            ],
            [
                'question' => 'Sonstige Anmerkung',
                'type' => 'textarea',
                'options' => json_encode([]),
                'required' => 1
            ]
        ];
    }
}
