<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Unit;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function GetUnit(Request $request){
        $floor_id = $request->floor_id;
        //$allData = AssignSubject::with(['school_subject'])->where('class_id',$class_id)->get();
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

}
