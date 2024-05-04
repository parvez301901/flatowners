@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Project Detail</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$detailData->name}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="" style="">
                    <input name="project_id" type="hidden" class="form-control project_id" value="{{$detailData->id}}" required="required">
                    <input id="show_project_balance_btn" type="submit" class="btn btn-primary" value="View Balance Sheet" />
                </div> <!-- End Col md 3 -->
            </div>
        </div>

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-light rounded w-60 h-60">
                                <i class="text-white mr-0 font-size-24 mdi mdi-chart-line"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Total Budget</p>
                                <h3 class="text-white mb-0 font-weight-500">BDT {{$detailData->project_budget}} </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-primary-light rounded w-60 h-60">
                                <i class="text-primary mr-0 font-size-24 mdi mdi-account-multiple"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Total Collected</p>
                                <h3 class="text-white mb-0 font-weight-500">BDT {{$total_deposit}}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-danger-light rounded w-60 h-60">
                                <i class="text-danger mr-0 font-size-24 mdi mdi-cash-100"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Balance Remaining</p>
                                <h3 class="text-white mb-0 font-weight-500">{{$total_deposit - $total_expense}}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-warning-light rounded w-60 h-60">
                                <i class="text-success mr-0 font-size-24 mdi mdi-bank"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Balance in Bank</p>
                                <h3 class="text-white mb-0 font-weight-500">{{$balanceInBank}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-info-light rounded w-60 h-60">
                                <i class="text-info mr-0 font-size-24 mdi mdi-sale"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Balance on Petty Cash</p>
                                <h3 class="text-white mb-0 font-weight-500 text-capitalize">{{$balanceInPettyCash}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-warning-light rounded w-60 h-60">
                                <i class="text-danger mr-0 font-size-24 mdi mdi-flag-checkered"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Finish Date of Project</p>
                                <h3 class="text-white mb-0 font-weight-500">@php $date = new DateTime( $detailData->project_end_date);$result = $date->format('jS M Y');echo $result; @endphp</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <script id="document-template-project" type="text/x-handlebars-template">
                        <div class="col-md-6 border-danger">
                            <div class="text-center" style="text-align: center"><h4><b>Deposit</b></h4></div>
                            <div id="reportPrintProjectDepositPrintableArea">
                                <div class="no-print text-center" style="text-align: center">
                                    <h3 class="color-black" style="color:#000000; text-align: center;">Krishnochura Heights Flat Malick Kalyan Samity</h3>
                                    <h4 class="color-black" style="color:#000000; text-align: center;">House # 64, Avenue # 5, Block # A, <br>Section # 6, Mirpur, Dhaka -1216</h4>
                                    <div class="text-center" style="text-align: center"><h4><b>Deposit</b></h4></div>
                                </div>
                                <style type="text/css">
                                    .tg  {border-collapse:collapse;border-spacing:0;}
                                    .tg td{border:1px solid #8b8a8a;font-family:Arial, sans-serif;font-size:14px;
                                        overflow:hidden;padding:10px 5px;word-break:normal;}
                                    .tg th{border:1px solid #8b8a8a;font-family:Arial, sans-serif;font-size:14px;
                                        font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                                    .tg .tg-0lax{text-align:left;vertical-align:top; font-size: 16px;}
                                    .tg .tg-bold { font-weight: bold; } .w-100-percent { width: 100%; }
                                </style>
                            <table class="table table-bordered table-striped tg w-100-percent color-black" style="width: 100%">
                                <thead>
                                <tr>
                                    @{{{thsource}}}
                                </tr>
                                </thead>
                                <tbody>
                                @{{#each this}}
                                <tr>
                                    @{{{tdsource}}}
                                </tr>
                                @{{/each}}
                                </tbody>
                                <tfoot>
                                <tr>
                                    @{{{tfsource}}}
                                </tr>
                                </tfoot>
                            </table>

                                <div class="col-12">
                                    <button target="_blank" onclick="printProjectDeposit()" value="print Report" class="btn btn-rounded btn-primary my-3"><i class="fa fa-print"></i> Print Report</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-center" style="text-align: center;"><h4><b>Expense</b></h4></div>
                            <div id="reportPrintProjectExpenditurePrintableArea">
                                <div class="no-print text-center" style="text-align: center;">
                                    <h3 class="color-black" style="color:#000000; text-align: center;">Krishnochura Heights Flat Malick Kalyan Samity</h3>
                                    <h4 class="color-black" style="color:#000000; text-align: center;">House # 64, Avenue # 5, Block # A, <br>Section # 6, Mirpur, Dhaka -1216</h4>
                                    <div class="text-center" style="text-align: center;"><h4><b>Expense</b></h4></div>
                                </div>
                                <style type="text/css">
                                    .tg  {border-collapse:collapse;border-spacing:0;}
                                    .tg td{border:1px solid #8b8a8a;font-family:Arial, sans-serif;font-size:14px;
                                        overflow:hidden;padding:10px 5px;word-break:normal;}
                                    .tg th{border:1px solid #8b8a8a;font-family:Arial, sans-serif;font-size:14px;
                                        font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                                    .tg .tg-0lax{text-align:left;vertical-align:top; font-size: 16px;}
                                    .tg .tg-bold { font-weight: bold; } .w-100-percent { width: 100%; }
                                </style>
                                <table class="table table-bordered table-striped tg w-100-percent color-black" style="width: 100%">
                                    <thead>
                                    <tr>
                                        @{{{th2source}}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @{{#each this}}
                                    <tr>
                                        @{{{td2source}}}
                                    </tr>
                                    @{{/each}}
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        @{{{tf2source}}}
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="col-12">
                                    <button target="_blank" onclick="printProjectExpenditure()" value="print Report" class="btn btn-rounded btn-primary my-3"><i class="fa fa-print"></i> Print Report</button>
                                </div>
                            </div>
                        </div>


                        <table>
                            <tr><td><h5>Total Balance in @{{{bank_name}}} </h5></td><td>@{{{balance_in_bank}}}</td></tr>
                            <tr><td><h5>Remaining Balance in Hand </h5></td><td>@{{{balance_in_hand}}}</td></tr>
                        </table>
                        <div class="col-12 text-center"><h3>Total Balance Remaining : @{{{balance}}}</h3></div>
                    </script>
                    <div class="row" id="projectDetail">
                    </div>
                </div>
                <div class="col-lg-12 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Recent Expense List</h4>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Expense Head</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th width="30%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $allexpensedata as $key => $expense)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $expense->project_cost_note }}</td>
                                            <td>{{ $expense->amount }}</td>
                                            <td>{{ $expense->project_cost_date }}</td>
                                            <td>
                                                <a href="{{ route('project_cost.detail' , $expense->id) }}" class="btn btn-success mr-2">Details</a>
                                                <a href="{{ route('project_cost.detail' , $expense->id) }}" class="btn btn-info mr-2">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-lg-12 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Deposit Money List</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example_project_deposit" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Flat No.</th>
                                        <th>Amount</th>
                                        <th>Due</th>
                                        <th width="30%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $alldepoasitdata as $key => $deposit)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $deposit['get_user_name']['name'] }}</td>
                                            <td>{{ $deposit['get_unit_name']['name'] }}</td>
                                            <td>{{ $deposit->amount }}</td>
                                            <td>{{ $deposit->due }}</td>
                                            <td>
                                                <!--<a href="{{ route('project_cost.detail' , $deposit->id) }}" class="btn btn-success mr-2">Details</a>-->
                                                @if($deposit->due > 0)
                                                    <a data-phone="{{ $deposit['get_user_name']['phone'] }}" data-text="Dear {{ $deposit['get_user_name']['name'] }} please pay due {{ $deposit->due }} for {{$detailData->name}}. Thank You" href="{{ route('project_deposit.sms' , $deposit['get_user_name']['id']) }}" class="btn btn-info d-inline-flex project_due_alert  mr-2"><i class="ti-check d-none"></i>Reminder</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Add Project Cost</h4>
                        </div>
                        <!-- /.box-header -->
                        <form class="form-horizontal" method="POST" action="{{route('project_cost.store')}}" enctype="multipart/form-data">
                            @csrf
                            <input name="project_id" type="hidden" class="form-control" value="{{$detailData->id}}" required="required" placeholder="Cost">
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Cost Information:</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input name="amount" type="number" class="form-control" required="required" placeholder="Cost">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Expense From</label>
                                            <select name="expense_from" required="required" class="form-control select2 expense_from">
                                                <option value="select_expense_from">Select from where to expense</option>
                                                <option value="from_petty_cash">From Petty Cash</option>
                                                <option value="from_bank">From Bank</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 select-bank d-none">
                                        <div class="form-group">
                                            <h5>Select Bank</h5>
                                            <select name="bank_id"  class="form-control select2 w-auto">
                                                <option value="">Select Bank Name</option>
                                                @foreach($allBank as $bank )
                                                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Utility</label>
                                            <select name="utilityId" required="required" class="form-control select2">
                                                <option value="">Select Utility</option>
                                                @foreach( $allUtilitylist as $utility )
                                                    <option value="{{ $utility->id }}">{{ $utility->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Responsible User</label>
                                            <select name="userId" class="form-control select2">
                                                <option value="">Select User</option>
                                                @foreach( $users as $user )
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Maintenance Cost added Date</label>
                                            <input class="form-control" name="project_cost_date" required="required" type="date" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea rows="5" class="form-control" name="project_cost_note" placeholder="Write note"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Slips/Receipt</label>
                                            <input type="file" name="project_cost_image" accept="image/png, image/gif, image/jpeg" class="form-control" id="image" >
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <img id="showImage" src="{{ (!empty($user->image))? url('upload/user_images/'.$user->image):url('upload/no_image.jpg') }}" style="width: 100px; width: 100px; border: 1px solid #000000;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Add Project Expense">
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>

            </div>

        </section>
    </div>
</div>

@endsection
