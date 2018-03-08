<?php

namespace App\Http\Controllers;

use App\Http\Resources\NumberWithUserResource;
use App\Number;
use Illuminate\Http\Request;

/**
 * Class MumbersController.
 *
 * @package App\Http\Controllers
 */
class NumbersController extends Controller
{
    /**
     * Get all numbers.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return NumberWithUserResource::collection(Number::with(['user'])->get());
    }
}
