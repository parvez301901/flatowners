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
                            <h4 class="box-title">Maintenance List</h4>
                        </div>
                        @php
                            /*
                            echo '
                            <pre>';

                                print_r($empsalaries);

                                echo '</pre>
                            ';
                            */
                        @endphp
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Select Month Year</h5>
                                        <div class="controls">
                                            <input class="form-control" id="maintenanceMonthYear" name="maintenanceMonthYear" type="month" value="">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Col md 3 -->
                                <div class="col-md-3" style="padding-top: 25px;">
                                    <a id="search_maintenance" class="btn btn-primary" name="search"> Search</a>
                                </div>
                                <!-- End Col md 3 -->
                            </div>
                            <!--  end row -->
                            <!--  ////////////////// Registration Fee table /////////////  -->
                            <div class="row">
                                <div class="col-md-12">
                                    <script id="document-template" type="text/x-handlebars-template">
                                        <table id="unit_list" class="table table-bordered table-striped">
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
