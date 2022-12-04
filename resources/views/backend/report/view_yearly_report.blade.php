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

                                <div id="test_report">

                                </div>
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
                                        <div class="col-12 text-center"><h3>Total Balance Remaining : @{{{balance}}}</h3></div>
                                        </script>
                                        <div class="row" id="DocumentResults" style="margin-top: 40px;">
                                        </div>

                                --}}

                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                </div>
            </section>
        </div>
    </div>
@endsection
