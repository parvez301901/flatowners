<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\ProjectExpense;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;

class Project_ExpenseController extends Controller
{
    public function ProjectCostStore(Request $request){

        //Please validation here
        $data = new ProjectExpense();
        $data->amount = $request->amount;
        $data->project_id = $request->project_id;
        $data->utility_id = $request->utilityId;
        $data->user_id = $request->userId;
        $data->project_cost_date = $request->project_cost_date;
        $data->project_cost_note = $request->project_cost_note;

        if ($request->file('project_cost_image')) {
            $file = $request->file('project_cost_image');
            @unlink(public_path('upload/maintenance_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/maintenance_images'),$filename);
            $data['project_cost_image'] = $filename;
        }

        $data->save();



        $notification = array(
            'message' => 'Expenses Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('project.detail' , $request->project_id)->with($notification);
    }

    public function ProjectCostDetail($id) {
        //$data['allexpensedata'] = ProjectExpense::where('project_id',$id)->first();
        $data['allexpensedata'] = ProjectExpense::find($id);
        $data['allUtilitylist'] = Utility::all();
        $data['users'] = User::all();

        return view('backend.project.detail_project_cost', $data );
    }

    public function ProjectCostUpdate(Request $request, $id){

        $data = ProjectExpense::find($id);

        $data->amount = $request->amount;
        $data->project_id = $request->project_id;
        $data->utility_id = $request->utility_id;
        $data->user_id = $request->user_id;
        $data->project_cost_date = $request->project_cost_date;
        $data->project_cost_note = $request->project_cost_note;

        if ($request->file('project_cost_image')) {
            $file = $request->file('project_cost_image');
            @unlink(public_path('upload/maintenance_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/maintenance_images'),$filename);
            $data['project_cost_image'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Project Cost Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('backend.project.detail_project' , $id)->with($notification);
    }

}
