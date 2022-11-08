<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\ProjectAddAmount;
use Illuminate\Http\Request;

class ProjectAddAmountController extends Controller
{
    public function ProjectAddStore(Request $request) {

        $data = new ProjectAddAmount();
        $data->amount = $request->amount;
        $data->user_id = $request->user_id;
        $data->project_id = $request->project_id;
        $data->project_add_date = $request->project_cost_date;
        $data->project_cost_note = $request->project_cost_note;

        $data->save();

        $notification = array(
            'message' => 'Money Deposited Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('project.detail' , $request->project_id)->with($notification);
    }

}
