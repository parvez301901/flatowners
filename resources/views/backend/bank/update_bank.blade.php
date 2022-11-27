@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Add New Utility</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New Utility</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-lg-8 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Entry Utility information</h4>
                        </div>
                        <!-- /.box-header -->
                        <form class="form-horizontal" method="POST" action="{{ route('bank.store') }}">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Bank Info:</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Bank Name</label>
                                            <input name="name" type="text" class="form-control" required="required" placeholder="Bank Name">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Bank Account No</label>
                                            <input name="bank_account_no" type="text" class="form-control" required="required" placeholder="Bank Account No">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Bank Branch Name</label>
                                            <input name="bank_branch_name" type="text" class="form-control" required="required" placeholder="Bank Branch Name">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Bank Account Holder Name</label>
                                            <input name="bank_account_holder_name" type="text" class="form-control" required="required" placeholder="Bank Account Holder Name">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Update Bank">
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
