<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Group;
use App\Flag;
use App\Event;
use Auth;

/**
 * Class CaptureTheFlagController.
 *
 * @package App\Http\Controllers
 */
class CaptureTheFlagController extends Controller
{


    public function ctfId(){
      static $id;
      if (!isset($id)){
        $e=Event::where('name', 'Capture The Flag')->first();
        if($e){
          $id=$e->id;
        }
      }
      return $id;

    }
    public function registratCTF(){

      $reg=DB::table('members')->join('registrations', 'group_id', 'registration_id')->where('event_id', '=', $this->ctfId())->where('registration_type', 'App\\Group')->where('user_id', Auth::user()->id)->select('group_id')->first();
      if (isset($reg)){
        return $reg->group_id;
      } else {
        return false;
      }

    }
    /**
     * Show.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $flags =Flag::all()->pluck('name')->all();
        $allGroups=DB::table('groups')->join('registrations', 'groups.id', 'registration_id')->where('event_id', '=', $this->ctfId())->where('registration_type', 'App\\Group')->select('groups.id')->get();
        $out=[];
        foreach ($allGroups as $g){
          $points = 0;
          $out[$g->id]['id']=$g->id;
          $group=Group::find($g->id);
          $out[$g->id]['name']=$group->name;
          $out[$g->id]['flags']=array_fill_keys($flags, false);
          foreach ($group->flags as $f){
            $out[$g->id]['flags'][$f->name]=true;
            $points+=$f->points;
          }
          $out[$g->id]['points']=$points;
        }
        usort($out, function($a, $b) {
            return $b['points'] <=> $a['points'];
        });

        return view('ctf', [
              'groups' => $out,
              'registratCTF' => $this->registratCTF() ? "Registrat" : "NoRegistrat"
        ]);

    }

   public function group($id)
   {
     $group = Group::where('id',$id)->first();
     return view('ctfGroup', [
       'groupname' => $group->name,
       'flags' => $group->flags
     ]);
   }

   public function submit(Request $request) {

       $this->validate($request, [
           'flag' => 'required|string'
       ]);

       $flag=Flag::where('flag', $request['flag'])->first();
       if ($flag===null){
         return response()->json([
            'errors' => ['Flag' => 'El Flag No existeix'],
         ], 422);
       } else {

         $group_id=$this->registratCTF();
         if (!$group_id){
             return response()->json([
                'errors' => ['User' => 'Usuari no registrat en cap grup de la competició'],
             ], 422);
         }

         $group=Group::findOrFail($group_id);
         $existeix=Group::findOrFail($group_id)->flags()->find($flag->id);

         if ($existeix){
           return response()->json([
              'errors' => ['Flag' => 'El Flag ja estava capturat pel grup ']
          ], 422);
         } else {
           $group->flags()->attach($flag->id,['captured'=>Carbon::now()]);
         }
       }

       return response()->json("Flag capturat!!", 200);
   }


}
