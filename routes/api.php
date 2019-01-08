<?php

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

Route::get('overview', 'ApiOverviewController@index');

Route::get('monitors', 'ApiMonitorController@index');
Route::get('monitors/{id}','ApiMonitorController@show');

Route::get('incidents', 'ApiIncidentController@index');
Route::get('incidents/{id}','ApiIncidentController@show');
