<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Bank;
use App\Models\backend\MaintenanceModel;
use App\Models\backend\PettyCash;
use App\Models\backend\RemainingBalance;
use App\Models\ServiceCharge;
use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Report extends Controller
{
    public function reportMonthlyBalancesheetView() {
        return view('backend.report.view_monthly_report');
    }

    public function reportMonthlyIncome() {
        return view('backend.report.view_monthly_income_report');
    }

    public function reportYearlyBalancesheetView() {

        /*
        $data['new_grouped'] = MaintenanceModel::select('id',DB::raw("(sum(amount)) as total_taka"),DB::raw("(DATE_FORMAT(created_at, '%m-%Y')) as month_year"))->orderBy('created_at')->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))->get();
       */
        /*
        $data['new_grouped'] = MaintenanceModel::selectRaw('year(maintenanceCostDate) year, monthname(maintenanceCostDate) month, utilityId , (sum(amount)) as total_taka', )
            ->groupBy('year', 'month')
            ->orderBy('maintenanceCostDate', 'asc')
            ->get();
        */

        $year_id = '2022';

        $date = Carbon::createFromFormat('Y', Carbon::parse($year_id)->format('Y'));

        $data['new_grouped'] = MaintenanceModel::whereYear('maintenanceCostDate', $date->year)
            ->groupBy($date->year)
            ->orderBy('maintenanceCostDate', 'asc')
            ->get();

        return view('backend.report.view_yearly_report', $data);
    }

    public function reportMonthlyBalancesheetSearch(Request $request) {

        $year_id = $request->year_id . '-01';

        $date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));
        $this_month_date = date('F, Y', strtotime($year_id));

        /*service charge listing*/

        /*$empsalaries = ServiceCharge::whereMonth('serviceChargeMonthYear', $date->month)
            ->whereYear('serviceChargeMonthYear', $date->year)
            ->get();*/

        $empsalaries = ServiceCharge::whereMonth('serviceChargeDate', $date->month)
            ->whereYear('serviceChargeDate', $date->year)
            ->get();

        $f = date('F, Y', strtotime($year_id." -1 month"));
        $prev_date = Carbon::createFromFormat('m/Y', Carbon::parse($f)->format('m/Y'));
        $is_in_month_year = RemainingBalance::get()->first();

        $incomes = array();
        $servicecharge = array();

        $html['thsource'] = '<th class="tg-0lax text-center tg-bold">Category</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">SL no</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">Date</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">Description</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">Amount</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">Balance</th>';

        $html['previousBalance'] = '<td class="tg-0lax" rowspan="2" style="vertical-align: inherit">Income</td>';
        $html['previousBalance'] .= '<td class="tg-0lax"></td>';
        $html['previousBalance'] .= '<td class="tg-0lax">'. $f .'</td>';
        $html['previousBalance'] .= '<td class="tg-0lax">Previous Month Balance</td>';
        $html['previousBalance'] .= '<td class="tg-0lax">' . $is_in_month_year->balance . '</td>';
        $html['previousBalance'] .= '<td class="tg-0lax"></td>';

        if (!empty( $is_in_month_year ) ) {
            $incomes[] = (int)$is_in_month_year->balance;
        }

        foreach ($empsalaries as $key => $empsalarie) {

            $html[$key + 1]['tdsource'] = '<td>' . ($key + 2) . '</td>';
            $html[$key + 1]['tdsource'] .= '<td>'. $empsalarie['get_user']['name'] .'</td>';
            $html[$key + 1]['tdsource'] .= '<td>'. $empsalarie->serviceChargeDate .'</td>';
            $html[$key + 1]['tdsource'] .= '<td>' . $empsalarie->serviceChargeAmount . '</td>';
            $incomes[] = (int)$empsalarie->serviceChargeAmount;
            $servicecharge[] = (int)$empsalarie->serviceChargeAmount;

        }
        $total_service_charge = array_sum($servicecharge);

