<?php

namespace App\Http\Controllers;

use App\Prize;
use Illuminate\Http\Request;

/**
 * Class PrizesController
 *
 * @package App\Http\Controllers
 */
class PrizesController extends Controller
{
    /**
     * Show.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $prizes = Prize::with(['partner','user','number','number.user'])->get();
        return view('prizes',compact('prizes'));
    }
}
