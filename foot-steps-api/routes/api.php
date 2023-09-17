<?php

/** @var Route $router */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group([
    'prefix' => 'v1',
    'namespace' => 'v1'
], function ($router) {
    $router->group([
        "prefix" => 'footsteps',
        'namespace' => 'FootSteps',
    ], function ($router) {
        $router->get('/me/weekly', 'GetFootStepsWeeklyController');
        $router->get('/me/monthly', 'GetFootStepsMonthlyController');
        $router->post('/me/update', 'UpdateFootStepsController');
        $router->get('/monthly/top-rank', 'GetFootStepsDailyTopRankController');
    });
});
