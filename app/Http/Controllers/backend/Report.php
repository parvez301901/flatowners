<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Bank;
use App\Models\backend\BankTransaction;
use App\Models\backend\MaintenanceModel;
use App\Models\backend\OtherIncome;
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
        /*$data['incomes'] = ServiceCharge::whereMonth('serviceChargeDate', '4')
            ->whereYear('serviceChargeDate', '2022')
            ->sum('serviceChargeAmount');
        */

        $data['incomes'] = ServiceCharge::selectRaw('COUNT(*) as count, YEAR(serviceChargeDate) year, MONTH(serviceChargeDate) month')
            ->groupBy('year', 'month')
            ->get();

        return view('backend.report.view_yearly_report', $data);
    }

    public function reportYearlyBalancesheetSearch(Request $request) {

        $year_id = $request->year_id;

        $html['thsource'] = '<th>SL</th>';
        $html['thsource'] .= '<th class="tg-0pky">Month\'s</th>';
        $html['thsource'] .= '<th class="tg-0pky border-right-color-white" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);">S. Charge</th>';
        $html['thsource'] .= '<th class="tg-0pky border-right-color-white" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);">Other Income</th>';
        $html['thsource'] .= '<th class="tg-0pky">Sal./Bon.</th>';
        $html['thsource'] .= '<th class="tg-0pky">Lift</th>';
        $html['thsource'] .= '<th class="tg-0pky">Electricity</th>';
        $html['thsource'] .= '<th class="tg-0pky">Wasa</th>';
        $html['thsource'] .= '<th class="tg-0pky">Gas</th>';
        $html['thsource'] .= '<th class="tg-0pky">Others</th>';
        $html['thsource'] .= '<th class="tg-0pky">Extin.</th>';
        $html['thsource'] .= '<th class="tg-0pky">Gen. Fuel</th>';
        $html['thsource'] .= '<th class="tg-0pky">Gen.M</th>';
        $html['thsource'] .= '<th class="tg-0pky">PABX/CCTV</th>';
        $html['thsource'] .= '<th class="tg-0pky" style="background:linear-gradient(45deg, #f70f0f, #4415f7);">- Total Exp.</th>';
        $html['thsource'] .= '<th class="tg-0pky" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);">+ Petty Cash</th>';
        $html['thsource'] .= '<th class="tg-0pky" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);">+ In Bank</th>';
        $html['thsource'] .= '<th class="tg-0pky" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);">G.Total</th>';


        for ($month_number = 1; $month_number <= 12; $month_number++) {

            $incomes = ServiceCharge::whereMonth('serviceChargeDate', $month_number)
                ->whereYear('serviceChargeDate', $year_id)
                ->sum('serviceChargeAmount');
            $expenses = MaintenanceModel::whereMonth('maintenanceCostDate', $month_number)
                ->whereYear('maintenanceCostDate', $year_id)
                ->get();

            $totalOtherIncomesByMonth = array();
            $otherIncomesbymonths = OtherIncome::whereMonth('other_income_date', $month_number)
                ->whereYear('other_income_date', $year_id)
                ->sum('other_income_amount');

            $salary_expense = $lift = $electricity = $wasa = $gas = $fire = $fuel = $genmain = $pabx = $total_expense = $others = array();


            // নতুন খরচের খাতা ( expense head ) add হলে নিচে সেটা ID দিয়ে যোগ করতে হবে like

            //if (($expense->utilityId) == 17) { $others[] = $expense->amount; } else { $others[] = 0; }
            //if (($expense->utilityId) == 24) { $others[] = $expense->amount; } else { $others[] = 0; }
            // এখানে নতুন utility ID add করে others এ ঢুকানো হয়েছে

            if ( !empty($expenses) ) {
                foreach ($expenses as $expense) {
                    if (($expense->utilityId) == 12) { $salary_expense[] = $expense->amount; } else { $salary_expense[] = 0; }
                    if (($expense->utilityId) == 15) { $lift[] = $expense->amount; } else { $lift[] = 0; }
                    if (($expense->utilityId) == 9) { $electricity[] = $expense->amount; } else { $electricity[] = 0; }
                    if (($expense->utilityId) == 1) { $gas[] = $expense->amount; } else { $gas[] = 0; }
                    if (($expense->utilityId) == 10) { $wasa[] = $expense->amount; } else { $wasa[] = 0; }
                    if (($expense->utilityId) == 17) { $others[] = $expense->amount; } else { $others[] = 0; }
                    if (($expense->utilityId) == 24) { $others[] = $expense->amount; } else { $others[] = 0; }
                    if (($expense->utilityId) == 21) { $fire[] = $expense->amount; } else { $fire[] = 0; }
                    if (($expense->utilityId) == 16) { $fuel[] = $expense->amount; } else { $fuel[] = 0; }
                    if (($expense->utilityId) == 22) { $genmain[] = $expense->amount; } else { $genmain[] = 0; }
                    if (($expense->utilityId) == 18) { $pabx[] = $expense->amount; } else { $pabx[] = 0; }
                    $total_expense[] = $expense->amount;
                }
            } else {
                $salary_expense[] = 0; $lift[] = 0; $electricity[] = 0; $wasa[] = 0; $others[] = 0; $fire[] = 0; $fuel[] = 0; $genmain[] = 0; $pabx[] = 0;
            }

            if ( $incomes > 0 ) {



                if (($month_number == 3) && ($year_id == 2022)) {
                    $previous_month_balance_final = RemainingBalance::get()->first()->balance;
                    $only_petty_cash = RemainingBalance::get()->first()->balance;
                } else {
                    $previous_pretty_cash_month = $month_number;
                    $previous_pretty_cash_year = $year_id;
                    $make_full_date = $year_id.'-'.$month_number.'-02';

                    $prev_petty_cash_balance = PettyCash::whereMonth('month_year', $previous_pretty_cash_month)
                        ->whereYear('month_year', $previous_pretty_cash_year)
                        ->first();

                    $find_transaction = BankTransaction::whereMonth('transaction_date', $previous_pretty_cash_month)
                        ->whereYear('transaction_date', $previous_pretty_cash_year)
                        ->where('bank_id', 1)
                        ->first();

                    if (!empty($find_transaction)) {
                        $balance_in_bank = $find_transaction->balance;
                    } else {
                        $find_bank_cash = BankTransaction::all();
                        $got_bank_cash = collect($find_bank_cash)->last();
                        $find_transaction_1 = $got_bank_cash->balance;
                        $find_transaction_1_date = $got_bank_cash->transaction_date;

                        $date1  = strtotime($make_full_date);
                        $date2  = strtotime($find_transaction_1_date);
                        if($date1 > ($date2) ) {
                            $balance_in_bank = $find_transaction_1;
                        } else {
                            $balance_in_bank = 0;
                        }

                    }

                    if (!empty($prev_petty_cash_balance)) {
                        $previous_month_balance_final = ($prev_petty_cash_balance->balance) + $balance_in_bank;
                        $only_petty_cash = $prev_petty_cash_balance->balance;

                    } else {
                        $find = PettyCash::all();
                        $got_that = collect($find)->last();
                        $find_petty_cash = $got_that->balance;

                        $find_bank_cash = BankTransaction::all();
                        $got_bank_cash = collect($find_bank_cash)->last();
                        $last_balance_in_bank = $got_bank_cash->balance;
                        $only_petty_cash = $find_petty_cash;
                        $previous_month_balance_final = $find_petty_cash + $last_balance_in_bank;
                    }
                }

            } else {
                if (($month_number == 3) && ($year_id == 2022)) {
                    $previous_month_balance_final = RemainingBalance::get()->first()->balance;
                    $only_petty_cash = RemainingBalance::get()->first()->balance;
                } else {
                    $previous_month_balance_final = $only_petty_cash = 0;
                }

                $extra_income = '0';
                $balance_in_bank = 0;
            }
            /*
            $previous_pretty_cash_month = $month_number;
            $previous_pretty_cash_year = $year_id;
            $find_transaction = BankTransaction::whereMonth('transaction_date', $previous_pretty_cash_month)
                ->whereYear('transaction_date', $previous_pretty_cash_year)
                ->where('bank_id', 1)
                ->first();

            if (!empty($find_transaction)) {
                $balance_in_bank = $find_transaction->balance;
            } else {

                $find_bank_cash = BankTransaction::all();
                $got_bank_cash = collect($find_bank_cash)->last();
                $find_transaction_1 = $got_bank_cash->balance;
                if (!empty($find_transaction_1)) {
                    $balance_in_bank = $find_transaction_1;
                } else {
                    $balance_in_bank = 0;
                }

            }
            */
            $monthName = date('F', mktime(0, 0, 0, $month_number, 10));

            $html[$month_number + 1]['tdsource'] = '<td class="tg-0pky">' . $month_number  . '. </td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">' . $monthName . ' \''.  substr( $year_id, -2) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky border-right-color-white"> '. $incomes .' </td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky border-right-color-white">'. $otherIncomesbymonths .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($salary_expense) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($lift) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($electricity) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($wasa) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($gas) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($others) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($fire) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($fuel) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($genmain) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($pabx) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. array_sum($total_expense) .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. $only_petty_cash .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. $balance_in_bank .'</td>';
            $html[$month_number + 1]['tdsource'] .= '<td class="tg-0pky">'. $previous_month_balance_final .'</td>';
        }
        $html['test'] = $year_id;
        return response()->json(@$html);

    }

    public function reportMonthlyBalancesheetSearch(Request $request) {

        $year_id = $request->year_id;

        $pure_month = mb_substr($request->year_id , 5);
        $pure_year = mb_substr($request->year_id , 0, 4);

        //dd($pure_month . ' - ' . $pure_year);

       //$formated_date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));
        $f = date('F, Y', strtotime($year_id." -1 month"));

        $this_month_date = date('F, Y', strtotime($year_id));

        $previous_pure_month = $pure_month - 1;

        $empsalaries = ServiceCharge::whereMonth('serviceChargeDate', $pure_month)
            ->whereYear('serviceChargeDate', $pure_year)
            ->get();

        $incomes = array();
        $servicecharge = array();

        if( ($pure_month == 4) && ($pure_year == 2022) ) {
            $previous_month_balance_final = RemainingBalance::get()->first()->balance;
        } else {
            /* GET PREVIOUS MONTH (INCOME) & (EXPENSE) */

            /*

            $previous_month_income = ServiceCharge::whereMonth('serviceChargeDate', $previous_pure_month)
                ->whereYear('serviceChargeDate', $pure_year)
                ->sum('serviceChargeAmount');

            $previous_month_expense = MaintenanceModel::whereMonth('maintenanceCostDate', $previous_pure_month)
                ->whereYear('maintenanceCostDate', $pure_year)
                ->sum('amount');

            $starting_balance = RemainingBalance::get()->first()->balance;
            $previous_month_balance_final = ($starting_balance + $previous_month_income) - $previous_month_expense;

            */

            /* GET BANK BALANCE & PREVIOUS MONTH PETTY CASH */

            $previous_pretty_cash_month = $pure_month - 1;
            $previous_pretty_cash_year = $pure_year;

            $prev_petty_cash_balance = PettyCash::whereMonth('month_year', $previous_pretty_cash_month)
                ->whereYear('month_year', $previous_pretty_cash_year)
                ->first();

            $find_transaction = BankTransaction::whereMonth('transaction_date', $previous_pretty_cash_month)
                ->whereYear('transaction_date', $previous_pretty_cash_year)
                ->where('bank_id', 1)
                ->first();

            if (!empty($find_transaction)) {
                $balance_in_bank = $find_transaction->balance;
            } else {
                $balance_in_bank = 0;
            }

            if ( !empty($prev_petty_cash_balance) ) {
                $previous_month_balance_final = ($prev_petty_cash_balance->balance) + $balance_in_bank;
            } else {
                $previous_month_balance_final = 0;
                /*
                $find = PettyCash::all();
                $got_that = collect($find)->last();
                $find_petty_cash = $got_that->balance;

                $find_bank_cash = BankTransaction::all();
                $got_bank_cash = collect($find_bank_cash)->last();
                $last_balance_in_bank = $got_bank_cash->balance;
                $previous_month_balance_final = $find_petty_cash + $last_balance_in_bank;*/
                //$previous_month_balance_final = $find_petty_cash + $last_balance_in_bank;
            }
        }

        $incomes[] = (int)$previous_month_balance_final;

        $html['thsource'] = '<th class="tg-0lax text-center tg-bold">Category</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">SL no</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">Date</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">Description</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">Amount</th>';
        $html['thsource'] .= '<th class="tg-0lax text-center tg-bold">Balance</th>';

        $html['previousBalance'] = '<td class="tg-0lax" rowspan="3" style="vertical-align: inherit">Income</td>';
        $html['previousBalance'] .= '<td class="tg-0lax"></td>';
        $html['previousBalance'] .= '<td class="tg-0lax">f'. $f .'</td>';
        $html['previousBalance'] .= '<td class="tg-0lax">Previous Month Balance</td>';
        $html['previousBalance'] .= '<td class="tg-0lax">'. $previous_month_balance_final . '</td>';
        $html['previousBalance'] .= '<td class="tg-0lax"></td>';

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

        $totalOtherIncomesByMonth = array();
        $otherIncomesbymonths = OtherIncome::whereMonth('other_income_date', $pure_month)
            ->whereYear('other_income_date', $pure_year)
            ->get();

        if (!empty($otherIncomesbymonths)) {
            foreach ($otherIncomesbymonths as $key => $otherIncomesbymonth) {
                $incomes[] = (int)$otherIncomesbymonth->other_income_amount;
                $totalOtherIncomesByMonth[] = (int)$otherIncomesbymonth->other_income_amount;
            }

            $total_other_income = array_sum($totalOtherIncomesByMonth);

            $html['otherIncome'] = '<td class="tg-0lax"></td>';
            $html['otherIncome'] .= '<td class="tg-0lax">' . $this_month_date . '</td>';
            $html['otherIncome'] .= '<td class="tg-0lax">Total Other Income collection ( ' . $this_month_date . ' )</td>';
            $html['otherIncome'] .= '<td class="tg-0lax">' . $total_other_income . '</td>';
            $html['otherIncome'] .= '<td class="tg-0lax"></td>';

        } else {
            $total_other_income = 0;
            $html['otherIncome'] = '<td class="tg-0lax"></td>';
            $html['otherIncome'] .= '<td class="tg-0lax">' . $this_month_date . '</td>';
            $html['otherIncome'] .= '<td class="tg-0lax">Total Other Income collection ( ' . $this_month_date . ' )</td>';
            $html['otherIncome'] .= '<td class="tg-0lax">' . $total_other_income . '</td>';
            $html['otherIncome'] .= '<td class="tg-0lax"></td>';
        }

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

        $expenses = MaintenanceModel::whereMonth('maintenanceCostDate', $pure_month)
            ->whereYear('maintenanceCostDate', $pure_year)
            ->get();

        $outcomes = array();

        $count_of_expenditure_list = count($expenses);

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
            $html[$key + 1]['td2source'] .= '<td class="tg-0lax">' . $utility->name . ' ( ' . $expense->maintenanceNote .' ) </td>';
            $html[$key + 1]['td2source'] .= '<td class="tg-0lax">'. $expense->amount .'</td>';
            $html[$key + 1]['td2source'] .= '<td class="tg-0lax"></td>';

            $outcomes[] = (int)$expense->amount;
        }

        $html['total_expen'] = '<td class="tg-0lax"></td>';
        $html['total_expen'] .= '<td class="tg-0lax"></td>';
        $html['total_expen'] .= '<td class="tg-0lax"></td>';
        $html['total_expen'] .= '<td class="tg-0lax">Total Expenditure ( '. $this_month_date .' )</td>';
        $html['total_expen'] .= '<td class="tg-0lax color-black" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);"><b>Sub Total</b></td>';
        $html['total_expen'] .= '<td class="tg-0lax"> <b>'. array_sum($outcomes) .'</b></td>';

        if ( 0 != (array_sum($outcomes)) ) {
            $outcome = array_sum($outcomes);
            $html['tf2source'] = '<td colspan="3" class="text-right"><b>Total</b></td>';
            $html['tf2source'] .= '<td>' . $outcome . '</td>';
        } else {
            $outcome = 0;
            $html['tf2source'] = '<td colspan="3" class="text-center"><b>No Data Found</b></td>';
        }

        $previous_pretty_cash_month = $pure_month;
        $previous_pretty_cash_year = $pure_year;
        $find_transaction = BankTransaction::whereMonth('transaction_date', $previous_pretty_cash_month)
            ->whereYear('transaction_date', $previous_pretty_cash_year)
            ->where('bank_id', 1)
            ->first();

        if (!empty($find_transaction)) {
            $bank_balance_for_the_month = $find_transaction->balance;
            $html['balance_in_bank'] = $find_transaction->balance;
        } else {

            $find_bank_cash = BankTransaction::all();
            $got_bank_cash = collect($find_bank_cash)->last();
            $last_balance_in_bank = $got_bank_cash->balance;

            if (!empty($last_balance_in_bank)) {
                $html['balance_in_bank'] = $last_balance_in_bank;
                $bank_balance_for_the_month = $last_balance_in_bank;
            } else {
                $html['balance_in_bank'] = 0;
                $bank_balance_for_the_month = 0;
            }
        }

        $html['balance'] = ((int)$income) - ((int)$outcome);

        $html['total_remaining'] = '<td class="tg-0lax" colspan="2"></td>';
        $html['total_remaining'] .= '<td class="tg-0lax color-black" style="background:linear-gradient(45deg, #0F5EF7, #7a15f7);"><b>Total Remaining</b></td>';
        $html['total_remaining'] .= '<td class="tg-0lax" colspan="2">( Total Income - Total Expenditure ) </td>';
        $html['total_remaining'] .= '<td class="tg-0lax"><b>'. (((int)$income) - ((int)$outcome) + ((int)$bank_balance_for_the_month) ) .'</b></td>';
        //$html['total_remaining'] .= '<td class="tg-0lax"><b>'. (((int)$income) - ((int)$outcome) ) .'</b></td>';

