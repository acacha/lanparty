<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Storage;

/**
 * Class GroupAvatarController.
 * 
 * @package App\Http\Controllers
 */
class GroupAvatarController extends Controller
{
    public function show(Group $group)
    {
        return response()->file(Storage::disk('local')->path($group->avatar));
    }

    /**
     * Store.
     *
     * @param Request $request
     * @return false|string
     */
    public function store(Request $request)
    {
//        dd($request->file);
//        dd($request->all());
        $path = $request->file->storeAs('avatars','prova.jpg');

        return $path;
    }
}
