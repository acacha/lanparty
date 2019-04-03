<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partners\PartnersIndex;

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
        $partners = collect([]);
        return view('manage.partners.index', compact('partners'));
    }
}
