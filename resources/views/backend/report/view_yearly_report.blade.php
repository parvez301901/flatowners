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
                                <h4 class="box-title">Yearly Report - Balance Sheet</h4>
                            </div>

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Select Year</h5>
                                            <div class="controls">
                                                <input id="reportYear" class="form-control" name="reportMonthYear" type="number" min="2022" max="2099" step="1" value="{{now()->year}}" />
                                            </div>
                                        </div>

                                    </div> <!-- End Col md 3 -->

                                    <div class="col-md-3" style="padding-top: 25px;">

                                        <a id="search_yearly_balance_btn" class="btn btn-primary" name="search"> Search</a>

                                    </div> <!-- End Col md 3 -->
                                </div><!--  end row -->

                                <div id="test_report_2">

                                </div>
                                <!--  ////////////////// Yearly Report /////////////  -->

                                <script id="document-yearly-template" type="text/x-handlebars-template">
                                    <div class="w-100-percent col-12" id="reportMonthlyprintableArea">
                                        <div class="no-print text-center">
                                            <h2 class="color-black" style="color:#000000">Krishnochura Heights Flat Malick Kalyan Samity</h2>
                                            <h3 class="color-black" style="color:#000000">House # 64, Avenue # 5, Block # A, <br>Section # 6, Mirpur, Dhaka -1216</h3>
                                            <h4 class="color-black" style="color:#000000">Monthly Statement of Income & Expenditure</h4><br>
                                            <h4 class="color-black" style="color:#000000">For the Year of @{{{test}}}</h4><br>
                                        </div>
                                        <div class="text-center hide-in-print" style="color: #ffffff; margin-bottom: 30px;" >
                                            <h2 class="" style="color:#ffffff">For the Year of @{{{test}}}</h2>
                                        </div>
                                        <style type="text/css">
                                            .tg  {border-collapse:collapse;border-spacing:0;}
                                            .tg td{border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                                                overflow:hidden;padding:10px 5px;word-break:normal;}
                                            .tg th{border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                                                font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                                            .tg .tg-0pky{border-color:inherit;text-align:center;vertical-align:top}
                                        </style>
                                        <table class="tg w-100-percent">
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
                                        </table>
                                    </div>
                                    <div class="col-12">
                                    <button target="_blank" onclick="printMonthlyReportDiv()" value="print Report" class="btn btn-rounded btn-primary my-3"><i class="fa fa-print"></i> Print Report</button>
                                    </div>
                                </script>
                                <div class="row w-100-percent" id="DocumentYearlyResults" style="margin-top: 40px;">
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
