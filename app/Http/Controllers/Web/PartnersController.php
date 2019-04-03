<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partners\PartnersIndex;
use App\Role;

/**
 * Class ManagersController.
 *
 * @package App\Http\Controllers
 */
class PartnersController extends Controller
{
    /**
     * @return mixed
     */
    public function index(PartnersIndex $request)
    {
        $partners = collect(Role::findByName('Manager')->users);
        return view('manage.partners.index', compact('partners'));
    }
}
