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
                                <h4 class="box-title">Monthly Report - Balance Sheet</h4>
                            </div>

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Select Month Year</h5>
                                            <div class="controls">
                                                <input class="form-control" id="reportMonthYear" name="reportMonthYear" type="month" value="">
                                            </div>
                                        </div>

                                    </div> <!-- End Col md 3 -->

                                    <div class="col-md-3" style="padding-top: 25px;">

                                        <a id="search_balance_btn" class="btn btn-primary" name="search"> Search</a>

                                    </div> <!-- End Col md 3 -->
                                </div><!--  end row -->

                                <!--  ////////////////// Registration Fee table /////////////  -->
                                {{--

                                    <script id="document-template" type="text/x-handlebars-template">

                                        <div class="col-md-5 col-12 border-danger">
                                            <div class="text-center"><h4><b>Deposit</b></h4></div>
                                            <table class="table table-bordered table-striped" style="width: 100%">
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
                                                    <tr><td colspan="2"><h5>Total Balance in @{{{bank_name}}} : @{{{balance_in_bank}}}</h5></td><td colspan="2"><h5>Remaining Balance in Hand : @{{{balance_in_hand}}}</h5></td></tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="col-md-7 col-12">
                                            <div class="text-center"><h4><b>Expense</b></h4></div>
                                            <table class="table table-bordered table-striped" style="width: 100%">
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
                                        </div>
                                        <div class="col-12 text-center">
                                            <h3>Total Balance Remaining : @{{{balance}}}</h3>
                                        </div>
                                        </script>
                                        <div class="row" id="DocumentResults" style="margin-top: 40px;">
                                        </div>

                                --}}
                                    <script id="document-template" type="text/x-handlebars-template">
                                        <div class="w-100-percent col-12" id="reportMonthlyprintableArea">
                                            <div class="no-print text-center">
                                                <h2 class="color-black" style="color:#000000">Krishnochura Heights Flat Malick Kalyan Samity</h2>
                                                <h3 class="color-black" style="color:#000000">House # 64, Avenue # 5, Block # A, <br>Section # 6, Mirpur, Dhaka -1216</h3>
                                                <h4 class="color-black" style="color:#000000">Monthly Statement of Income & Expenditure</h4><br>
                                                <h4 class="color-black" style="color:#000000">For the Month of @{{{report_of_month}}}</h4><br>
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
                                            <table class="tg w-100-percent color-black">
                                                <thead>
                                                <tr>
                                                    @{{{thsource}}}
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @{{{previousBalance}}}
                                                    </tr>
                                                    <tr>
                                                        @{{{serviceChargeIncome}}}
                                                    </tr>
                                                    <tr>
                                                        @{{{ total_income}}}
                                                    </tr>

                                                    @{{#each this}}
                                                    <tr>
                                                        @{{{td2source}}}
                                                    </tr>
                                                    @{{/each}}

                                                    <tr>
                                                        @{{{total_expen}}}
                                                    </tr>

                                                    <tr>
                                                        <td class="tg-0lax" colspan="2"></td>
                                                        <td class="tg-0lax">Balance in Hand</td>
                                                        <td class="tg-0lax"></td>
                                                        <td class="tg-0lax">@{{{balance_in_hand}}}</td>
                                                        <td class="tg-0lax"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tg-0lax" colspan="2"></td>
                                                        <td class="tg-0lax">Balance in Bank</td>
                                                        <td class="tg-0lax">@{{{bank_name}}}</td>
                                                        <td class="tg-0lax">@{{{balance_in_bank}}}</td>
                                                        <td class="tg-0lax"></td>
                                                    </tr>

                                                    <tr>
                                                        @{{{total_remaining}}}
                                                    </tr>

                                                </tbody>
                                            </table>
                                            @{{{expen}}}
                                            @{{{count_of_expenditure_list}}}
                                        </div>

                                        <button target="_blank" onclick="printMonthlyReportDiv()" value="print Report" class="btn btn-rounded btn-primary my-3"><i class="fa fa-print"></i> Print Report</button>
                                    </script>
                                    <div class="row w-100-percent" id="DocumentResults" style="margin-top: 40px;">
                                    </div>


                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                </div>
            </section>
        </div>
    </div>
@endsection
