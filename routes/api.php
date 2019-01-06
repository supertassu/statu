<?php

use App\Incident;

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

Route::get('incidents', 'IncidentApiController@index');

Route::get('incidents/{id}','IncidentApiController@show');
