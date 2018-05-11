<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteWinner;
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
     * Remove winner.
     *
     * @param DeleteWinner $Request
     * @param Prize $prize
     * @return Prize
     */
    public function destroy(DeleteWinner $Request,Prize $prize)
    {
        $prize->number()->dissociate();
        $prize->save();
        return $prize;
    }
}
