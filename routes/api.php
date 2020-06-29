<?php

use Illuminate\Http\Request;
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

Route::middleware(\App\Http\Middleware\RequestLogger::class)->group(function() {
    Route::apiResource(
        'properties',
        'API\\PropertiesController',
        [ 'only' => ['store'] ]
    );

    Route::apiResource(
        'properties/{property}/analytics',
        'API\\AnalyticsController',
        [ 'only' => ['store', 'update', 'index'] ]
    );

    Route::apiResource(
        'summary',
        'API\\SummaryController',
        [ 'only' => ['index'] ]
    );
});
