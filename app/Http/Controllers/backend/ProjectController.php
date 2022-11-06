<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Project;
use App\Models\backend\ProjectExpense;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function ProjectAdd() {
        return view('backend.project.add_project');
    }

    public function ProjectStore( Request $request) {

        $data = new Project();
        $data->name = $request->name;
        $data->project_budget = $request->budget;
        $data->project_description = $request->project_description;
        $data->project_start_date = $request->project_start_date;
        $data->project_end_date = $request->project_end_date;
        $data->project_status = $request->status;

        $data->save();

        $notification = array(
            'message' => 'Project Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('project.add')->with($notification);

    }

    public function ProjectView() {
        $data['allProject'] = Project::all();
        return view('backend.project.view_project' , $data);
    }

    public function ProjectDetail($id) {
        $data['detailData'] = Project::find($id);
        $data['allUtilitylist'] = Utility::all();
        //$data['alluserdarta'] = ProjectExpense::where('user_id',$id)->with(['units.floor'])->get();

        return view('backend.project.detail_project', $data );
    }



}
