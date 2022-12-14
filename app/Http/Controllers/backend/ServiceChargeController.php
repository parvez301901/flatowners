<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Bank;
use App\Models\backend\BankTransaction;
use App\Models\backend\Floor;
use App\Models\backend\PettyCash;
use App\Models\backend\RemainingBalance;
use App\Models\backend\Unit;
use App\Models\ServiceCharge;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Rakibhstu\Banglanumber\NumberToBangla;

class ServiceChargeController extends Controller {

    public function ServiceChargeView() {
        $data['allUserData'] = User::where('usertype','flatowner')->get();
        return view('backend.servicecharge.view_servicecharge', $data );
    }

    public function ServiceChargeAdd() {
        $data['allFloorlist'] = Floor::all();
        $data['allUnitLis'] = Unit::all();
        $data['allFlatOwnerlist'] = User::where('usertype','flatowner')->get();


        $data['prev_is_in_month_year_petty_cash'] = PettyCash::whereMonth('month_year', 4)
            ->whereYear('month_year',2022)
            ->first()
        ->balance;


        return view('backend.servicecharge.add_servicecharge', $data );
    }

    public function ServiceChargeStore( Request $request ) {

        $service_charges_to_pay = Unit::where('id', $request->unit_id)->first();

        $find_due = ($service_charges_to_pay->serviceCharge) - ($request->serviceChargeAmount);
        $month_year = Carbon::parse($request->serviceChargeMonthYear)->format('M Y');
        $data = new ServiceCharge();
        $data->serviceChargeMonthYear = $request->serviceChargeMonthYear . '-02';
        $data->serviceChargeAmount = $request->serviceChargeAmount;
        $data->serviceChargeDue =  $find_due;
        $data->user_id = $request->user_id;
        $data->unit_id = $request->unit_id;
        $data->floor_id = $request->floor_id;
        $data->serviceChargeDate = $request->serviceChargeDate;

        $saved = $data->save();

        if($saved == 1) {
            $get_user = User::find($request->user_id);
            $get_unit = Unit::find($request->unit_id);
            if ( $get_user->sms_nofication == 'on' ) {
                $number = $get_user->phone;
                if ($find_due > 0) {
                    $text = "Dear $get_user->name, Received Service Charge TK $request->serviceChargeAmount Total due TK $find_due of $month_year, for Flat $get_unit->name. Thank You.";
                } else {
                    $text = "Dear $get_user->name, Received Service Charge TK $request->serviceChargeAmount of $month_year, for Flat $get_unit->name. Thank You.";
                }

                $url = "http://66.45.237.70/api.php";
                $data = array(
                    'username' => "01673950496",
                    'password' => "7RWNC9T8",
                    'number' => "$number",
                    'message' => "$text"
                );

                $ch = curl_init(); // Initialize cURL
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($ch);
                $p = explode("|", $smsresult);
                $sendstatus = $p[0];

            }
        }

        //Add balance to the PETTY CASH
        // Checking -- if Petty Cash is Blank

        $previous_pretty_cash_month = intval((mb_substr($request->serviceChargeDate , 5 , 8))) - 1;
        $previous_pretty_cash_year = intval(mb_substr($request->serviceChargeDate , 0 , 4));

        //dd($previous_pretty_cash_month . $previous_pretty_cash_year);

        $prev_petty_cash_balance = PettyCash::whereMonth('month_year', $previous_pretty_cash_month)
            ->whereYear('month_year', $previous_pretty_cash_year)
            ->first();

        //dd($prev_petty_cash_balance);

        $now_pretty_cash_month = intval(mb_substr($request->serviceChargeDate , 5 , 8));
        $now_pretty_cash_year = intval(mb_substr($request->serviceChargeDate , 0 , 4));

        $now_petty_cash = PettyCash::whereMonth('month_year', $now_pretty_cash_month)
            ->whereYear('month_year', $now_pretty_cash_year)
            ->first();

        //dd($now_petty_cash);

        if (empty($now_petty_cash)) {
            if (!empty($prev_petty_cash_balance)) {
                $data3 = new PettyCash();
                $data3->balance = ($request->serviceChargeAmount) + $prev_petty_cash_balance->balance;
                $data3->month_year = $request->serviceChargeDate;
                $data3->save();

            } else {
                $data3 = new PettyCash();
                $data3->balance = ($request->serviceChargeAmount);
                $data3->month_year = $request->serviceChargeDate;
                $data3->save();
            }
        } else {
            $data3 = PettyCash::find($now_petty_cash->id);
            $data3->balance = ($request->serviceChargeAmount) + $now_petty_cash->balance ;
            $data3->month_year = $request->serviceChargeDate;
            $data3->save();

            $next_petty_cash = PettyCash::where( 'id' , '>' , $now_petty_cash->id )->get();

            //dd($next_petty_cash);
            if (!empty($next_petty_cash)) {
                foreach ($next_petty_cash as $next_petty_single) {
                    $data4 = PettyCash::find($next_petty_single->id);
                    $data4->balance = $data4->balance + $request->serviceChargeAmount;
                    $data4->save();
                }
            }
            $prev_remaining_balance = RemainingBalance::find(2)->balance;

            $data2 = RemainingBalance::find(2);
            $data2->balance = ($request->serviceChargeAmount) + $prev_remaining_balance;
            $data2->month_year = $request->serviceChargeDate;
            $data2->save();
        }

        // Checking -- if remaining balance is Blank

        $prev_remaining_balance = RemainingBalance::find(2)->balance;

        $data2 = RemainingBalance::find(2);
        $data2->balance = ($request->serviceChargeAmount) + $prev_remaining_balance;
        $data2->month_year = $request->serviceChargeDate;
        $data2->save();

        // fire SMS here
        $notification = array(
            'message' => 'Service Charge Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('servicecharge.add')->with($notification);
    }

    public function ServiceChargeUpdate( Request $request , $id ) {

        $service_charges_to_pay = Unit::where('id', $request->unit_id)->first();

        $find_due = ($service_charges_to_pay->serviceCharge) - ($request->serviceChargeAmount);
        $month_year = Carbon::parse($request->serviceChargeMonthYear)->format('M Y');

        $data = ServiceCharge::find($id);
        $data->serviceChargeMonthYear = $request->serviceChargeMonthYear . '-02';
        $data->serviceChargeAmount = $request->serviceChargeAmount;
        $data->serviceChargeDue =  $find_due;
        $data->user_id = $request->user_id;
        $data->unit_id = $request->unit_id;
        $data->floor_id = $request->floor_id;
        $data->serviceChargeDate = $request->serviceChargeDate;
        $saved = $data->save();

        //Add balance to the PETTY CASH
        // Checking -- if Petty Cash is Blank
        $f = date('Y-m-d', strtotime($request->serviceChargeDate." -1 month"));
        $prev_date_petty_cash = Carbon::createFromFormat('m/Y', Carbon::parse($f)->format('m/Y'));
        $prev_is_in_month_year_petty_cash = PettyCash::whereMonth('month_year', $prev_date_petty_cash->month)
            ->whereYear('month_year', $prev_date_petty_cash->year)
            ->first();

        $date = Carbon::createFromFormat('m/Y', Carbon::parse($request->serviceChargeDate)->format('m/Y'));
        $is_in_month_year_petty_cash = PettyCash::whereMonth('month_year', $date->month)
            ->whereYear('month_year', $date->year)
            ->first();

        if (empty($is_in_month_year_petty_cash)) {
            if (!empty($prev_date_petty_cash)) {
                $data3 = new PettyCash();
                $data3->balance = ($request->serviceChargeAmount) + ($prev_is_in_month_year_petty_cash->balance);
                $data3->month_year = $request->serviceChargeDate;
                $data3->save();
            } else {
                $data3 = new PettyCash();
                $data3->balance = ($request->serviceChargeAmount);
                $data3->month_year = $request->serviceChargeDate;
                $data3->save();
            }
        } else {
            $data3 = PettyCash::find($is_in_month_year_petty_cash->id);
            $data3->balance = ($request->serviceChargeAmount) + ($is_in_month_year_petty_cash->balance) ;
            $data3->month_year = $request->serviceChargeDate;
            $data3->save();
        }


        // Checking -- if remaining balance is Blank
        $f = date('Y-m-d', strtotime($request->serviceChargeDate." -1 month"));
        $prev_date = Carbon::createFromFormat('m/Y', Carbon::parse($f)->format('m/Y'));
        $prev_is_in_month_year = RemainingBalance::whereMonth('month_year', $prev_date->month)
            ->whereYear('month_year', $prev_date->year)
            ->first();

        $date = Carbon::createFromFormat('m/Y', Carbon::parse($request->serviceChargeDate)->format('m/Y'));
        $is_in_month_year = RemainingBalance::whereMonth('month_year', $date->month)
            ->whereYear('month_year', $date->year)
            ->first();

        if (empty($is_in_month_year)) {
            if (!empty($prev_is_in_month_year)) {
                $data2 = new RemainingBalance();
                $data2->balance = ($request->serviceChargeAmount) + ($prev_is_in_month_year->balance);
                $data2->month_year = $request->serviceChargeDate;
                $data2->save();
            } else {
                $data2 = new RemainingBalance();
                $data2->balance = ($request->serviceChargeAmount);
                $data2->month_year = $request->serviceChargeDate;
                $data2->save();
            }
        } else {
            $data2 = RemainingBalance::find($is_in_month_year->id);
            $data2->balance = ($request->serviceChargeAmount) + ($is_in_month_year->balance) ;
            $data2->month_year = $request->serviceChargeDate;
            $data2->save();
        }

        // fire SMS here
        $notification = array(
            'message' => 'Service Charge Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('servicecharge.add')->with($notification);
    }

    public function ServiceChargeSearch(Request $request){

        $year_id = $request->year_id . '-02';

        $date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));

        $month_year = Carbon::parse($year_id)->format('M Y');

        $empsalaries = ServiceCharge::whereMonth('serviceChargeMonthYear', $date->month)
            ->whereYear('serviceChargeMonthYear', $date->year)
            ->get();

        $charges = array();
        $due_count = array();

        $html['thsource'] = '<th>SL</th>';
        $html['thsource'] .= '<th>Flat Owner Name</th>';
        $html['thsource'] .= '<th>Floor No.</th>';
        $html['thsource'] .= '<th>Flat No.</th>';
        $html['thsource'] .= '<th>Paid Date</th>';
        $html['thsource'] .= '<th>Amount to Pay</th>';
        $html['thsource'] .= '<th>Paid Amount</th>';
        $html['thsource'] .= '<th>Due</th>';
        $html['thsource'] .= '<th>Action</th>';

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
            $html[$key]['tdsource'] .= '<td>' . $empsalarie['get_unit']['serviceCharge'] . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie->serviceChargeAmount . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie->serviceChargeDue . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $reminder_button . '<a class="btn btn-rounded btn-primary show_receipt ml-2" data-servicechargeId="'. $empsalarie->id .'">Show Recipt</a><a class="btn btn-rounded btn-success ml-2" href="/servicecharge/detail/'. $empsalarie->id .'" ><i class="ti-pencil-alt"></i></a> <p class="smsmessage d-none">Message Sent</p></td>';

            $charges[] = (int)$empsalarie->serviceChargeAmount;
            $due_count[] = (int)$empsalarie->serviceChargeDue;

        }
        if ( 0 != (array_sum($charges)) ) {
            //$other_cost = AccountOtherCost::whereBetween('date',[$sdate,$edate])->sum('amount');
            $html['tfsource'] = '<td colspan="6" class="text-right"><b>Total</b></td>';
            $html['tfsource'] .= '<td>' . array_sum($charges) . '</td>';
            $html['tfsource'] .= '<td colspan="2">Total Due: ' . array_sum($due_count) . '</td>';
        } else {
            $html['tfsource'] = '<td colspan="9" class="text-center"><b>No Data Found</b></td>';
        }

