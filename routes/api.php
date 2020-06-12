<?php

use Illuminate\Http\Request;

/*
 * Api Service Provider has done the visioning 🥳
 * @link App\Providers\RouteServiceProvider | Line 85
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'meetings'], function() {
    Route::post('/', 'Api\v1\MeetingController@create');
    Route::delete('/{id}', 'Api\v1\MeetingController@delete');
});

