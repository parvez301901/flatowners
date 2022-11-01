@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Notice Detail</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Notice Detail</li>
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
                            <h4 class="box-title">Notice Details</h4>
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
                                            <input name="noticeTitle" type="text" value="{{ $detailNotice->noticeTitle }}" class="form-control" required="required" placeholder="Notice Title">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Notice Description</label>
                                            <textarea name="noticeDescription" type="text" class="form-control" required="required" placeholder="Notice Title">{{ $detailNotice->noticeDescription }}</textarea>
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
                                                    <input type="checkbox" name="email_notification" {{ ($detailNotice->email_notification == "on" ? "checked": "") }} value="on" id="checkbox_123">
                                                    <label for="checkbox_123" class="block">Email</label>
                                                </div>
                                                <div class="mr-20">
                                                    <input type="checkbox" name="sms_notification" {{ ($detailNotice->sms_notification == "on" ? "checked": "") }} value="on" id="checkbox_234">
                                                    <label for="checkbox_234" class="block">SMS</label>
                                                </div>
                                                <div class="mr-20">
                                                    <input type="checkbox" name="phone_notification" {{ ($detailNotice->phone_notification == "on" ? "checked": "") }} value="on" id="checkbox_345">
                                                    <label for="checkbox_345" class="block">Phone</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Notification To</label>
                                            <select name="notice_to" required="" class="form-control select2">
                                                <option value="allFlatowner" {{ ($detailNotice->notice_to == "allFlatowner" ? "selected": "") }} >All Flat Owner</option>
                                                <option value="allTenant" {{ ($detailNotice->notice_to == "allTenant" ? "selected": "") }} >All Tenants</option>
                                                <option value="" disabled="">Select Option</option>
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
                                                <option value="paying_service_charge" {{ ($detailNotice->notice_for == "paying_service_charge" ? "selected": "") }} >Paying Service Charge</option>
                                                <option value="paying_programme_charge" {{ ($detailNotice->notice_for == "paying_programme_charge" ? "selected": "") }} >Paying Programme Charge</option>
                                                <option value="" disabled="" >Select Reason</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Notification Status</label>
                                            <select name="notice_status" required="" class="form-control select2">
                                                <option value="active" {{ ($detailNotice->notice_status == "active" ? "selected": "") }}>Active</option>
                                                <option value="inactive" {{ ($detailNotice->notice_status == "inactive" ? "selected": "") }}>Inactive</option>
                                                <option value=""  disabled="" >Select Status</option>
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
