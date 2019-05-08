<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prizes\PrizesDestroy;
use App\Http\Requests\Prizes\PrizesShow;
use App\Http\Requests\Prizes\PrizesStore;
use App\Http\Requests\Prizes\PrizesUpdate;
use App\Http\Requests\Prizes\PrizesIndex;
use App\Prize;


/**
 * Class AvailablePrizesController
 *
 * @package App\Http\Controllers
 */
class AvailablePrizesController extends Controller
{

    /**
     * List.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(PrizesIndex $request)
    {
        $prize = map_collection(Prize::available()->orderBy('created_at','desc')->get());
        return $prize;

    }
    public function show(PrizesShow $request, Prize $prize)
    {
        return $prize->map();
    }
    public function destroy(PrizesDestroy $request, Prize $prize)
    {
        $prize->delete();
    }
    public function store(PrizesStore $request)
    {
        $prize = new Prize();
        $prize->name = $request->name;
        $prize->description = $request->description;
        $prize->notes = $request->notes;
        $prize->partner_id = $request->partner_id;
        $prize->user_id = $request->user_id;
        $prize->number_id = $request->number_id;
        $prize->multiple = $request->multiple;
        $prize->save();
        return $prize->map();
    }
    public function update(PrizesUpdate $request, Prize $prize)
    {
        $prize->update($request->all());
        $prize->save();
        return $prize->map();
    }
}
