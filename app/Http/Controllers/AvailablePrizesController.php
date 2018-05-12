<?php

namespace App\Http\Controllers;

use App\Prize;
use Illuminate\Http\Request;

/**
 * Class AvailablePrizesController
 *
 * @package App\Http\Controllers
 */
class AvailablePrizesController extends Controller
{
    /**
     * Index.
     *
     * @return mixed
     */
    public function index()
    {
        return Prize::available()->get();
    }
}
