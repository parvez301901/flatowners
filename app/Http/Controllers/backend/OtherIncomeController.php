<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\OtherIncome;
use App\Models\backend\PettyCash;
use App\Models\backend\RemainingBalance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OtherIncomeController extends Controller {

    // Other Income add view
    public function add_other_income() {
        return view('backend.other_income.add_other_income' );
    }
    // Other Income Store
    public function store_other_income(Request $request) {
        $data = new OtherIncome();

        $data->other_income_month_year = $request->other_income_month_year . '-02';
        $data->other_income_amount = $request->other_income_amount;
        $data->other_income_detail = $request->other_income_detail;
        $data->other_income_date = $request->other_income_date;

        $data->save();

        $notification = array(
            'message' => 'Other Income Added Successfully',
            'alert-type' => 'success'
        );

        // add this money to the petty cash

        $previous_pretty_cash_month = intval((mb_substr($request->other_income_date , 5 , 8))) - 1;
        $previous_pretty_cash_year = intval(mb_substr($request->other_income_date , 0 , 4));

        //dd($previous_pretty_cash_month . $previous_pretty_cash_year);

        $prev_petty_cash_balance = PettyCash::whereMonth('month_year', $previous_pretty_cash_month)
            ->whereYear('month_year', $previous_pretty_cash_year)
            ->first();

        //dd($prev_petty_cash_balance);

        $now_pretty_cash_month = intval(mb_substr($request->other_income_date , 5 , 8));
        $now_pretty_cash_year = intval(mb_substr($request->other_income_date , 0 , 4));

        $now_petty_cash = PettyCash::whereMonth('month_year', $now_pretty_cash_month)
            ->whereYear('month_year', $now_pretty_cash_year)
            ->first();

        //dd($now_petty_cash);

        if (empty($now_petty_cash)) {
            if (!empty($prev_petty_cash_balance)) {
                $data3 = new PettyCash();
                $data3->balance = ($request->other_income_amount) + $prev_petty_cash_balance->balance;
                $data3->month_year = $request->other_income_date;
                $data3->save();

            } else {
                $data3 = new PettyCash();
                $data3->balance = ($request->other_income_amount);
                $data3->month_year = $request->other_income_date;
                $data3->save();
            }
        } else {
            $data3 = PettyCash::find($now_petty_cash->id);
            $data3->balance = ($request->other_income_amount) + $now_petty_cash->balance ;
            $data3->month_year = $request->other_income_date;
            $data3->save();

            $next_petty_cash = PettyCash::where( 'id' , '>' , $now_petty_cash->id )->get();

            //dd($next_petty_cash);
            if (!empty($next_petty_cash)) {
                foreach ($next_petty_cash as $next_petty_single) {
                    $data4 = PettyCash::find($next_petty_single->id);
                    $data4->balance = $data4->balance + $request->other_income_amount;
                    $data4->save();
                }
            }
            $prev_remaining_balance = RemainingBalance::find(2)->balance;

            $data2 = RemainingBalance::find(2);
            $data2->balance = ($request->other_income_amount) + $prev_remaining_balance;
            $data2->month_year = $request->other_income_date;
            $data2->save();
        }

        return redirect()->route('otherincome.add' )->with($notification);
    }
}
