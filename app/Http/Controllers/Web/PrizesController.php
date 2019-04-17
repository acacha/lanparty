<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prizes\PrizesIndex;
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
    public function index(PrizesIndex $request)
    {
      //$prizes = Prize::with(['partner','user','number','number.user'])->get();
      $prizes = Prize::prizes();
      return view('manage.prizes.index',compact('prizes'));

    }
}
