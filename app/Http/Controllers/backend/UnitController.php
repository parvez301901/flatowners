<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Floor;
use App\Models\backend\Unit;
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
        $data->user_id = 0;
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
        return view('backend.unit.detail_unit' , $data);
    }


}
