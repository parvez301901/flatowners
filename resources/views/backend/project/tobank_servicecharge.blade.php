@extends('admin.admin_master')
@section('admin')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box bb-3 border-warning">
                            <div class="box-header">
                                <h4 class="box-title">Transfer to Bank</h4>
                            </div>
                            <div class="box-body">
                                <form class="form-horizontal" method="POST" action="{{ route('servicecharge.deposittobank') }}">
                                    @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Select Bank</h5>
                                            <div class="controls">
                                                <select name="bank_id" class="form-control select2">
                                                    <option value="">Select Bank Name</option>
                                                    @foreach($allBank as $bank )
                                                        <option value="{{$bank->id}}">{{$bank->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Enter Amount to Deposit</h5>
                                            <div class="controls">
                                                <input name="amount_to_deposit" class="form-control amount-to-deposit" type="number" >
                                                <p class="message bg-danger d-none">Cash In Hand is less than you want to deposit</p>
                                            </div>
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Cash In Hand</h5>
                                            <div class="controls">
                                                <input disabled class="form-control cash-in-hand-balance" type="number" value="{{$find_petty_cash}}">
                                                <input type="hidden" class="form-control cash-in-hand" type="number" value="{{$find_petty_cash}}">
                                            </div>
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-rounded btn-info mt-4 deposit-button" value="Deposit Bank">
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                </div><!--  end row -->
                                </form>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border d-flex justify-content-between align-items-center">
                                <h3 class="box-title">Balances in Banks</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Bank Name</th>
                                            <th>Balance</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $allBank as $key => $bank)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $bank->name }}</td>
                                                <td>{{ $bank->amount }}</td>
                                                <td>
                                                    <a href="{{ route('bank.detail' , $bank->id) }}" class="btn btn-info mr-2">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </div>
                </div>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="box bb-3 border-warning">
                            <div class="box-header">
                                <h4 class="box-title">Withdraw From Bank</h4>
                            </div>
                            <div class="box-body">
                                <form class="form-horizontal" method="POST" action="{{ route('servicecharge.withdrawfrombank') }}">
                                    @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Select Bank</h5>
                                            <div class="controls">
                                                <select name="bank_id" class="form-control select2 withdrawd-bank-select">
                                                    <option value="">Select Bank Name</option>
                                                    @foreach($allBank as $bank )
                                                        <option value="{{$bank->id}}">{{$bank->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Balance in the Bank</h5>
                                            <div class="controls">
                                                <input disabled class="form-control cash-to-withdraw" type="number" value="">
                                            </div>
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Enter Amount to Withdraw</h5>
                                            <div class="controls">
                                                <input name="amount_to_withdraw" class="form-control amount-to-withdraw" type="number" >
                                                <p class="message-withdraw bg-danger d-none">Cannot deposit More than from the bank</p>
                                            </div>
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-rounded btn-info mt-4 disabled withdraw-button" value="Withdraw From Bank">
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                </div><!--  end row -->
                                </form>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
