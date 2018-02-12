<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::loginUsingId(1);

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'ParticipantsHomePageController@index');
    Route::get('/manage/participants', 'ManageParticipantsController@index');

    Route::post('/events/{event}/register', 'RegisterToEventController@store');
});

// Administrators
