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
                                <h4 class="box-title">Service Charge Due List</h4>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Select Month Year</h5>
                                            <div class="controls">
                                                <input class="form-control" id="serviceChargeDueMonthYear" name="serviceChargeDueMonthYear" type="month" value="">
                                            </div>
                                        </div>
                                    </div> <!-- End Col md 3 -->
                                </div><!--  end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="receipt-holder"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <script id="document-template" type="text/x-handlebars-template">

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
                                        </script>
                                        <div id="DocumentResults">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
