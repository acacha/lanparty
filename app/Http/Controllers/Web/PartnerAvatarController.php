<?php

namespace App\Http\Controllers\Web;

use App\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerAvatarController extends Controller
{
  public function store(Request $request){
    $extension = $request->file('avatar')->getClientOriginalExtension();
    $name = $request->file('avatar')->getClientOriginalName();
    $path = $request->file('avatar')->storeAs(
      'public_partner_avatar',$name.'.'.$extension
    );
    if ($partner = Partner::where('id',$request->partner_id)->first()){
      $partner->avatar = $path;
      $partner->save();
    }
    return back();
  }

  public function show(Request $request)
  {
    $partner = Partner::where('id',$request->id)->first();
    $avatar = \Storage::disk('local')->exists($partner->avatar) ? $partner->avatar : $this->defaultAvatar();
    return response()->file(\Storage::disk('local')->path($avatar),[
      'Cache-Control' => 'no-cache, must-revalidate, no-store, max-age=0, private',
      'Pragma' => 'no-cache'
    ]);
  }
  protected function defaultAvatar(){
    return Partner::DEFAULT_PHOTO_PATH;
  }
}
