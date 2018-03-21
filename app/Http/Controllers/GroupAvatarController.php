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
    /**
     * Show group avatar.
     *
     * @param Group $group
     * @return mixed
     */
    public function show(Group $group)
    {
//        dd($group->avatar);
        if ($group->avatar && Storage::exists($group->avatar)) {
            return response()->file(Storage::path($group->avatar));
        }

//        return Storage::disk('public')->response('groupPlaceholder.jpg');
//        dd(Storage::disk('public')->path('groupPlaceholder.jpg'));
        return response()->download(public_path('/img/group1.jpg'));
        return response()->download(Storage::disk('public')->path('groupPlaceholder.jpg'));
//        dd(Storage::disk('public')->path('groupPlaceholder.jpg'));

        return response()->file(public_path('/img/group1.jpg'),['Content-Type' => 'image/jpeg']);

//        dd(public_path('/img/groupPlaceholder.jpg'));
//        dd('dasdsaas');

    }

    /**
     * Store.
     *
     * @param Request $request
     * @return false|string
     */
    public function store(Request $request, Group $group)
    {
        Storage::delete($group->avatar);
        $group->avatar = $request->avatar->storeAs('avatars', $this->avatarFileName($group, $request->avatar));
        $group->update();
        return $group;
    }

    /**
     * Get avatar file name.
     *
     * @param $group
     * @param $file
     * @return string
     */
    protected function avatarFileName($group, $file)
    {
        return $group->id . '_' . snake_case($group->name) . '.' . pathinfo($file->name, PATHINFO_EXTENSION);
    }
}
