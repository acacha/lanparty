<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    return Prize::all();
  }
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
