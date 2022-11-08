<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Floor;
use App\Models\backend\MaintenanceModel;
use App\Models\backend\Unit;
use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use http\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function MaintenanceView() {
        return view('backend.maintenance.view_maintenance');
    }

    public function MaintenanceAdd() {
        $data['users'] = User::where('usertype','flatowner')->get();
        $data['allFloorlist'] = Floor::all();
        $data['allUnitlist'] = Unit::all();
        $data['allUtilitylist'] = Utility::all();

        return view('backend.maintenance.add_maintenance' , $data);
    }

    public function MaintenanceStore(Request $request) {

        //Please validation here
        $data = new MaintenanceModel();
        $data->amount = $request->amount;
        $data->unitId = $request->unitId;
        $data->floorId = $request->floorId;
        $data->utilityId = $request->utilityId;
        $data->userId = $request->userId;
        $data->maintenanceCostDate = $request->maintenanceCostDate;
        $data->maintenanceNote = $request->maintenanceNote;

        if ($request->file('maintenanceImage')) {
            $file = $request->file('maintenanceImage');
            @unlink(public_path('upload/maintenance_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/maintenance_images'),$filename);
            $data['maintenanceImage'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('maintenance.add')->with($notification);

    }

    public function MaintenanceSearch(Request $request){

        $year_id = $request->year_id . '-01';

        $date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));

        $expenses = MaintenanceModel::whereMonth('maintenanceCostDate', $date->month)
            ->whereYear('maintenanceCostDate', $date->year)
            ->get();

        $charges = array();

        $html['thsource'] = '<th>SL</th>';
        $html['thsource'] .= '<th>Floor</th>';
        $html['thsource'] .= '<th>Unit</th>';
        $html['thsource'] .= '<th>Utility</th>';
        $html['thsource'] .= '<th>Date</th>';
        $html['thsource'] .= '<th>Person</th>';
        $html['thsource'] .= '<th>Receipt Image</th>';
        $html['thsource'] .= '<th>Note</th>';
        $html['thsource'] .= '<th>Amount</th>';

        foreach ($expenses as $key => $expense) {

            $person = User::find($expense->userId);
            $floor = Floor::find($expense->floorId);
            $unit = Unit::find($expense->unitId);
            $utility = Utility::find($expense->utilityId);

            if( !empty( $expense->maintenanceImage) ) {
               $imgURL = 'http://127.0.0.1:8000/upload/maintenance_images/' . $expense->maintenanceImage;
            } else {
               $imgURL = '';
            }

            $html[$key]['tdsource'] = '<td>' . ($key + 1) . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $floor->name . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $unit->name . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $utility->name . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $expense->maintenanceCostDate . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $person->name . '</td>';
            $html[$key]['tdsource'] .= '<td><img id="showImage" src="'. $imgURL .'" style="width: 100px; width: 100px; border: 1px solid #000000;"></td>';
            $html[$key]['tdsource'] .= '<td>' . $expense->maintenanceNote . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $expense->amount . '</td>';

            $charges[] = (int)$expense->amount;

        }
        if ( 0 != (array_sum($charges)) ) {
            //$other_cost = AccountOtherCost::whereBetween('date',[$sdate,$edate])->sum('amount');
            $html['tfsource'] = '<td colspan="8" class="text-right"><b>Total</b></td>';
            $html['tfsource'] .= '<td>' . array_sum($charges) . '</td>';
        } else {
            $html['tfsource'] = '<td colspan="9" class="text-center"><b>No Data Found</b></td>';
        }

        return response()->json(@$html);

    }// end method

    public function MaintenanceSalary() {
        $data['allEmployee'] = User::where('usertype','employee')->get();
        $data['total_salary'] = User::where('usertype','employee')->sum('salary');
        return view('backend.maintenance.salary_maintenance' , $data);
    }

}
