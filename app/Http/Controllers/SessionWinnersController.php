<?php

namespace App\Http\Controllers;

use App\Http\Requests\Winners\SessionWinnersDestroy;
use App\Prize;

/**
 * Class SessionWinnersController
 * @package App\Http\Controllers
 */
class SessionWinnersController extends Controller
{
    /**
     * Remove all winners.
     *
     * @param SessionWinnersDestroy $request
     * @return mixed
     */
    public function destroy(SessionWinnersDestroy $request, $session)
    {
        foreach ($winners = Prize::winners()->where('session', $session)->get() as $winner) {
            $winner->number()->dissociate();
            $winner->save();
        }
        return $winners->count();
    }
}
