<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteWinner;
use App\Http\Requests\ListWinners;
use App\Http\Requests\StoreWinner;
use App\Number;
use App\Prize;
use Illuminate\Http\Request;

/**
 * Class WinnerController.
 *
 * @package App\Http\Controllers
 */
class WinnerController extends Controller
{

    /**
     * List winners.
     *
     * @return mixed
     */
    public function index()
    {
        return Prize::winners()->with(['partner','number.user'])->get();
    }

    /**
     * Remove winner.
     *
     * @param DeleteWinner $Request
     * @param Prize $prize
     * @return Prize
     */
    public function destroy(DeleteWinner $request, Prize $prize)
    {
        if ($prize->session !== config('lanparty.session')) abort(422,'NO és possible realitzar accions en sessions arxivades.') ;
        $prize->number()->dissociate();
        $prize->save();
        return $prize;
    }

    /**
     * Store.
     *
     * @param StoreWinner $request
     * @param Prize $prize
     * @return Prize
     */
    public function store(StoreWinner $request, Prize $prize)
    {
        $number = Number::assigned()->findOrFail($request->number);
        $prize->number()->associate($number);
        $prize->save();
        $prize->load('number');
        $prize = $prize->fresh();
        return $prize;
    }
}
