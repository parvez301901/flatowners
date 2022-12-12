<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SmsSystemController extends Controller {

    public function SmsAdd() {
        $data['allUsers'] = User::all();
        $data['allFlatOwners'] = User::where('usertype','flatowner');
        $data['allEmployees'] = User::where('usertype','employee');
        return view('backend.sms.add_sms' , $data);
    }

}
