<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ServiceCharge;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceChargeController extends Controller
{
    public function ServiceChargeView() {
        $data['allUserData'] = User::where('usertype','flatowner')->get();
        return view('backend.servicecharge.view_servicecharge', $data );
    }

    public function ServiceChargeAdd() {
        $allFlatOwnerlist = User::where('usertype','flatowner')->get();
        return view('backend.servicecharge.add_servicecharge', compact( 'allFlatOwnerlist') );
    }

    public function ServiceChargeStore( Request $request ) {
        $data = new ServiceCharge();
        $data->serviceChargeMonthYear = $request->serviceChargeMonthYear . '-02';
        $data->serviceChargeAmount = $request->serviceChargeAmount;
        $data->flatownerId = $request->flatownerId;
        $data->serviceChargeDate = $request->serviceChargeDate;
        $data->save();
        return redirect()->route('servicecharge.add');
    }

    public function ServiceChargeSearch(Request $request){

        $year_id = $request->year_id . '-02';

        $date = Carbon::createFromFormat('m/Y', Carbon::parse($year_id)->format('m/Y'));

        $empsalaries = ServiceCharge::whereMonth('serviceChargeMonthYear', $date->month)
            ->whereYear('serviceChargeMonthYear', $date->year)
            ->get();


        $charges = array();

        $html['thsource'] = '<th>SL</th>';
        $html['thsource'] .= '<th>Flat Owner Name</th>';
        $html['thsource'] .= '<th>Deposit Date</th>';
        $html['thsource'] .= '<th>Amount</th>';

        foreach ($empsalaries as $key => $empsalarie) {

            //$flat_owner_name = User::find($empsalarie->flatownerId)->get();

            $html[$key]['tdsource'] = '<td>' . ($key + 1) . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie['get_user']['name'] . '</td>';
            //$html[$key]['tdsource'] .= '<td>' . $flat_owner_name->name . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie->serviceChargeDate . '</td>';
            $html[$key]['tdsource'] .= '<td>' . $empsalarie->serviceChargeAmount . '</td>';
            $charges[] = (int)$empsalarie->serviceChargeAmount;

        }
        if ( 0 != (array_sum($charges)) ) {
            //$other_cost = AccountOtherCost::whereBetween('date',[$sdate,$edate])->sum('amount');
            $html['tfsource'] = '<td colspan="3" class="text-right"><b>Total</b></td>';
            $html['tfsource'] .= '<td>' . array_sum($charges) . '</td>';
        } else {
            $html['tfsource'] = '<td colspan="4" class="text-center"><b>No Data Found</b></td>';
        }


        return response()->json(@$html);

    }// end method
}
