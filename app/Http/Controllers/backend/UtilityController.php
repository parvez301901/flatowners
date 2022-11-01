<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Utility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function UtilityView() {
        $allUtilityData = Utility::all();
        return view('backend.utility.view_utility' , compact('allUtilityData'));
    }

    public function UtilityAdd() {
        return view('backend.utility.add_utility' );
    }

    public function UtilityStore(Request $request) {

        $data = new Utility();
        $data->name = $request->name;
        $data->save();
        return redirect()->route('utility.view');
    }

    public function UtilityDetail($id) {
        $data['detailUtility'] = Utility::find($id);
        return view('backend.utility.detail_utility' , $data);
    }

    public function UtilityUpdate(Request $request, $id){

        $data = Utility::find($id);
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Utility Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('utility.view' , $id)->with($notification);
    }

    public function UtilityDelete($id){
        $user = Utility::find($id);
        $user->delete();

        $notification = array(
            'message' => 'Utility Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('utility.view')->with($notification);

    }


}
