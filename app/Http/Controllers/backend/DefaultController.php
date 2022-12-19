<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Bank;
use App\Models\backend\PettyCash;
use App\Models\backend\ProjectAddAmount;
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
    public function FindDueFindOwnerIdByUnit(Request $request){
        $floor_id = $request->floor_id;
        $unit_id = $request->unit_id;
        $project_id = $request->project_id;
        $matchThese = ['floor_id' => $floor_id, 'id' => $unit_id ];
        $allData = Unit::where($matchThese)->first();
        $data['findFlatowner'] = User::find($allData->user_id);
        $matchTheseForDue = ['floor_id' => $floor_id, 'unit_id' => $unit_id, 'user_id' => $allData->user_id, 'project_id' => $project_id ];
        $data['findProjectDue'] = ProjectAddAmount::Where($matchTheseForDue)->first();
        return response()->json($data);
    }
    public function SMSThankYou(Request $request) {
        $number = $request->phone;
        $text = $request->text;

        $url = "http://66.45.237.70/api.php";
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

    public function SMSDueRemind(Request $request) {
        $number = $request->phone;
        $text = $request->text;

        $url = "http://66.45.237.70/api.php";
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

    public function PettyBalanceCheck(Request $request) {
        $amount_to_check = $request->amount_to_check;
        $find_petty_cash = PettyCash::first()->balance;

        if ( ($find_petty_cash - $amount_to_check) >= 0 ) {
            $result = 'ok';
        } else {
            $result = 'notok';
        }

        return response()->json($result);
    }

    public function ByBankIdFindBankInfo(Request $request) {

        $find_bank_cash = Bank::find($request->bank_id)->amount;

        return response()->json($find_bank_cash);
    }

}
