<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Bank;
use App\Models\backend\BankTransaction;
use App\Models\backend\Floor;
use App\Models\backend\MaintenanceModel;
use App\Models\backend\PettyCash;
use App\Models\backend\RemainingBalance;
use App\Models\backend\Unit;
use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use http\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function MaintenanceView() {
        return view('backend.maintenance.view_maintenance');
    }

    public function MaintenanceAdd() {
        $data['users'] = User::where('usertype','employee')->get();
        $data['allFloorlist'] = Floor::all();
        $data['allUnitlist'] = Unit::all();
        $data['allUtilitylist'] = Utility::all();
        $data['allBanklist'] = Bank::all();

        return view('backend.maintenance.add_maintenance' , $data);
    }

    public function MaintenanceStore(Request $request) {

        //Please validation here
        $data = new MaintenanceModel();
        $data->amount = $request->amount;

        if ( !empty($request->floorId)) { $data->floorId = $request->floorId; } else { $data->floorId = 1; }
        if ( !empty($request->unitId)) { $data->unitId = $request->unitId; } else { $data->unitId = 1; }
        if ( !empty($request->userId)) { $data->userId = $request->userId; } else { $data->userId = 1; }
        $data->utilityId = $request->utilityId;

        $data->maintenanceCostDate = $request->maintenanceCostDate;
        $data->maintenanceNote = $request->maintenancenote;

        if ($request->file('maintenanceImage')) {
            $file = $request->file('maintenanceImage');
            @unlink(public_path('upload/maintenance_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/maintenance_images'),$filename);
            $data['maintenanceImage'] = $filename;
        }

        $data->save();

        // if bank - reduce from bank
        if (!empty($request->bank_id)){

            $data3 = Bank::find($request->bank_id);
            $data3->amount = ($data3->amount) - ($request->amount);
            $data3->save();

            //Transaction from bank
            $make_month = intval(mb_substr($request->maintenanceCostDate , 5 , 8));
            $make_year = intval(mb_substr($request->maintenanceCostDate , 0 , 4));

            $find_transaction = BankTransaction::whereMonth('transaction_date', $make_month)
                ->whereYear('transaction_date', $make_year)
                ->where('bank_id', $request->bank_id)
                ->first();

            if (!empty($find_transaction)) {
                $transaction = BankTransaction::find($find_transaction->id);
                $previous_balance = $transaction->balance;
                $transaction->balance = $previous_balance - $request->amount;
                $transaction->transaction_date = $request->maintenanceCostDate;
                $transaction->save();
            } else {
                $creat_transaction = new BankTransaction();
                $creat_transaction->transaction_date = $request->maintenanceCostDate;
                $creat_transaction->bank_id = $request->bank_id;
                $creat_transaction->balance = $request->amount;
                $creat_transaction->save();
            }

        }

        // if petty cash - reduce from petty cash
        if (empty($request->bank_id)){

            $previous_pretty_cash_month = intval((mb_substr($request->maintenanceCostDate , 5 , 8))) - 1;
            $previous_pretty_cash_year = intval(mb_substr($request->maintenanceCostDate , 0 , 4));

            //dd($previous_pretty_cash_month . $previous_pretty_cash_year);

            $prev_petty_cash_balance = PettyCash::whereMonth('month_year', $previous_pretty_cash_month)
                ->whereYear('month_year', $previous_pretty_cash_year)
                ->first();

            //dd($prev_petty_cash_balance);

            $now_pretty_cash_month = intval(mb_substr($request->maintenanceCostDate , 5 , 8));
            $now_pretty_cash_year = intval(mb_substr($request->maintenanceCostDate , 0 , 4));

            $now_petty_cash = PettyCash::whereMonth('month_year', $now_pretty_cash_month)
                ->whereYear('month_year', $now_pretty_cash_year)
                ->first();

            //dd($now_petty_cash);

            if (empty($now_petty_cash)) {
                if (!empty($prev_petty_cash_balance)) {
                    $data3 = new PettyCash();
                    $data3->balance = ($prev_petty_cash_balance->balance) - ($request->amount) ;
                    $data3->month_year = $request->maintenanceCostDate;
                    $data3->save();
                } else {
                    $data3 = new PettyCash();
                    $data3->balance = -($request->amount);
                    $data3->month_year = $request->maintenanceCostDate;
                    $data3->save();
                }
            } else {
                $data3 = PettyCash::find($now_petty_cash->id);
                $data3->balance = ($now_petty_cash->balance) - ($request->amount) ;
                $data3->month_year = $request->maintenanceCostDate;
                $data3->save();
            }
        }

        $prev_remaining_balance = RemainingBalance::find(2)->balance;

        $data2 = RemainingBalance::find(2);
        $data2->balance = $prev_remaining_balance - ($request->amount) ;
        $data2->month_year = $request->maintenanceCostDate;
        $data2->save();

        $notification = array(
            'message' => 'Expense Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('maintenance.add')->with($notification);

    }

    public function MaintenanceSearch(Request $request){

        $year_id = $request->year_id . '-01';
        $date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));

        $expenses = MaintenanceModel::whereMonth('maintenanceCostDate', $date->month)
            ->whereYear('maintenanceCostDate', $date->year)
            ->get();

        $charges = array();

        $html['thsource'] = '<th>SL</th>';
        $html['thsource'] .= '<th>Floor</th>';
        $html['thsource'] .= '<th>Unit</th>';
        $html['thsource'] .= '<th>Utility</th>';
        $html['thsource'] .= '<th>Date</th>';
        $html['thsource'] .= '<th>Person</th>';
        $html['thsource'] .= '<th>Receipt Image</th>';
        $html['thsource'] .= '<th>Note</th>';
        $html['thsource'] .= '<th>Amount</th>';
        $html['thsource'] .= '<th>Action</th>';

        foreach ($expenses as $key => $expense) {

            $person = User::find($expense->userId);
            $floor = Floor::find($expense->floorId);
            $unit = Unit::find($expense->unitId);
            $utility = Utility::find($expense->utilityId);

            if( !empty( $expense->maintenanceImage) ) {
               $imgURL = 'https://krishnochuraheights.com/upload/maintenance_images/' . $expense->maintenanceImage;
            } else {
               $imgURL = '';
            }

            $html[$key]['tdsource'] = '<td>' . ($key + 1) . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $floor->name . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $unit->name . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $utility->name . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $expense->maintenanceCostDate . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $person->name . '</td>';
            $html[$key]['tdsource'] .= '<td><img id="showImage" src="'. $imgURL .'" style="width: 100px; width: 100px; border: 1px solid #000000;"></td>';
            $html[$key]['tdsource'] .= '<td>' . $expense->maintenanceNote . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $expense->amount . '</td>';
            $html[$key]['tdsource'] .= '<td><a href="' . url("/maintenance/detail/{$expense->id}") . '" class="btn btn-success mr-2">Details</a><a href="' . url("/maintenance/detail/{$expense->id}") . '" class="btn btn-info mr-2">Edit</a><a href="' . url("/maintenance/detail/{$expense->id}") . '" class="btn btn-danger mr-2">delete</a></td>';
            $charges[] = (int)$expense->amount;

        }
        if ( 0 != (array_sum($charges)) ) {
            //$other_cost = AccountOtherCost::whereBetween('date',[$sdate,$edate])->sum('amount');
            $html['tfsource'] = '<td colspan="8" class="text-right"><b>Total</b></td>';
            $html['tfsource'] .= '<td>' . array_sum($charges) . '</td>';
        } else {
            $html['tfsource'] = '<td colspan="9" class="text-center"><b>No Data Found</b></td>';
        }

        return response()->json(@$html);

    }// end method

    public function MaintenanceSalary() {

        $now_monthyear = date("Y-m");
        $date = Carbon::createFromFormat('m/Y', Carbon::parse($now_monthyear)->format('m/Y'));
        $data['allEmployee'] = User::where('usertype','employee')->where('status','active')->get();
        $data['total_salary'] = User::where('usertype','employee')->sum('salary');
        $data['all_matched'] = MaintenanceModel::whereMonth('maintenanceCostDate', $date->month)
            ->whereYear('maintenanceCostDate', $date->year)
            ->where('utilityId','12')
            ->get();
        return view('backend.maintenance.salary_maintenance' , $data);
    }

    public function MaintenanceSalaryDisburse(Request $request){

        /*$find_previous_data = MaintenanceModel::whereMonth('maintenanceCostDate', $monthyear->month)
            ->whereYear('maintenanceCostDate', $monthyear->year)
            ->first();
        if (empty($find_previous_data)) {*/

            $total_salary = $request->total_salary;

            $date = Carbon::createFromFormat('Y-m-d', Carbon::parse($request->salaryMonthName)->format('Y-m-d'));

            // build date
            $data = new MaintenanceModel();
            $data->amount = $total_salary;
            $data->userId = Auth::user()->id;
            $data->unitId = 1;
            $data->floorId = 1;
            $data->utilityId = 12;
            $data->maintenanceCostDate = $date;
            $data->maintenanceNote = $request->salaryNote;

            $data->save();

            if (true == ($data->save())) {

                // if petty cash - reduce from petty cash
                if (empty($request->bank_id)){

                    $previous_pretty_cash_month = intval((mb_substr($date , 5 , 8))) - 1;
                    $previous_pretty_cash_year = intval(mb_substr($date , 0 , 4));

                    //dd($previous_pretty_cash_month . $previous_pretty_cash_year);

                    $prev_petty_cash_balance = PettyCash::whereMonth('month_year', $previous_pretty_cash_month)
                        ->whereYear('month_year', $previous_pretty_cash_year)
                        ->first();

                    //dd($prev_petty_cash_balance);

                    $now_pretty_cash_month = intval(mb_substr($date , 5 , 8));
                    $now_pretty_cash_year = intval(mb_substr($date , 0 , 4));

                    $now_petty_cash = PettyCash::whereMonth('month_year', $now_pretty_cash_month)
                        ->whereYear('month_year', $now_pretty_cash_year)
                        ->first();

                    //dd($now_petty_cash);

                    if (empty($now_petty_cash)) {
                        if (!empty($prev_petty_cash_balance)) {
                            $data3 = new PettyCash();
                            $data3->balance = ($prev_petty_cash_balance->balance) - ($total_salary);
                            $data3->month_year = $date;
                            $data3->save();
                        } else {
                            $data3 = new PettyCash();
                            $data3->balance = -($total_salary);
                            $data3->month_year = $date;
                            $data3->save();
                        }
                    } else {
                        $data3 = PettyCash::find($now_petty_cash->id);
                        $data3->balance = ($now_petty_cash->balance) - ($total_salary) ;
                        $data3->month_year = $date;
                        $data3->save();
                    }

                }

                $prev_remaining_balance = RemainingBalance::find(2)->balance;

                $data2 = RemainingBalance::find(2);
                $data2->balance = $prev_remaining_balance - ($total_salary) ;
                $data2->month_year = $date;
                $data2->save();

                $html = 'Salary Disbursed Successfully ';
            } else {
                $html = 'Some Problem Happened';
            }


        /*} else {
            $html = 'Salary already disbursed for ' . $monthyear;
        }*/

        return response()->json(@$html);

    }

    public function MaintenanceDetail( Request $request , $id ) {

        $data['thatMaintenanceDetail'] = MaintenanceModel::find( $id );
        $data['users'] = User::where('usertype','employee')->get();
        $data['allFloorlist'] = Floor::all();
        $data['allUnitlist'] = Unit::all();
        $data['allUtilitylist'] = Utility::all();
        $data['allBanklist'] = Bank::all();

        return view('backend.maintenance.detail_maintenance' , $data);
    }


    public function MaintenanceUpdate( Request $request , $id ) {

        //Please validation here
        $data = MaintenanceModel::find( $id );
        $previous_amount = $data->amount;
        $previous_date = $data->maintenanceCostDate;
        $data->amount = $request->amount;
        $data->maintenanceNote = $request->maintenancenote;

        //dd($previous_date);

        if ( !empty($request->floorId)) { $data->floorId = $request->floorId; } else { $data->floorId = 1; }
        if ( !empty($request->unitId)) { $data->unitId = $request->unitId; } else { $data->unitId = 1; }
        if ( !empty($request->userId)) { $data->userId = $request->userId; } else { $data->userId = 1; }
        $data->utilityId = $request->utilityId;

        // কোন মাসে নতুন expenditure add হচ্ছে
        $data->maintenanceCostDate = $request->maintenanceCostDate;


        // ফাইন্ড the নতুন date + year , কারন বের করতে হবে নতুন date কি বর্তমান date থেকে বড় নাকি ছোট , তাতে কোথা থেকে petty cash database change হবে তা বের করা হবে।
        $new_month_to_move = intval(mb_substr($request->maintenanceCostDate , 5 , 8));
        $new_year_to_move = intval(mb_substr($request->maintenanceCostDate , 0 , 4));
        $total_number_of_new_year_month = $new_month_to_move + $new_year_to_move;

        //dd($new_month_to_move);

        if ($request->file('maintenanceImage')) {
            $file = $request->file('maintenanceImage');
            @unlink(public_path('upload/maintenance_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/maintenance_images'),$filename);
            $data['maintenanceImage'] = $filename;
        }

        $data->save();

        // if petty cash - reduce from petty cash

        $now_pretty_cash_month = intval(mb_substr($previous_date , 5 , 8));
        $now_pretty_cash_year = intval(mb_substr($previous_date , 0 , 4));
        $total_number_of_old_year_month = $now_pretty_cash_month + $now_pretty_cash_year;

        // এইখানে চলতি মাসের Petty Cash বের করা হয়েছে - row এর সব data
        $now_petty_cash = PettyCash::whereMonth('month_year', $now_pretty_cash_month)
            ->whereYear('month_year', $now_pretty_cash_year)
            ->first();

        // বের করতে হবে নতুন মাসের ID -- done
        $new_petty_cash_month_all_data = PettyCash::whereMonth('month_year', $new_month_to_move)
            ->whereYear('month_year', $new_year_to_move)
            ->first();

        // query কিভাবে চলবে তা জন্য if else
        // যদি নতুন date পুরাতন date হতে বড় হয় - মানে উপর থেকে নিচে পাঠানো হল
        if ( $total_number_of_new_year_month > $total_number_of_old_year_month ) {
            // MOST CRITICAL PART - যদি পরিবর্তন করা মাসের পরে বা আগে কোন মাসের Petty থাকে সেগুলো array তে আনার জন্য QUERY
            // -- কারন তাহলে ঐ মাসগুলোতেও balance পরিবর্তন করতে হবে

            // বর্তমান মাসের petty cash এর ID
            $old_petty_cash_month_id = $now_petty_cash->id;
            // নতুন মাসের ID

            // বের করতে হবে নেক্সট কতো গুলা মাস আছে ( বা id আছে ) -- done
            $next_petty_cash_months_list = PettyCash::where( 'id' , '>=' , $now_petty_cash->id )->get();

            // আগের amount এবং এখনকার input amount এর পার্থক্য কত, বের করা হলো
            $final_update = $previous_amount - $request->amount;

            foreach ($next_petty_cash_months_list as $next_petty_single) {

                if (($next_petty_single->id) == $old_petty_cash_month_id ) {
                    // যদি পুরাতন মাসের সমান হয় - তাহলে তা বাড়বে মানে যোগ হবে ------------ লজিক এর মায়েরে বাপ
                    $data3 = PettyCash::find($next_petty_single->id);
                    $data3->balance = $data3->balance + $request->amount;
                    $data3->save();
                } else if ((($next_petty_single->id) > ($old_petty_cash_month_id)) && (($next_petty_single->id) < ($new_petty_cash_month_all_data->id)) ) {

                    $data3 = PettyCash::find($next_petty_single->id);
                    $data3->balance = $data3->balance + $request->amount;
                    $data3->save();
                } else if ((($next_petty_single->id) == ($new_petty_cash_month_all_data->id)) ) {

                    $data3 = PettyCash::find($next_petty_single->id);
                    $data3->balance = $data3->balance - $request->amount;
                    $data3->save();

                } else {
                    // নতুন মাসের petty cash থেকে বিয়োগ
                    // পরবর্তী মাস গুলো হতে বিয়োগ
                    $data3 = PettyCash::find($next_petty_single->id);
                    $data3->balance = $data3->balance - $request->amount ;
                    $data3->save();
                }

            }

        // যদি নতুন date পুরাতন date হতে বড় হয় - মানে নিচের থেকে উপরে পাঠানো হল
        } else if ( $total_number_of_new_year_month < $total_number_of_old_year_month ) {

            // বের করতে হবে পুরাতন মাসের ID -- done
            $old_petty_cash_month_id = $now_petty_cash->id;

            // বের করতে হবে নেক্সট কতো গুলা মাস আছে ( বা id আছে ) -- done
            $next_petty_cash_months_list = PettyCash::where( 'id' , '>=' , $new_petty_cash_month_all_data->id )->get();

            // আগের amount এবং এখনকার input amount এর পার্থক্য কত, বের করা হলো
            $final_update = $previous_amount - $request->amount;

            foreach ($next_petty_cash_months_list as $next_petty_single) {

                if (($next_petty_single->id) == $old_petty_cash_month_id ) {
                    // এবং শুধুমাত্র চলতি মাসেরটা যা আছে তাই থাকবে, তবে যদি কম বেশি হয় তাহলে পার্থক্য বের করে নিতে হবে
                    $data3 = PettyCash::find($next_petty_single->id);
                    $data3->balance = $data3->balance + $final_update;
                    $data3->save();
                } else {
                    // নতুন মাসের petty cash থেকে বিয়োগ
                    // পরবর্তী মাস গুলো হতে বিয়োগ
                    $data3 = PettyCash::find($next_petty_single->id);
                    $data3->balance = $data3->balance - $request->amount ;
                    $data3->save();
                }

            }

        // যদি নতুন date পুরাতন date সমান হয়
        } else if ( $total_number_of_new_year_month == $total_number_of_old_year_month ) {

            // যদি same মাসের change হয় দেখতে হবে amount বেশি না কম then if else use করতে হবে
            if ( ($request->amount) > $previous_amount ) {

                $now_petty_cash_months_list = PettyCash::where( 'id' , '>=' , $now_petty_cash->id )->get();

                $final_update = $previous_amount - $request->amount;
                foreach ($now_petty_cash_months_list as $next_petty_single) {
                    $data3 = PettyCash::find($next_petty_single->id);
                    $data3->balance = $data3->balance + $final_update;
                    $data3->save();
                }

            } else if ( ($request->amount) < $previous_amount ) {
                $now_petty_cash_months_list = PettyCash::where( 'id' , '>=' , $now_petty_cash->id )->get();

                $final_update = $previous_amount - $request->amount;
                foreach ($now_petty_cash_months_list as $next_petty_single) {
                    $data3 = PettyCash::find($next_petty_single->id);
                    $data3->balance = $data3->balance + $final_update;
                    $data3->save();
                }

            } else if ( ($request->amount) == $previous_amount ) {
                $message_ready = 'Nothing To Change';
            }

        }


        $final_update = $previous_amount - $request->amount;
        // Main Remaining Balance এ Change -
        $prev_remaining_balance = RemainingBalance::find(2)->balance;

        $data2 = RemainingBalance::find(2);
        $data2->balance = $prev_remaining_balance + $final_update ;
        $data2->month_year = $request->maintenanceCostDate;
        $data2->save();


        $notification = array(
            'message' => 'Expense Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('maintenance.view')->with($notification);
    }

    public function MaintenanceDelete( Request $request , $id ) {

        //Please validation here
        $data = MaintenanceModel::find( $id );
        $previous_amount = $data->amount;
        $previous_date = $data->maintenanceCostDate;
        $data->delete();

        //dd($previous_date);

        // if petty cash - reduce from petty cash
        if (empty($request->bank_id)){

            $now_pretty_cash_month = intval(mb_substr($previous_date , 5 , 8));
            $now_pretty_cash_year = intval(mb_substr($previous_date , 0 , 4));

            $now_petty_cash = PettyCash::whereMonth('month_year', $now_pretty_cash_month)
                ->whereYear('month_year', $now_pretty_cash_year)
                ->first();

            $final_update = $previous_amount;

            //dd($now_petty_cash);

            $next_petty_cash = PettyCash::where( 'id' , '>=' , $now_petty_cash->id )->get();

            //dd($next_petty_cash);
            foreach ($next_petty_cash as $next_petty_single) {
                $data3 = PettyCash::find($next_petty_single->id);
                $data3->balance = $data3->balance + $final_update ;
                $data3->save();
            }


            $prev_remaining_balance = RemainingBalance::find(2)->balance;
            $data2 = RemainingBalance::find(2);
            $data2->balance = $prev_remaining_balance + $final_update ;
            $data2->month_year = $data->maintenanceCostDate;
            $data2->save();
        }

        $notification = array(
            'message' => 'Expense Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('maintenance.view')->with($notification);
    }

}
