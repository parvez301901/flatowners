<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Bank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function BankView() {
        $data['allBanks'] = Bank::all();
        return view('backend.bank.view_bank' , $data );
    }

    public function BankAdd() {
        return view('backend.bank.add_bank' );
    }

    public function BankStore(Request $request) {

        $data = new Bank();
        $data->name = $request->name;
        $data->bank_account_no = $request->bank_account_no;
        $data->bank_branch_name = $request->bank_branch_name;
        $data->bank_account_holder_name = $request->bank_account_holder_name;
        $data->save();

        return redirect()->route('bank.view');
    }

    public function BankDetail($id) {
        $data['singleBank'] = Bank::find($id);
        return view('backend.bank.detail_bank' , $data );
    }

    public function BankUpdate(Request $request, $id) {

        $data = Bank::find($id);
        $data->name = $request->name;
        $data->bank_account_no = $request->bank_account_no;
        $data->bank_branch_name = $request->bank_branch_name;
        $data->bank_account_holder_name = $request->bank_account_holder_name;
        $data->save();

        return redirect()->route('bank.view');
    }

}
