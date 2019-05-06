<?php

namespace App\Repositories;

use App\Models\Questionnaire\Answer;
use App\Models\User;
use App\Repositories\Interfaces\AnswerRepositoryInterface;

class AnswerRepository extends BaseRepository implements AnswerRepositoryInterface
{
    public function __construct(Answer $answer)
    {
        parent::__construct($answer);
    }

    public function createMany(array $attributes)
    {
        $creations = [];
        /** @var User $user */
        $user = auth()->user();
        foreach ($attributes as $attribute) {
            $answer = new Answer($attribute);
            $answer->user()->associate($user);
            $answer->questionnaire()->associate($attribute['questionnaireId']);
            $answer->question()->associate($attribute['questionId']);
            $answer->save();
            $creations[] = $answer;
        }
        return $creations;
    }
}
