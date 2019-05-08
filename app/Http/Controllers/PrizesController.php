<?php

namespace App\Http\Controllers;

use App\Prize;

/**
 * Class PrizesController
 *
 * @package App\Http\Controllers
 */
class PrizesController extends Controller
{
  /**
   * List.
   * @return \Illuminate\Database\Eloquent\Collection|static[]
   */
  public function index()
  {
    $prizes = Prize::with(['partner'])->where('session', config('lanparty.session') )->get();
    return view('prizes',compact('prizes'));
  }
  /**
   * Show.
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function show()
  {
    $prizes = Prize::with(['partner','user','number','number.user', 'partner'])->get();
    return view('prizes',compact('prizes'));
  }
}
