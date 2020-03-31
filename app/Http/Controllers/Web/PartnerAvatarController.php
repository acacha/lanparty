<?php

namespace App\Http\Controllers\Web;


use App\Http\Requests\Partners\AvatarStore;
use App\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PartnerAvatarController extends Controller
{
  public function store(AvatarStore $request){
    $extension = $request->file('avatar')->getClientOriginalExtension();

    $path = $request->file('avatar')->storeAs(
      'partner_avatar', $request->partner_id . '.' . $extension, 'public'
    );
    if ($partner = Partner::where('id', $request->partner_id)->first()) {
      $partner->avatar = '/' . $path;
      $partner->save();
    }
    return back();
  }

  public function show(Request $request)
  {
    $partner = Partner::where('id', $request->id)->first();
    $avatar = Storage::disk('public')->exists($partner->avatar) ? $partner->avatar : $this->defaultAvatar();
    return response()->file(Storage::disk('public')->path($avatar), [
      'Cache-Control' => 'no-cache, must-revalidate, no-store, max-age=0, private',
      'Pragma' => 'no-cache'
    ]);
  }
  protected function defaultAvatar(){
    return Partner::DEFAULT_AVATAR_PATH;
  }
}