/*
        $pure_month = mb_substr($request->year_id , 6);
        $pure_year = mb_substr($request->year_id , 0, 4);

        $find_this_month_bank_cash = BankTransaction::whereMonth('transaction_date', $pure_month)
            ->whereYear('transaction_date', $pure_year)
            ->where('bank_id', 1)
            ->first();

        if (!empty($find_this_month_bank_cash)) {
            $html['balance_in_bank'] = $find_this_month_bank_cash->balance;
        } else {
            $html['balance_in_bank'] = 0;
        }
        */
        $html['bank_name'] = Bank::find(1)->name;

        $now_petty_cash = PettyCash::whereMonth('month_year', $pure_month)
            ->whereYear('month_year', $pure_year)
            ->first();

        if (!empty($now_petty_cash)) {
            $html['balance_in_hand'] = $now_petty_cash->balance;
        } else {
            $f = PettyCash::all();
            $g = collect($f)->last();
            $html['balance_in_hand'] = $g->balance;
        }

        $html['report_of_month'] = $this_month_date;

        return response()->json(@$html);

    }

    public function reportMonthlyIncomeSearch(Request $request) {

        $year_id = $request->year_id;

        //dd($year_id);

        $pure_month = mb_substr($request->year_id , 5);
        $pure_year = mb_substr($request->year_id , 0, 4);

        $date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));

        $month_year = Carbon::parse($year_id)->format('M Y');

        $empsalaries = ServiceCharge::whereMonth('serviceChargeDate', $pure_month)
            ->whereYear('serviceChargeDate', $pure_year)
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
