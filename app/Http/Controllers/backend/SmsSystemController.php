<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class SmsSystemController extends Controller {

    public function SmsAdd() {
        $data['allUnits'] = Unit::all();
        return view('backend.sms.add_sms' , $data);
    }

    public function SmsSend( Request $request) {
        $ready_number = '';
        foreach ($request->phones as $phone){
            $ready_number .= $phone . ',' ;
        }
        $number = $ready_number;
        $text = $request->message;

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

        if ( $sendstatus == 1101 ) {
            $send_success = 'SMS Send Successful';
        } else {
            $send_success = $sendstatus;
        }

        $notification = array(
            'message' => $send_success,
            'alert-type' => 'success'
        );
        return redirect()->route('sms.add')->with($notification);

    }

}
