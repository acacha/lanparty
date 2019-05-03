<?php

namespace App\Http\Controllers;

use App\Exceptions\NotEnoughNumbersException;
use App\Http\Requests\Numbers\NumbersDestroy;
use App\Http\Requests\Numbers\NumbersStore;
use App\Http\Resources\NumberWithUserResource;
use App\Number;

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

    public function store(NumbersStore $request)
    {
        if ($request->quantity == 0) abort ('422', 'Com a mínim cal afegir un número!');
        Number::addNumbers($request->quantity,$request->session);
    }

    public function destroy(NumbersDestroy $request)
    {
        try {
            Number::removeNumbers($request->quantity,$request->session);
        } catch (NotEnoughNumbersException $e) {
            abort('422',"S'han eliminat tots els números disponibles");
        }
    }
}
