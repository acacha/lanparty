<?php

namespace App\Http\Controllers;

use App\Group;
use Auth;
use Illuminate\Http\Request;

/**
 * Class MembersController.
 *
 * @package App\Http\Controllers
 */
class MembersController extends Controller
{
    /**
     * Current logged user leave the group.
     *
     * @param Group $group.
     */
    public function destroy(Group $group)
    {
        $group->leave(Auth::user());
    }
}