        return response()->json(@$html);

    }// end method

    public function ServiceChargeReceipt(Request $request){

        $serviceChargeId = $request->serviceChargeId;
        $serviceCharges = ServiceCharge::where('id', $serviceChargeId)->first();
        $date = date('Y');

        $numto = new NumberToBangla();

        $text = $numto->bnMoney($serviceCharges->serviceChargeAmount);
        //print_r($serviceCharges);

        $receipt_html = '<div class="col-xs-12">
                            <div id="printableArea" style="background-color: #ffffff; padding: 15px;">
                                <div style="border: 2px solid #000000; padding: 15px">
                                    <div class="media receipt-heading">
                                        <div class="media-body">
                                            <div style="display: flex; justify-content: space-between">
                                                <div>
                                                    <h3 class="media-heading first-heading">Krishnochura Heights Flat Malik Kallayan Somity</h3>
                                                    <h3 class="media-heading second-heading">??????????????????????????? ????????????????????? ??????????????? ??????????????? ?????????????????? ???????????????</h3>
                                                </div>
                                                <div class="receipt-data">
                                                    <div class="receipt-id"><b>Receipt No / ?????????????????? ??????: '. $date.$serviceChargeId .' </b></div>
                                                    <div class="receipt-date"><b>Date / ???????????????: '. $serviceCharges->serviceChargeDate .'</b></div>
                                                    <div class="receipt-status"><b>Paid</b></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="receipt-body">
                                        <div class="student-name">?????????/Name:<span class="name-space">'.$serviceCharges['get_user']['name'].'</span></div>
                                        <div class="two-sections">
                                            <div class="first-section">??????????????? ??????/Flat No:<span class="first-space"><b>'. $serviceCharges['get_unit']['name']. '</b></span></div>
                                            <div class="second-section">??????????????? ??????/Floor No:<span class="second-space"><b>'. $serviceCharges['get_floor']['name']. '</b></span></div>
                                        </div>
                                        <div class="two-sections">
                                            <div class="first-section">?????????????????? ??????/Mobile Number:<span class="first-space"><b>'. $serviceCharges['get_user']['phone']. '</b></span></div>
                                            <div class="second-section">????????????/Purpose:<span class="second-space"><b>Service Charge</b></span></div>
                                        </div>
                                        <div class="two-sections amount">
                                            <div class="first-section amount">??????????????????/Amount: <span class="first-space"><b>' . $serviceCharges->serviceChargeAmount . '</b>/=</span></div>
                                            <div class="second-section amount-word">???????????? / In Words: <span class="second-space"><b>'. $text .' ???????????????</b></span></div>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; margin-top: 55px;">
                                            <div style="border-top: 1px dotted #797979; padding-top: 10px"><b>??????????????????????????????/Payee name</b></div>
                                            <div style="border-top: 1px dotted #797979; padding-top: 10px"><b>????????????????????????/Receiver</b></div>
                                        </div>
                                        <hr>
                                        <h5 style="text-align: center; color:#000000;">???????????? ????????? ??????, ????????????????????????, ??????????????? ???, ?????????????????? ???, ??????????????????, ???????????? - ???????????? </h5>
                                    </div>
                                </div>
                            </div>
                         </div>

<div class="col-xs-12">
    <button target="_blank"  onclick="printDiv()"   value="print a div!" class="btn btn-rounded btn-primary show_receipt my-3"><i class="fa fa-print"></i> Print</button>
</div>';


        return response()->json($receipt_html);

    }

    public function ServiceChargeToBank() {
        $data['allBank'] = Bank::all();

        $f = PettyCash::all();
        $g = collect($f)->last();
        $data['find_petty_cash'] = $g->balance;

        return view('backend.servicecharge.tobank_servicecharge', $data );
    }

    public function DepositToBank( Request $request) {
        // Bank amount update
        $data = Bank::find($request->bank_id);
        $preveious_balance = $data->amount;
        $data->amount = $request->amount_to_deposit + $preveious_balance;
        $data->save();

        $make_month = intval(mb_substr($request->transaction_date , 5 , 8));
        $make_year = intval(mb_substr($request->transaction_date , 0 , 4));

        // Petty Cash Update
        $f = PettyCash::all();
        $g = collect($f)->last();
        $cash_in_handle = $g->balance;
        $for_petty_cash = PettyCash::find($g->id);
        $for_petty_cash->balance = ($cash_in_handle) - ($request->amount_to_deposit);
        $for_petty_cash->save();

        // Bank Transaction Update
        //find  - if same month or new month
        $find_transaction = BankTransaction::whereMonth('transaction_date', $make_month)
            ->whereYear('transaction_date', $make_year)
            ->where('bank_id', $request->bank_id)
            ->first();

        if (!empty($find_transaction)) {
            $transaction = BankTransaction::find($find_transaction->id);
            $previous_balance = $transaction->balance;
            $transaction->balance = $previous_balance + $request->amount_to_deposit;
            $transaction->transaction_date = $request->transaction_date;
            $transaction->bank_id = $request->bank_id;
            $transaction->petty_cash_balance = ($cash_in_handle) - ($request->amount_to_deposit);
            $transaction->save();
        } else {
            $creat_transaction = new BankTransaction();

            $creat_transaction->transaction_date = $request->transaction_date;
            $creat_transaction->bank_id = $request->bank_id;
            $creat_transaction->balance = $request->amount_to_deposit;
            $creat_transaction->petty_cash_balance = ($cash_in_handle) - ($request->amount_to_deposit);
            $creat_transaction->save();
        }

        $notification = array(
            'message' => 'Deposited to The Bank Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('servicecharge.tobank')->with($notification);
    }

    public function WithdrawFromBank( Request $request) {

        $data = Bank::find($request->bank_id);
        $preveious_balance = $data->amount;
        $data->amount = $preveious_balance - $request->amount_to_withdraw;
        $data->save();

        $f = PettyCash::all();
        $g = collect($f)->last();
        $cash_in_handle = $g->balance;

        $for_petty_cash = PettyCash::find($g->id);
        $for_petty_cash->balance = ($cash_in_handle) + ($request->amount_to_withdraw) ;
        $for_petty_cash->save();

        // Bank Transaction Update
        //find  - if same month or new month
        $make_month = intval(mb_substr($request->withdraw_date , 5 , 8));
        $make_year = intval(mb_substr($request->withdraw_date , 0 , 4));
        $find_transaction = BankTransaction::whereMonth('transaction_date', $make_month)
            ->whereYear('transaction_date', $make_year)
            ->where('bank_id', $request->bank_id)
            ->first();

        if (!empty($find_transaction)) {
            $transaction = BankTransaction::find($find_transaction->id);
            $previous_balance = $transaction->balance;
            $transaction->balance = $previous_balance - $request->amount_to_withdraw;
            $transaction->transaction_date = $request->withdraw_date;
            $transaction->bank_id = $request->bank_id;
            $transaction->petty_cash_balance = ($cash_in_handle) + ($request->amount_to_withdraw);
            $transaction->save();
        } else {
            $creat_transaction = new BankTransaction();
            $creat_transaction->transaction_date = $request->withdraw_date;
            $creat_transaction->bank_id = $request->bank_id;
            $creat_transaction->balance = $request->amount_to_withdraw;
            $creat_transaction->petty_cash_balance = ($cash_in_handle) + ($request->amount_to_withdraw);
            $creat_transaction->save();
        }

        $notification = array(
            'message' => 'Withdraw Successfully and Added to Petty Cash',
            'alert-type' => 'success'
        );

        return redirect()->route('servicecharge.tobank')->with($notification);
    }

    public function DueServiceCharge() {
        return view('backend.servicecharge.due_servicecharge' );
    }

    public function ServiceChargeDueSearch( Request $request ){

        $year_id = $request->year_id . '-02';

        $date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));

        $month_year = Carbon::parse($year_id)->format('M Y');

        //get all unit here
        $allUnits = Unit::all();
        $total_serviceCharge = Unit::all()->sum('serviceCharge');
        // where user name is

        $charges = array();
        $due_count = array();

        $html['thsource'] = '<th>SL</th>';
        $html['thsource'] .= '<th>Flat Owner Name</th>';
        $html['thsource'] .= '<th>Floor No.</th>';
        $html['thsource'] .= '<th>Flat No.</th>';
        $html['thsource'] .= '<th>Due</th>';
        $html['thsource'] .= '<th>Action</th>';
        $total_serviceCharge_received = array();

        foreach ($allUnits as $key => $unitInfo) {

            $saerviceChargeInfo = ServiceCharge::whereMonth('serviceChargeMonthYear', $date->month)
                ->whereYear('serviceChargeMonthYear', $date->year)
                ->where('unit_id' , $unitInfo->id)
                ->where('user_id' , $unitInfo['get_user_name']['id'])
                ->first();

            if (!empty($saerviceChargeInfo)) {
                $total_serviceCharge_received[] = $saerviceChargeInfo['serviceChargeAmount'];
                if( $saerviceChargeInfo['serviceChargeDue'] > 0 ){
                    $f = '<button type="button" class="btn btn-rounded btn-info m-5">Due:  ' . $saerviceChargeInfo['serviceChargeDue'] . '</button>';
                    $reminder_button = '<a class="btn btn-rounded btn-info d-inline-flex due-money" data-text="Dear ' . $unitInfo['get_user_name']['name'] . ', Total due TK'. $saerviceChargeInfo['serviceChargeDue'] .' as Service Charge for '. $month_year .', for Flat '. $unitInfo->name .'. Please pay." data-phone="' . $unitInfo['get_user_name']['phone'] . '" id=""><i class="d-none ti-check"></i>Remind</a>';
                } else {
                    $f = '<button type="button" class="btn btn-rounded btn-success m-5">Paid</button>';
                    $reminder_button = 'paid';
                }
            } else {
                $f = '<button type="button" class="btn btn-rounded btn-danger m-5">Not Paid</button>';
                $reminder_button = '<a class="btn btn-rounded btn-info d-inline-flex due-money" data-text="Dear ' . $unitInfo['get_user_name']['name'] . ', Total due TK'. $unitInfo->serviceCharge .' as Service Charge for '. $month_year .', for Flat '. $unitInfo->name .'. Please pay." data-phone="' . $unitInfo['get_user_name']['phone'] . '" id=""><i class="d-none ti-check"></i>Remind</a>';
            }

            $html[$key]['tdsource'] = '<td>' . ($key + 1) . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $unitInfo['get_user_name']['name'] . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $unitInfo['get_floor_name']['name'] . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $unitInfo->name. '</td>';
            $html[$key]['tdsource'] .= '<td>' . $f . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $reminder_button . '<p class="smsmessage d-none">Message Sent</p></td>';

        }

        $d = $total_serviceCharge - array_sum($total_serviceCharge_received);

        $html['tfsource'] = '<td colspan="9" class="text-center"><b>Total Service Charge Due: '. $d .'</b></td>';

        return response()->json(@$html);
    }

    public function ServiceChargeDetail( Request $request , $id) {

        $data['thatServiceCharge'] = ServiceCharge::find( $id );
        $data['allFloorlist'] = Floor::all();
        $data['allUnitLis'] = Unit::all();
        $data['allFlatOwnerlist'] = User::where('usertype','flatowner')->get();
        return view('backend.servicecharge.detail_servicecharge', $data );
    }

}
