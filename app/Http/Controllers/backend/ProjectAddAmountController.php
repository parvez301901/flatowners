<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Project;
use App\Models\backend\ProjectAddAmount;
use App\Models\backend\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProjectAddAmountController extends Controller
{
    public function ProjectAddStore(Request $request) {

        $data = new ProjectAddAmount();
        $data->amount = $request->amount;
        $data->user_id = $request->user_id;
        $data->unit_id = $request->unit_id;
        $data->floor_id = $request->floor_id;
        $data->project_id = $request->project_id;
        $data->project_add_date = $request->project_cost_date;
        $data->project_cost_note = $request->project_cost_note;

        $saved = $data->save();

        if($saved == 1){
            $get_user = User::find($request->user_id);
            $get_project = Project::find($request->project_id);
            $number = $get_user->phone;
            //if ($find_due > 0){
                $text = "Dear $get_user->name, Received TK$request->amount for $get_project->name. Thank You.";
            //} else {

            //}

            $url = "http://66.45.237.70/api.php";
            $data= array(
                'username'=>"01673950496",
                'password'=>"7RWNC9T8",
                'number'=>"$number",
                'message'=>"$text"
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];

        }

        $notification = array(
            'message' => 'Money Deposited Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('project.detail' , $request->project_id)->with($notification);
    }

    public function ProjectAddUpdate(Request $request, $id) {

        $data = ProjectAddAmount::where('project_id' , $id)
        ->where('user_id' , $request->user_id)
        ->where('unit_id' , $request->unit_id)
        ->first();
        $find_due = ($data->due - $request->amount);
        $data->amount = ($data->amount + $request->amount);
        $data->due = $find_due;
        $updated = $data->save();

        if($updated == 1){
            $get_user = User::find($request->user_id);
            $get_project = Project::find($request->project_id);
            $number = $get_user->phone;
            //if ($find_due > 0){
            //$text = "Dear $get_user->name, Received TK$request->amount for $get_project->name. Total Paid Tk$updated->amount Due $find_due. Thank You.";
            $text = "Dear $get_user->name, Received TK$request->amount for $get_project->name. Due $find_due. Thank You.";
            //} else {

            //}

            $url = "http://66.45.237.70/api.php";
            $data= array(
                'username'=>"01673950496",
                'password'=>"7RWNC9T8",
                'number'=>"$number",
                'message'=>"$text"
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];

        }


        $notification = array(
            'message' => 'Money Deposited Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('project.detail' , $request->project_id)->with($notification);
    }


    public function SMSProjectDue(Request $request) {
        $number = $request->phone;
        $text = $request->text;

        $url = "http://66.45.237.70/api.php";
        $data= array(
            'username'=>"01673950496",
            'password'=>"7RWNC9T8",
            'number'=>"$number",
            'message'=>"$text"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        return response()->json($sendstatus);
    }

}


