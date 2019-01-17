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

// api
// why get :/
Route::get('monitors/{id}/set', 'ApiMonitorController@update');
Route::get('heartbeat', 'ApiHeartbeatHandler@handleHeartbeat');
