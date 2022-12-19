<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Floor;
use App\Models\backend\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class UnitController extends Controller {

    public function UnitView() {

        $data['allUnitData'] = Unit::all();
        $data['allFloorData'] = Floor::all();
        return view('backend.unit.view_unit', $data );
    }

    public function UnitAdd() {
        $data['allFloorData'] = Floor::all();
        return view('backend.unit.add_unit', $data );
    }

    public function UnitStore(Request $request) {

        $data = new Unit();
        $data->user_id = 6;
        $data->floor_id = $request->floorId;
        $data->name = $request->name;
        $data->rent = $request->rent;
        $data->serviceCharge = $request->serviceCharge;
        $data->save();
        return redirect()->route('unit.view');
    }

    public function UnitDetail($id) {
        $data['detailUnit'] = Unit::find($id);
        $data['allFloorData'] = Floor::all();
        $data['allFlatOwners'] = User::where('usertype','flatowner')->get();
        return view('backend.unit.detail_unit' , $data);
    }

    public function UnitUpdate(Request $request, $id) {
        $data = Unit::find($id);
        $data->floor_id = $request->floor_id;
        $data->name = $request->name;
        $data->rent = $request->rent;
        $data->serviceCharge = $request->serviceCharge;
        $data->user_id = $request->user_id;
        $data->save();

        $notification = array(
            'message' => 'Unit Information Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('unit.view')->with($notification);

    }

}
