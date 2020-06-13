<?php

use Illuminate\Http\Request;

/*
 * Api Service Provider has done the visioning 🥳
 * @link App\Providers\RouteServiceProvider | Line 85
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\v1\AuthController@register');
Route::post('login', 'Api\v1\AuthController@login');

Route::group(['prefix' => 'meetings'], function() {
    Route::get('/{id}', 'Api\v1\MeetingController@getMeetingById');
    Route::get('/', 'Api\v1\MeetingController@index');
    Route::post('/', 'Api\v1\MeetingController@create');
    Route::delete('/{id}', 'Api\v1\MeetingController@delete');
    Route::put('/{id}', 'Api\v1\MeetingController@update');
});

