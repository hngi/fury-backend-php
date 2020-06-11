<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//versioning the routes

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\v1'], function () {

    //this is just a test route not valid
    Route::get('welcome',      'Api\v1\controller\MeetingController@index');

  });
