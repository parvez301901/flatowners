@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Make SMS</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Write SMS</li>
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
                            <h4 class="box-title">Write and Send SMS</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. SMS Info:</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Write Message</label>
                                            <textarea class="form-control"></textarea>
                                            <p class="count-word"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Flat No.</label>
                                            <select name="religion" required="" class="form-control">
                                                <option value="" selected="" disabled="">Select Who Will get SMS?</option>
                                                {{-- <option value="islam" {{ ($editData->religion == "islam" ? "selected": "") }} >Islam</option> --}}
                                                <option value="group">Group</option>
                                                <option value="individual">Individual</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Rent Amount</label>
                                            <input name="rent" type="number" class="form-control" required="required" placeholder="Rent">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Service Charge</label>
                                            <input name="serviceCharge" type="number" class="form-control" required="required" placeholder="Service Charge">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Add Flat">
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
