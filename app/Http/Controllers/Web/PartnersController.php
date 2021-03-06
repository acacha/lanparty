<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partners\PartnerIndex;
use App\Partner;
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
    public function index(PartnerIndex $request)
    {
        //$partners = collect(Role::findByName('Manager')->users);
      $partners = Partner::partners();
     $uri = '/api/v1/partners/';
        return view('manage.partners.index', compact('partners','uri'));
    }
}
