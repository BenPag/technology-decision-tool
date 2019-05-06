<?php

namespace App\Providers;

use App\Repositories\AnswerRepository;
use App\Repositories\EvaluationFromRepository;
use App\Repositories\Interfaces\AnswerRepositoryInterface;
use App\Repositories\Interfaces\EvaluationFromRepositoryInterface;
use App\Repositories\Interfaces\QuestionnaireRepositoryInterface;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use App\Repositories\Interfaces\SourcesRepositoryInterface;
use App\Repositories\Interfaces\SourceTypeRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WorkStepRepositoryInterface;
use App\Repositories\QuestionnaireRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\SourcesRepository;
use App\Repositories\SourceTypeRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkStepRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bind the interface to an implementation repository class
     */
    public function register() : void
    {
        $this->app->bind(AnswerRepositoryInterface::class, AnswerRepository::class);
        $this->app->bind(EvaluationFromRepositoryInterface::class, EvaluationFromRepository::class);
        $this->app->bind(QuestionnaireRepositoryInterface::class, QuestionnaireRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(SourcesRepositoryInterface::class, SourcesRepository::class);
        $this->app->bind(SourceTypeRepositoryInterface::class, SourceTypeRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(WorkStepRepositoryInterface::class, WorkStepRepository::class);
    }
}