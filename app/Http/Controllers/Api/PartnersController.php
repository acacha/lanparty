<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partners\PartnerDestroy;
use App\Http\Requests\Partners\PartnerIndex;
use App\Http\Requests\Partners\PartnerShow;
use App\Http\Requests\Partners\PartnerStore;
use App\Http\Requests\Partners\PartnerUpdate;
use App\Partner;

/**
 * Created by PhpStorm.
 * User: mirokshi
 * Date: 7/05/19
 * Time: 9:31
 */

/**
 * Class PartnersController
 *
 * @package App\Http\Controller
 */
class PartnersController extends Controller
{
  public function index(PartnerIndex $request)
  {
    return map_collection(Partner::orderBy('created_at','desc')->get());
  }

  public function show(PartnerShow $request, Partner $partner)
  {
    return $partner->map();
  }

  public function store(PartnerStore $request)
  {
    $partner = new Partner();
    $partner->name = $request->name;
    $partner->session = $request->session;
    $partner->category = $request->category;
    $partner->avatar = $request->avatar;
    $partner->save();

    return $partner->map();
  }

  public function destroy(PartnerDestroy $request, Partner $partner)
  {
    $partner->delete();
    return $partner;
  }

  public function update(PartnerUpdate $request, Partner $partner)
  {
    $partner->name = $request->name;
    $partner->session = $request->session;
    $partner->category = $request->category;
    $partner->avatar = $request->avatar;
    $partner->save();

    return $partner->map();

  }

  public function editName(PartnerUpdate $request,Partner $partner)
  {
   $partner->name = $request->name;
   $partner->save();
   return $partner->map();
  }
}

