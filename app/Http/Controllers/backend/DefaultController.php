<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function GetUnit(Request $request){
        $floor_id = $request->floor_id;
        $allData = Unit::where('floor_id',$floor_id)->get();
        return response()->json($allData);
    }

    public function GetOwnerIdByUnit(Request $request){
        $floor_id = $request->floor_id;
        $user_id = $request->user_id;
        $unit_id = $request->unit_id;
        $matchThese = ['floor_id' => $floor_id, 'user_id' => $user_id, 'id' => $unit_id ];
        $allData = Unit::where($matchThese)->get();

        return response()->json($allData);
    }

    public function FindOwnerIdByUnit(Request $request){
        $floor_id = $request->floor_id;
        $unit_id = $request->unit_id;
        $matchThese = ['floor_id' => $floor_id, 'id' => $unit_id ];
        $allData = Unit::where($matchThese)->first();
        $findFlatowner = User::find($allData->user_id);
        return response()->json($findFlatowner);
    }
    public function SMSThankYou(Request $request) {
        $number = $request->phone;

        $url = "http://66.45.237.70/api.php";
        $text="Thank You";
        $data= array(
            'username'=>"01673950496",
            'password'=>"7RWNC9T8",
            'number'=>"$number",
            'message'=>"$text"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        return response()->json($sendstatus);
    }

}
