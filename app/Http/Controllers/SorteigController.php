<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeeSorteig;
use App\Number;
use App\Prize;

/**
 * Class SorteigController.
 *
 * @package App\Http\Controllers
 */
class SorteigController extends Controller
{
    /**
     * See sorteig.
     *
     * @param SeeSorteig $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(SeeSorteig $request)
    {
        $numbers = Number::assigned()->with('user')->get();
        $prizes = Prize::available()->with('partner')->get();
        $winners = Prize::winners()->with(['partner','number.user'])->orderBy('updated_at','DESC')->get();
        return view('manage.sorteig',compact('numbers','prizes','winners'));
    }
}
