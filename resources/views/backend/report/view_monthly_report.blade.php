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

                                    <script id="document-template" type="text/x-handlebars-template">
                                        <div class="col-md-6 border-danger">
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
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
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
                                        <div class="row" id="DocumentResults">
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
