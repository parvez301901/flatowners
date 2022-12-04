<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Bank;
use App\Models\backend\Floor;
use App\Models\backend\Project;
use App\Models\backend\ProjectAddAmount;
use App\Models\backend\ProjectExpense;
use App\Models\backend\ProjectRemainingBalance;
use App\Models\backend\SubProject;
use App\Models\backend\Unit;
use App\Models\backend\ProjectPettyCash;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function ProjectAdd() {
        return view('backend.project.add_project');
    }

    public function ProjectAddSubProject() {
        $data['allProjects'] = Project::all();
        $data['allSubProjects'] = SubProject::all();
        return view('backend.project.add_sub_project', $data);
    }

    public function ProjectDepositMoney() {
        $data['users'] = User::where('usertype','flatowner')->get();
        $data['allUtilitylist'] = Utility::all();
        $data['allFloorlist'] = Floor::all();
        $data['allProjectlist'] = Project::all();
        //$data['getBalance'] = ProjectRemainingBalance::where('project_id', 5)->value('balance');
        return view('backend.project.deposit_money_project' , $data );
    }
    public function ProjectBankTransaction() {
        $data['allBank'] = Bank::all();
        $data['find_petty_cash'] = ProjectPettyCash::first()->balance;
        return view('backend.project.tobank_projectmoney', $data );
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

        $all_units = Unit::all();
        $all_units_count = Unit::all()->count();

        foreach ($all_units as $single_unit) {

            $data2 = new ProjectAddAmount();
            $data2->amount = 0;
            $data2->due = ( $request->budget / $all_units_count );
            $data2->user_id = $single_unit->user_id;
            $data2->unit_id = $single_unit->id;
            $data2->floor_id = $single_unit->floor_id;
            $data2->project_id = $data->id;
            $data2->project_add_date = $request->project_start_date;
            $data2->project_cost_note = 'Not Paid Yet';
            $data2->save();
        }

        $data3 = new ProjectPettyCash();
        $data3->project_id = $data->id;
        $data3->balance = 0;
        $data3->save();

        $data4 = new ProjectRemainingBalance();
        $data4->project_id = $data->id;
        $data4->balance = 0;
        $data4->save();

        $notification = array(
            'message' => 'Project Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('project.detail' , $data->id)->with($notification);

    }

    public function ProjectStoreSubProject( Request $request) {

        $data = new SubProject();
        $data->name = $request->name;
        $data->project_id = $request->project_id;
        $data->sub_project_budget = $request->sub_project_budget;
        $data->sub_project_description = $request->sub_project_description;
        $data->sub_project_start_date = $request->project_start_date;
        $data->sub_project_end_date = $request->project_end_date;
        $data->sub_project_status = $request->sub_project_status;

        $data->save();

        $notification = array(
            'message' => 'Sub Project Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('project.detail' , $data->id)->with($notification);

    }

    public function ProjectView() {
        $data['allProject'] = Project::all();
        return view('backend.project.view_project' , $data);
    }

    public function ProjectDetail($id) {
        $data['users'] = User::where('usertype','flatowner')->get();
        $data['detailData'] = Project::find($id);
        $data['allUtilitylist'] = Utility::all();
        $data['allFloorlist'] = Floor::all();
        $data['allexpensedata'] = ProjectExpense::where('project_id',$id)->get();
        $data['total_expense'] = ProjectExpense::where('project_id',$id)->sum('amount');
        $data['alldepoasitdata'] = ProjectAddAmount::where('project_id',$id)->get();
        $data['total_deposit'] = ProjectAddAmount::where('project_id',$id)->sum('amount');
        $data['balanceInBank'] = Bank::where('id', 2)->value('amount');
        $data['balanceInPettyCash'] = ProjectPettyCash::where('project_id',$id)->value('balance');

        $data['allBank'] = Bank::all();
        return view('backend.project.detail_project', $data );
    }

    public function ProjectBalance(Request $request) {

        $project_id = $request->project_id;
        /*Project Added Amount*/
        $projectAddedAmounts = ProjectAddAmount::where('project_id',$project_id)->get();

        $incomes = array();

        $html['thsource'] = '<th>SL</th>';
        $html['thsource'] .= '<th>Flat Owner Name</th>';
        $html['thsource'] .= '<th>Flat No</th>';
        $html['thsource'] .= '<th>Amount</th>';

        foreach ($projectAddedAmounts as $key => $projectAddedAmount) {

            $flat_owner_name = User::find($projectAddedAmount->user_id);
            $get_unit_name = Unit::where('user_id', $projectAddedAmount->user_id)->first();
            $html[$key]['tdsource'] = '<td>' . ($key + 1) . '</td>';
            $html[$key]['tdsource'] .= '<td>'. $flat_owner_name->name .'</td>';
            $html[$key]['tdsource'] .= '<td>'. $get_unit_name->name .'</td>';
            $html[$key]['tdsource'] .= '<td>' . $projectAddedAmount->amount . '</td>';
            $incomes[] = (int)$projectAddedAmount->amount;

        }
        if ( 0 != (array_sum($incomes)) ) {
            $income = array_sum($incomes);
            $html['tfsource'] = '<td colspan="2" class="text-right"><b>Total</b></td>';
            $html['tfsource'] .= '<td>' . $income . '</td>';
        } else {
            $html['tfsource'] = '<td colspan="3" class="text-center"><b>No Data Found</b></td>';
        }

        /*Expense Listing*/
        $expenses = ProjectExpense::where('project_id',$project_id)->get();

        $outcomes = array();

        $html['th2source'] = '<th>SL</th>';
        $html['th2source'] .= '<th>Utility</th>';
        $html['th2source'] .= '<th>Amount</th>';

        foreach ($expenses as $key => $expense) {

            $utility = Utility::find($expense->utility_id);

            $html[$key]['td2source'] = '<td>' . ($key + 1) . '</td>';
            $html[$key]['td2source'] .= '<td>' . $utility->name . '</td>';
            $html[$key]['td2source'] .= '<td>' . $expense->amount . '</td>';
            $outcomes[] = (int)$expense->amount;
        }

        if ( 0 != (array_sum($outcomes)) ) {
            $outcome = array_sum($outcomes);
            $html['tf2source'] = '<td colspan="2" class="text-right"><b>Total</b></td>';
            $html['tf2source'] .= '<td>' . $outcome . '</td>';
        } else {
            $html['tf2source'] = '<td colspan="3" class="text-center"><b>No Data Found</b></td>';
        }

        $html['balance'] = ((int) $income) - ((int) $outcome);
        $get_bank = Bank::find(2);
        $html['balance_in_bank'] = $get_bank->amount;
        $html['bank_name'] = $get_bank->name;
        $get_petty = ProjectPettyCash::where('project_id',$project_id)->first();
        $html['balance_in_hand'] = $get_petty->balance;
        //$html = $projectAddedAmounts;
        return response()->json(@$html);

    }

    public function ProjecDepositToBank( Request $request) {

        $data = Bank::find($request->bank_id);
        $preveious_balance = $data->amount;
        $data->amount = $request->amount_to_deposit + $preveious_balance;
        $data->save();

        $cash_n_handle = ProjectPettyCash::all()->first();
        $cash_in_handle = ProjectPettyCash::first()->balance;
        $cash_n_handle->balance = ($cash_in_handle) - ($request->amount_to_deposit) ;
        $cash_n_handle->save();

        $notification = array(
            'message' => 'Deposited to The Bank Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('project.banktransaction')->with($notification);
    }

    public function WithdrawFromBank( Request $request) {

        $data = Bank::find($request->bank_id);
        $preveious_balance = $data->amount;
        $data->amount = $preveious_balance - $request->amount_to_withdraw;
        $data->save();

        $cash_n_handle = ProjectPettyCash::all()->first();
        $cash_in_handle = ProjectPettyCash::first()->balance;
        $cash_n_handle->balance = ($cash_in_handle) + ($request->amount_to_withdraw) ;
        $cash_n_handle->save();

        $notification = array(
            'message' => 'Withdraw Successfully and Added to Petty Cash',
            'alert-type' => 'success'
        );

        return redirect()->route('project.banktransaction')->with($notification);
    }


}
