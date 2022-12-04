<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Bank;
use App\Models\backend\ProjectExpense;
use App\Models\backend\ProjectPettyCash;
use App\Models\backend\ProjectRemainingBalance;
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
        if( $request->bank_id > 0 ) {
            $data->bank_id = $request->bank_id;
        } else {
            $data->bank_id = 0;
        }
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

        if( $request->bank_id > 0 ) {
            $get_project_bank_balance_row = Bank::where('project_id',$request->project_id )->first();
            $previous_bank_balance = Bank::where('project_id', $request->project_id)->value('balance');
            $get_project_bank_balance_row->balance = ($previous_bank_balance) - ($request->amount);
            $get_project_bank_balance_row->save();
        } else {
            /*Minus from the petty cash or bank */
            $get_project_petty_balance_row = ProjectPettyCash::where('project_id',$request->project_id )->first();
            $previous_petty_balance = ProjectPettyCash::where('project_id', $request->project_id)->value('balance');
            $get_project_petty_balance_row->balance = ($previous_petty_balance) - ($request->amount);
            $get_project_petty_balance_row->save();
        }

        /*Minus from Remaining Balance */
        $get_project_balance_row = ProjectRemainingBalance::where('project_id',$request->project_id )->first();
        $previous_balance = ProjectRemainingBalance::where('project_id', $request->project_id)->value('balance');
        $get_project_balance_row->balance = ($previous_balance) - ($request->amount);
        $get_project_balance_row->save();

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
