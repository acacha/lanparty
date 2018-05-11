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

Route::get('/premis', 'PrizesController@show');
Route::get('/colaboradors', 'PartnersController@show');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'ParticipantsHomePageController@index');
    Route::get('/manage/participants', 'ManageParticipantsController@index')
        ->name('manage.participants');

//    Route::get('/manage/events/{event}/messages', 'ParticipantMessagesController@index');
    Route::post('/manage/events/{event}/messages', 'ParticipantMessagesController@store')
        ->name('manage.event-messages.store');

    Route::get('/manage/invitations/{code}', 'InvitationsController@show')
        ->name('manage.invitations.show');

    Route::get('/group/{group}/avatar', 'GroupAvatarController@show');

    Route::post('/group/{group}/avatar','GroupAvatarController@store');

    // Sorteig
    Route::get('/manage/sorteig', 'SorteigController@index')
        ->name('manage.sorteig');

});

