<?php

use App\Http\Controllers\Api\AllEventsController;
use App\Http\Controllers\Api\ArchivedEventsController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\EventsControllerInLine;
use App\Http\Controllers\Api\ManagersController;
use App\Http\Controllers\Api\PartnersController;
use App\Http\Controllers\Api\SendInvitationToManager;
use App\Http\Controllers\Api\TicketsController;
use App\Http\Controllers\Api\UsersManagersController;
use App\Http\Controllers\AssignNumberToUserController;
use App\Http\Controllers\AvailablePrizesController;
use App\Http\Controllers\LoggedUserController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NumbersController;
use App\Http\Controllers\RegisterGroupToEventController;
use App\Http\Controllers\RegisterToEventController;
use App\Http\Controllers\RegisterUserToAllEventsController;
use App\Http\Controllers\RegisterUserToEventController;
use App\Http\Controllers\SessionWinnersController;
use App\Http\Controllers\UnassignNumbersToUserController;
use App\Http\Controllers\UserPaymentsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Api\PrizesController;

use App\Http\Controllers\Web\ImageEventController;
use App\Http\Controllers\Web\PartnerAvatarController;
use App\Http\Controllers\WinnerController;
use App\Http\Controllers\WinnersController;
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

Route::group(['prefix' => 'v1'], function () {
  Route::post('/newsletter', '\\' . NewsletterController::class . '@store');
  Route::get('/events', '\\' . EventsController::class . '@index');

  //Prizes
  Route::get('/prizes', '\\' . PrizesController::class . '@index');

  Route::get('/available_prizes', '\\' . AvailablePrizesController::class . '@index');

  //Partners
  Route::get('/partners', '\\' . PartnersController::class . '@index');

  Route::get('/available_prizes', '\\' . AvailablePrizesController::class . '@index');

});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
  //Users
  Route::get('/users', '\\' . UsersController::class . '@index');

  Route::put('/users/{user}', '\\' . UsersController::class . '@update');

  Route::put('/user', '\\' . LoggedUserController::class . '@update');

  //Members
  Route::delete('/group/{group}/member', '\\' . MembersController::class . '@destroy');

  //Numbers
  Route::get('/numbers', '\\' . NumbersController::class . '@index');

  Route::group(['middleware' => 'checkSession'], function () {
    Route::post('/numbers', '\\' . NumbersController::class . '@store');
    Route::post('/numbers/remove', '\\' . NumbersController::class . '@destroy');
  });

  //Register Auth user to events
  Route::group(['middleware' => 'checkNotPayed'], function () {
    Route::post('/events/{event}/register', '\\' . RegisterToEventController::class . '@store');
    Route::delete('/events/{event}/register', '\\' . RegisterToEventController::class . '@destroy');
  });

  //Register users to events
  Route::post('/events/{event}/register/user/{user}', '\\' . RegisterUserToEventController::class . '@store');
  Route::delete('/events/{event}/register/user/{user}', '\\' . RegisterUserToEventController::class . '@destroy');
  Route::delete('/events/register/user/{user}', '\\' . RegisterUserToAllEventsController::class . '@destroy');

  //Register group to event
  Route::group(['middleware' => 'checkNotPayed'], function () {
    Route::post('/events/{event}/register_group', '\\' . RegisterGroupToEventController::class . '@store');
    Route::delete('/events/{event}/register_group/{group}', '\\' . RegisterGroupToEventController::class . '@destroy');
  });

  // ASSIGN NUMBERS
  // Assign first available number to user
  Route::post('/user/{user}/assign_number', '\\' . AssignNumberToUserController::class . '@store');
  // Unassign/free number
  Route::delete('/number/{number}/assign', '\\' . AssignNumberToUserController::class . '@destroy');
  // Unassign all numbers assigned to an user
  Route::post('/user/{user}/unassign_numbers', '\\' . UnassignNumbersToUserController::class . '@store');

  Route::group(['middleware' => 'checkSession'], function () {
    //Payments
    Route::post('/user/{user}/pay', '\\' . UserPaymentsController::class . '@store');
    Route::post('/user/{user}/unpay', '\\' . UserPaymentsController::class . '@destroy');
  });

  //Winners
  Route::delete('/winners', '\\' . WinnersController::class . '@destroy');

  //Winner
  Route::group(['middleware' => 'checkSession'], function () {
    Route::delete('/{session}/winners', '\\' . SessionWinnersController::class . '@destroy');
  });

  Route::get('/winner', '\\' . WinnerController::class . '@index');
  Route::delete('/winner/{prize}', '\\' . WinnerController::class . '@destroy');
  Route::post('/winner/{prize}', '\\' . WinnerController::class . '@store');

  Route::post('/manage/managers/send_invitation', '\\' . SendInvitationToManager::class . '@send');

  //Partner 07/05/19 M
  Route::get('/partners', '\\' . PartnersController::class . '@index');
  Route::get('/partners/{partner}', '\\' . PartnersController::class . '@show');
  Route::delete('/partners/{partner}', '\\' . PartnersController::class . '@destroy');
  Route::post('/partners', '\\' . PartnersController::class . '@store');
  Route::put('/partners/{partner}', '\\' . PartnersController::class . '@update');
  Route::put('/partners/inline/{partner}', '\\' . PartnersController::class . '@editName');
  Route::post('/partner/avatar', '\\'. PartnerAvatarController::class . '@store');

  Route::post('/prizes', '\\' . PrizesController::class . '@store');
  Route::get('/prizes/{prize}', '\\' . PrizesController::class . '@show');
  Route::put('/prizes/{prize}', '\\' . PrizesController::class . '@update');
  Route::delete('/prizes/{prize}', '\\' . PrizesController::class . '@destroy');

  Route::post('/events', '\\' . EventsController::class . '@store');
  Route::get('/events/{event}', '\\' . EventsController::class . '@show');
  Route::delete('/events/{event}', '\\' . EventsController::class . '@destroy');
  Route::put('/events/{event}', '\\' . EventsController::class . '@update');
  Route::put('/events/{event}', '\\' . EventsController::class . '@update');
  Route::put('/events/inline/{event}', '\\' . EventsControllerInLine::class . '@update');
  Route::post('/event/image', '\\'. ImageEventController::class . '@store');

  //UserManager
  Route::delete('/user/{user}/manager', '\\' . UsersManagersController::class . '@destroy');

  //Managers
  Route::get('/managers', '\\' . ManagersController::class . '@index');

  // ArchiveEvents
  // POST -> Crear un nou event archivat -> Passar event existent de normal a archivat (deleted_at/soft_deleted)
  Route::post('/archived_events/{event}', '\\' . ArchivedEventsController::class . '@store');
  Route::delete('/archived_events/{allevent}', '\\' . ArchivedEventsController::class . '@destroy');

  // AllEvents
  Route::get('/all_events', '\\' . AllEventsController::class . '@index');

  //Tickets
  Route::get('/tickets', '\\' . TicketsController::class . '@index');

  Route::group(['middleware' => 'checkSession'], function () {
    Route::post('/tickets', '\\' . TicketsController::class . '@store');
    Route::post('/tickets/remove', '\\' . TicketsController::class . '@destroy');
  });
});

Route::bind('allevent', function ($id) {
  return App\Event::withTrashed()->where('id', $id)->first();
});