//      $html['serviceChargeIncome'] = '<td class="tg-0lax"></td>';
        $html['serviceChargeIncome'] = '<td class="tg-0lax"></td>';
        $html['serviceChargeIncome'] .= '<td class="tg-0lax">'. $this_month_date .'</td>';
        $html['serviceChargeIncome'] .= '<td class="tg-0lax">Total service Charge collection ( '. $this_month_date .' )</td>';
        $html['serviceChargeIncome'] .= '<td class="tg-0lax">'. $total_service_charge .'</td>';
        $html['serviceChargeIncome'] .= '<td class="tg-0lax"></td>';

        if ( 0 != (array_sum($incomes)) ) {
            $income = array_sum($incomes);
            $html['tfsource'] = '<td colspan="3" class="text-right"><b>Total</b></td>';
            $html['tfsource'] .= '<td>' . $income . '</td>';

        } else {
            $income = 0;
            $html['tfsource'] = '<td colspan="3" class="text-center"><b>No Data Found</b></td>';
        }

        $html['total_income'] = '<td class="tg-0lax"></td>';
        $html['total_income'] .= '<td class="tg-0lax"></td>';
        $html['total_income'] .= '<td class="tg-0lax"></td>';
        $html['total_income'] .= '<td class="tg-0lax"></td>';
        $html['total_income'] .= '<td class="tg-0lax color-black" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);"><b>Sub Total</b></td>';
        $html['total_income'] .= '<td class="tg-0lax"><b>'. $income .'</b></td>';

        /*Expense Listing*/

        $expenses = MaintenanceModel::whereMonth('maintenanceCostDate', $date->month)
            ->whereYear('maintenanceCostDate', $date->year)
            ->get();

        $outcomes = array();

        $count_of_expenditure_list = count($expenses);

        //$html['expen'] = $expenses;
        //$html['count_of_expenditure_list'] = $count_of_expenditure_list;
        foreach ($expenses as $key => $expense) {

            $utility = Utility::find($expense->utilityId);

            if ($key == 0) {
                $html[$key + 1]['td2source'] = '<td class="tg-0lax" rowspan="'. $count_of_expenditure_list .'" style="vertical-align: inherit">Expenditure</td>';
            }
            if ($key == 0) {
                $html[$key + 1]['td2source'] .= '<td class="tg-0lax">' . ($key + 1) . '.</td>';
            } else {
                $html[$key + 1]['td2source'] = '<td class="tg-0lax">' . ($key + 1) . '.</td>';
            }
            $html[$key + 1]['td2source'] .= '<td class="tg-0lax">' . $expense->maintenanceCostDate . '</td>';
            $html[$key + 1]['td2source'] .= '<td class="tg-0lax">' . $utility->name . ' ('. date('F, Y', strtotime($expense->maintenanceCostDate)) .')</td>';
            $html[$key + 1]['td2source'] .= '<td class="tg-0lax">'. $expense->amount .'</td>';
            $html[$key + 1]['td2source'] .= '<td class="tg-0lax"></td>';

            $outcomes[] = (int)$expense->amount;
        }

        $html['total_expen'] = '<td class="tg-0lax"></td>';
        $html['total_expen'] .= '<td class="tg-0lax"></td>';
        $html['total_expen'] .= '<td class="tg-0lax"></td>';
        $html['total_expen'] .= '<td class="tg-0lax">Total Expenditure ( '. $this_month_date .' )</td>';
        $html['total_expen'] .= '<td class="tg-0lax color-black" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);"><b>Sub Total</b></td>';
        $html['total_expen'] .= '<td class="tg-0lax"> - <b>'. array_sum($outcomes) .'</b></td>';

        if ( 0 != (array_sum($outcomes)) ) {
            $outcome = array_sum($outcomes);
            $html['tf2source'] = '<td colspan="3" class="text-right"><b>Total</b></td>';
            $html['tf2source'] .= '<td>' . $outcome . '</td>';
        } else {
            $outcome = 0;
            $html['tf2source'] = '<td colspan="3" class="text-center"><b>No Data Found</b></td>';
        }

        $html['balance'] = ((int)$income) - ((int)$outcome);

        $html['total_remaining'] = '<td class="tg-0lax" colspan="2"></td>';
        $html['total_remaining'] .= '<td class="tg-0lax color-black" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);"><b>Total Remaining</b></td>';
        $html['total_remaining'] .= '<td class="tg-0lax" colspan="2"></td>';
        $html['total_remaining'] .= '<td class="tg-0lax"><b>'. (((int)$income) - ((int)$outcome)) .'</b></td>';

        $get_bank = Bank::find(1);
        $html['balance_in_bank'] = $get_bank->amount;
        $html['bank_name'] = $get_bank->name;
        $get_petty = PettyCash::find(1);
        $html['balance_in_hand'] = $get_petty->balance;

        $html['report_of_month'] = $this_month_date;

        return response()->json(@$html);

    }


    public function reportYearlyBalancesheetSearch(Request $request) {

        $year_id = $request->year_id;
        $grouped = DB::table('maintenance_models')
            ->selectRaw('SUM(amount) AS amount,')
            ->groupByRaw('MONTH(maintenanceCostDate)')
            ->get();
/*
        $date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));

        //service charge listing

        $empsalaries = ServiceCharge::whereMonth('serviceChargeMonthYear', $date->month)
            ->whereYear('serviceChargeMonthYear', $date->year)
            ->get();

        $f = date('Y-m-d', strtotime($year_id." -1 month"));
        $prev_date = Carbon::createFromFormat('m/Y', Carbon::parse($f)->format('m/Y'));
        $is_in_month_year = RemainingBalance::get()->first();

        $incomes = array();

        $html['thsource'] = '<th>SL</th>';
        $html['thsource'] .= '<th>Flat Owner Name</th>';
        $html['thsource'] .= '<th>Date</th>';
        $html['thsource'] .= '<th>Amount(TK)</th>';
        if (!empty( $is_in_month_year ) ) {
            $html[0]['tdsource'] = '<td>1</td>';
            $html[0]['tdsource'] .= '<td colspan="2">Previous Month Balance</td>';
            $html[0]['tdsource'] .= '<td>' . $is_in_month_year->balance . '</td>';
            $incomes[] = (int)$is_in_month_year->balance;
        }
        foreach ($empsalaries as $key => $empsalarie) {

            $html[$key + 1]['tdsource'] = '<td>' . ($key + 2) . '</td>';
            $html[$key + 1]['tdsource'] .= '<td>'. $empsalarie['get_user']['name'] .'</td>';
            $html[$key + 1]['tdsource'] .= '<td>'. $empsalarie->serviceChargeDate .'</td>';
            $html[$key + 1]['tdsource'] .= '<td>' . $empsalarie->serviceChargeAmount . '</td>';
            $incomes[] = (int)$empsalarie->serviceChargeAmount;

        }
        if ( 0 != (array_sum($incomes)) ) {
            $income = array_sum($incomes);
            $html['tfsource'] = '<td colspan="3" class="text-right"><b>Total</b></td>';
            $html['tfsource'] .= '<td>' . $income . '</td>';

        } else {
            $income = 0;
            $html['tfsource'] = '<td colspan="3" class="text-center"><b>No Data Found</b></td>';
        }

        //Expense Listing

        $expenses = MaintenanceModel::whereMonth('maintenanceCostDate', $date->month)
            ->whereYear('maintenanceCostDate', $date->year)
            ->get();

        $outcomes = array();

        $html['th2source'] = '<th>SL</th>';
        $html['th2source'] .= '<th>Utility</th>';
        $html['th2source'] .= '<th>Date</th>';
        $html['th2source'] .= '<th>Description</th>';
        $html['th2source'] .= '<th>Amount(TK)</th>';

        foreach ($expenses as $key => $expense) {

            $utility = Utility::find($expense->utilityId);

            $html[$key]['td2source'] = '<td>' . ($key + 1) . '</td>';
            $html[$key]['td2source'] .= '<td>' . $utility->name . '</td>';
            $html[$key]['td2source'] .= '<td>' . $expense->maintenanceCostDate . '</td>';
            $html[$key]['td2source'] .= '<td>' . $expense->maintenanceNote . '</td>';
            $html[$key]['td2source'] .= '<td>' . $expense->amount . '</td>';
            $outcomes[] = (int)$expense->amount;
        }

        if ( 0 != (array_sum($outcomes)) ) {
            $outcome = array_sum($outcomes);
            $html['tf2source'] = '<td colspan="3" class="text-right"><b>Total</b></td>';
            $html['tf2source'] .= '<td>' . $outcome . '</td>';
        } else {
            $outcome = 0;
            $html['tf2source'] = '<td colspan="3" class="text-center"><b>No Data Found</b></td>';
        }

        $html['balance'] = ((int)$income) - ((int)$outcome);
        $get_bank = Bank::find(1);
        $html['balance_in_bank'] = $get_bank->amount;
        $html['bank_name'] = $get_bank->name;
        $get_petty = PettyCash::find(1);
        $html['balance_in_hand'] = $get_petty->balance;
        */

        $html['test'] = $year_id;
        $html['grouped'] = $grouped;
        return response()->json(@$html);

    }

    public function reportMonthlyIncomeSearch(Request $request) {

        $year_id = $request->year_id . '-02';

        $date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));

        $month_year = Carbon::parse($year_id)->format('M Y');

        $empsalaries = ServiceCharge::whereMonth('serviceChargeDate', $date->month)
            ->whereYear('serviceChargeDate', $date->year)
            ->get();
        $this_month_date = date('F, Y', strtotime($year_id));

        $html['report_of_month'] = $this_month_date;

        $charges = array();
        $due_count = array();

        $html['thsource'] = '<th>SL</th>';
        $html['thsource'] .= '<th>Flat Owner Name</th>';
        $html['thsource'] .= '<th>Floor No.</th>';
        $html['thsource'] .= '<th>Flat No.</th>';
        $html['thsource'] .= '<th>Paid Date</th>';
        //$html['thsource'] .= '<th>Amount to Pay</th>';
        $html['thsource'] .= '<th>Paid Amount</th>';
        //$html['thsource'] .= '<th>Due</th>';
        //$html['thsource'] .= '<th>Action</th>';

        foreach ($empsalaries as $key => $empsalarie) {

            $due = ($empsalarie['get_unit']['serviceCharge']) - ($empsalarie->serviceChargeAmount);

            if ($empsalarie->serviceChargeDue > 0 ){
                $reminder_button = '<a class="btn btn-rounded btn-info d-inline-flex due-money" data-text="Dear ' . $empsalarie['get_user']['name'] . ', Total due TK'. $empsalarie->serviceChargeDue .' as Service Charge for '. $month_year .', for Flat '. $empsalarie['get_unit']['name'] .'. Please pay." data-phone="' . $empsalarie['get_user']['phone'] . '" id=""><i class="d-none ti-check"></i>Remind</a>';
            } else {
                $reminder_button = '';
            }

            $html[$key]['tdsource'] = '<td>' . ($key + 1) . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie['get_user']['name'] . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie['get_floor']['name'] . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie['get_unit']['name'] . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie->serviceChargeDate . '</td>';
            //$html[$key]['tdsource'] .= '<td>' . $empsalarie['get_unit']['serviceCharge'] . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie->serviceChargeAmount . '</td>';
            //$html[$key]['tdsource'] .= '<td>' . $empsalarie->serviceChargeDue . '</td>';
            //$html[$key]['tdsource'] .= '<td>' . $reminder_button . '<a class="btn btn-rounded btn-primary show_receipt ml-2" data-servicechargeId="'. $empsalarie->id .'">Show Recipt</a><a class="btn btn-rounded btn-success ml-2 edit-servicecharge"><i class="ti-pencil-alt"></i></a> <p class="smsmessage d-none">Message Sent</p></td>';

            $charges[] = (int)$empsalarie->serviceChargeAmount;
            $due_count[] = (int)$empsalarie->serviceChargeDue;

        }
        if ( 0 != (array_sum($charges)) ) {
            //$other_cost = AccountOtherCost::whereBetween('date',[$sdate,$edate])->sum('amount');
            $html['tfsource'] = '<td colspan="5" class="text-right"><b>Total</b></td>';
            $html['tfsource'] .= '<td>' . array_sum($charges) . '</td>';
            //$html['tfsource'] .= '<td colspan="2">Total Due: ' . array_sum($due_count) . '</td>';
        } else {
            $html['tfsource'] = '<td colspan="9" class="text-center"><b>No Data Found</b></td>';
        }

        return response()->json(@$html);

    }
}
