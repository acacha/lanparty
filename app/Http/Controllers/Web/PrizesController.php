<?php

namespace App\Http\Controllers\Web;

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
      $prizes = Prize::with(['partner','user','number','number.user'])->get();
      return view('prizes',compact('prizes'));
    }
}
