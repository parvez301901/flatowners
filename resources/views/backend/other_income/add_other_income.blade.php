@extends('admin.admin_master');
@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Deposit Other Incomes</h4>
                        </div>
                        <form class="form-horizontal" method="POST" action="{{route('otherincome.store')}}">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Service Charge Info:</h4>
                                <div class="row">
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label>Name of the month</label>
                                            <input class="form-control" name="other_income_month_year" type="month" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-12">
                                        <div class="form-group">
                                            <label>Deposit Money</label>
                                            <input name="other_income_amount" class="form-control" type="number" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label>Income Detail</label>
                                            <input class="form-control" name="other_income_detail" type="text" value="" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label>Deposit Date</label>
                                            <input class="form-control" name="other_income_date" type="date" value="" id="example-date-input">
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-12">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-rounded btn-info mt-4" value="Add">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-12">
                <div class="receipt-holder"></div>
            </div>
        </div>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box bb-3 border-warning">
                        <div class="box-header">
                            <h4 class="box-title">Service Charge List</h4>
                        </div>
                        <div class="box-body">
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

