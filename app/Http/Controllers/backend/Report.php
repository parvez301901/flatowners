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

        /*service charge listing*/

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

        /*Expense Listing*/

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
}
