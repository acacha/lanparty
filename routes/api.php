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

Route::group(['prefix'=>'v1'], function() {
    Route::post('/newsletter', 'NewsletterController@store');
    Route::get('/events', 'EventsController@index');
});

Route::group(['prefix'=>'v1','middleware' => 'auth:api'], function() {
    Route::get('/users', 'UsersController@index');
    Route::post('/events/{event}/register', 'RegisterToEventController@store');
    Route::delete('/events/{event}/register', 'RegisterToEventController@destroy');

    // Assign first available number to user
    Route::post('/user/{user}/assign_number', 'AssignNumberToUserController@store');
    // Unassign/free number
    Route::delete('/number/{number}/assign', 'AssignNumberToUserController@destroy');

    // Unassign all numbers assigned to an user
    Route::post('/user/{user}/unassign_numbers', 'UnassignNumbersToUserController@store');

});

