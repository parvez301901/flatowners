@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Add New Notice</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New Notice</li>
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
                            <h4 class="box-title">Entry Notice</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="{{ route('notice.store') }}">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Write Notice:</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Notice Title</label>
                                            <input name="noticeTitle" type="text" class="form-control" required="required" placeholder="Notice Title">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Notice Description</label>
                                            <textarea name="noticeDescription" type="text" class="form-control" required="required" placeholder="Notice Title"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="mt-0 mb-20">2. Notice Notification:</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Notification By</label>
                                            <div class="c-inputs-stacked d-flex">
                                                <div class="mr-20">
                                                    <input type="checkbox" name="email_notification" value="on" id="checkbox_123">
                                                    <label for="checkbox_123" class="block">Email</label>
                                                </div>
                                                <div class="mr-20">
                                                    <input type="checkbox" name="sms_notification" value="on" id="checkbox_234">
                                                    <label for="checkbox_234" class="block">SMS</label>
                                                </div>
                                                <div class="mr-20">
                                                    <input type="checkbox" name="dashboard_notification" value="on" id="checkbox_345">
                                                    <label for="checkbox_345" class="block">Dashboard View</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Notification To</label>
                                            <select name="notice_to" required="" class="form-control select2">
                                                <option value="allFlatowner" >All Flat Owner</option>
                                                <option value="allTenant" >All Tenants</option>
                                                <option value="" selected="" disabled="">Select Option</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="mt-0 mb-20">3. Notice Notification:</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Notification For</label>
                                            <select name="notice_for" required="" class="form-control select2">
                                                <option value="allFlatowner" >Paying Service Charge</option>
                                                <option value="allTenant" >Paying Programme Charge</option>
                                                <option value="" selected="" disabled="" >Select Reason</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Notification Status</label>
                                            <select name="notice_status" required="" class="form-control select2">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="" selected="" disabled="" >Select Status</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Add Notice">
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-lg-4 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Floor Information</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Floor Information:</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>List of Flats & Units</label>

                                            <div class="c-inputs-stacked d-flex">
                                                <div class="mr-20">
                                                    <input type="checkbox" name="email" id="checkbox_123">
                                                    <label for="checkbox_123" class="block">Flat 1B</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Update Flat Info">
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
