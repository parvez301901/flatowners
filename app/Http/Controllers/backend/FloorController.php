<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function FloorView(){
        $allFloors = Floor::all();
        return view('backend.floor.view_floor', compact('allFloors'));
    }
    public function FloorAdd(){
        return view('backend.floor.add_floor');
    }
    public function FloorStore(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|unique:floors,name',
        ],
            [
                'name.unique' => 'Please use different Name'
            ]
        );

        $data = new Floor();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Data Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('floor.view')->with($notification);
    }
    public function FloorDetail($id) {
        $detailData = Floor::find($id);
        return view('backend.floor.detail_floor', compact('detailData'));
    }

    public function FloorUpdate(Request $request, $id){

        $data = Floor::find($id);
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Floor Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('floor.view' , $id)->with($notification);

    }

}
