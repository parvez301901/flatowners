@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Flat Information</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Flat Detail</li>
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
                            <h4 class="box-title">Flat Detail information</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="{{ route('unit.update' , $detailUnit->id) }}">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Flat Info:</h4>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Floor No.</label>
                                            <select name="floor_id" class="form-control select2">
                                                <option value="">Select Floor</option>
                                                @foreach( $allFloorData as $floor )
                                                    <option value="{{ $floor->id }}" {{ ($floor->id == $detailUnit->floor_id) ? 'selected' : '' }} >{{ $floor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Flat No.</label>
                                            <input name="name" type="text" value="{{ $detailUnit->name }}" class="form-control"  required="required" placeholder="Flat Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>User Name</label>
                                            <select name="user_id" class="form-control select2">
                                                <option value="6">Select User</option>
                                                @foreach( $allFlatOwners as $flatOwners )
                                                    <option value="{{ $flatOwners->id }}" {{ ($flatOwners->id == $detailUnit->user_id) ? 'selected' : '' }} >{{ $flatOwners->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Rent Amount</label>
                                            <input name="rent" type="number" value="{{ $detailUnit->rent }}" class="form-control" required="required" placeholder="Rent">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Service Charge</label>
                                            <input name="serviceCharge" type="number" value="{{ $detailUnit->serviceCharge }}" class="form-control" required="required" placeholder="Service Charge">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Update Flat">
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
