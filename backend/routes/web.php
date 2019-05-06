<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Artisan;

$router->get('/', function () use ($router) {
    if (file_exists(app_path() . '/initialized.file')) {
        return $router->app->version();
    }

    Artisan::call('migrate');
    Artisan::call('db:seed');
    touch(app_path() . '/initialized.file');
    return 'successfully initialized!';
});

$router->post('auth/login', 'AuthController@login');
$router->get('auth/logout', 'AuthController@logout');
$router->get('auth/refresh', 'AuthController@refresh');

$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->get('me', 'AuthController@me');
        $router->put('me', 'AuthController@finishStep');
    });
    $router->group(['prefix' => 'questions'], function () use ($router) {
        $router->get('/', 'Questionnaire\QuestionsApiController@index');
        $router->post('/', 'Questionnaire\QuestionsApiController@store');
        $router->put('/{id}', 'Questionnaire\QuestionsApiController@update');
        $router->delete('/{id}', 'Questionnaire\QuestionsApiController@destroy');
    });
    $router->group(['prefix' => 'questionnaires'], function () use ($router) {
        $router->get('/', 'EvaluationFromApiController@index');
        $router->post('/', 'EvaluationFromApiController@store');
        $router->get('/{id}', 'EvaluationFromApiController@show');
        $router->put('/{id}', 'EvaluationFromApiController@update');
        $router->delete('/{id}', 'EvaluationFromApiController@destroy');
        $router->get('/{id}/questions', 'EvaluationFromApiController@getQuestionsByQuestionnaireId');
        $router->post('/{id}/questions', 'EvaluationFromApiController@storeQuestionnaireQuestions');
        /*
        $router->get('questionnaires', 'Questionnaire\QuestionnaireApiController@index');
        $router->get('questionnaires/{id}', 'Questionnaire\QuestionnaireApiController@show');
        $router->get(
            'questionnaires/{id}/questions',
            'Questionnaire\QuestionnaireApiController@getQuestionsByQuestionnaireId'
        );
        */
    });
    $router->group(['prefix' => 'tasks'], function () use ($router) {
        $router->get('/', 'TasksApiController@index');
        $router->get('/{id}', 'TasksApiController@show');
        $router->post('/', 'TasksApiController@store');
        $router->put('/{id}', 'TasksApiController@update');
        $router->delete('/{id}', 'TasksApiController@destroy');
    });
    $router->group(['prefix' => 'steps'], function () use ($router) {
        $router->get('/', 'WorkStepApiController@index');
        $router->get('/{id}', 'WorkStepApiController@show');
        $router->post('/', 'WorkStepApiController@store');
        $router->put('/{id}', 'WorkStepApiController@update');
        $router->put('/', 'WorkStepApiController@updateAll');
        $router->delete('/{id}', 'WorkStepApiController@destroy');
    });

    $router->post('answers', 'Questionnaire\AnswerApiController@storeMany');
    $router->get('subjects', 'SourceTracking\SubjectsApiController@index');
    $router->get('sourceTypes', 'SourceTracking\SourceTypesApiController@index');
    $router->get('sources', 'SourceTracking\SourcesApiController@index');
    $router->post('sources', 'SourceTracking\SourcesApiController@store');
    $router->get('summary', 'SummaryController@index');
});
