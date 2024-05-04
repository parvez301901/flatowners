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
                                <h4 class="box-title">Monthly Income Report</h4>
                            </div>

                            <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <h5>Select Month Year</h5>
                                                <div class="controls">
                                                    <input class="form-control" id="reportMonthYearIncome" name="reportMonthYearIncome" type="month" value="">
                                                </div>
                                            </div>

                                        </div> <!-- End Col md 3 -->

                                        <div class="col-md-3" style="padding-top: 25px;">

                                            <a id="search_income_btn" class="btn btn-primary" name="search"> Search</a>

                                        </div> <!-- End Col md 3 -->
                                    </div><!--  end row -->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <script id="document-template" type="text/x-handlebars-template">
                                                <div class="w-100-percent col-12" id="reportMonthlyIncomeprintableArea">
                                                    <div class="no-print text-center">
                                                        <h2 class="color-black" style="color:#000000">Krishnochura Heights Flat Malick Kalyan Samity</h2>
                                                        <h3 class="color-black" style="color:#000000">House # 64, Avenue # 5, Block # A, <br>Section # 6, Mirpur, Dhaka -1216</h3>
                                                        <h4 class="color-black" style="color:#000000">Monthly Statement of Income & Expenditure</h4><br>
                                                        <h4 class="color-black" style="color:#000000">For the Month of @{{{report_of_month}}}</h4><br>
                                                    </div>
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
                                                    </tfoot>
                                                </table>
                                                </div>
                                                <div class="col-12">
                                                <button target="_blank" onclick="printMonthlyIncomeReportDiv()" value="print Report" class="btn btn-rounded btn-primary my-3"><i class="fa fa-print"></i> Print Report</button>
                                                </div>
                                            </script>
                                            <div class="row w-100-percent" id="DocumentResults">
                                            </div>
                                        </div>

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
