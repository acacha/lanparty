<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteWinners;
use App\Prize;
use Illuminate\Http\Request;

/**
 * Class WinnersController
 * @package App\Http\Controllers
 */
class WinnersController extends Controller
{
    /**
     * Remove all winners.
     *
     * @param DeleteWinners $request
     * @return mixed
     */
    public function destroy(DeleteWinners $request)
    {
        foreach ($winners = Prize::winners()->get() as $winner) {
            $winner->number()->dissociate();
            $winner->save();
        }
        return $winners->count();
    }
}
