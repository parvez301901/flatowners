<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SmsSystemController extends Controller {

    public function SmsAdd() {
        $data['allUser'] = User::all();
        $data['allFlatOwner'] = User::where('usertype','flatowner');
        $data['allEmployee'] = User::where('usertype','employee');
        return view('backend.sms.add_sms' , $data);
    }

}
