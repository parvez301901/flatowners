@extends('admin.admin_master');

@section('admin');

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">All User View</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Assign User</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="col-12">
                        <!-- Basic Forms -->
                        <div class="box">
                            <div class="box-header with-border d-flex justify-content-between align-items-center">
                                <h3 class="box-title">Assign User</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Select Data:</h4>
                                <form class="form-horizontal" method="POST" action="{{ route('assign.store') }}">
                                    <div class="row">
                                        @csrf
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Floor</label>
                                                <select name="user" id="user_id" required="" class="form-control select2">
                                                    @foreach($allUserData as $user)
                                                        <option value="{{$user->id}}" selected="">{{$user->name}}</option>
                                                    @endforeach
                                                        <option selected="selected" value="">Select Owner</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Flat Owner Name</label>
                                                <select name="floor" id="on_select_floor" required="" class="form-control select2">
                                                    @foreach($allFloorlist as $floor)
                                                        <option value="{{$floor->id}}" selected="">{{$floor->name}}</option>
                                                    @endforeach
                                                        <option selected="selected" value="">Select Floor</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Unit</label>
                                                <select name="unit" id="assign_subject_id"  required="" class="form-control select2 assign_unit">
                                                    <option selected="selected" value="">Select Unit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p class="d-none message">This Flat already Assigned, Do you want to update that?</p>
                                            <input type="submit" class="btn btn-rounded btn-info" value="Update Flat Info">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="box">
                            <div class="box-header with-border d-flex justify-content-between align-items-center">
                                <h3 class="box-title">Unit List By Owner Name</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Floor No</th>
                                            <th>Unit No</th>
                                            <th>Owner Name</th>
                                            <th>Unit Rent(Base Amount)</th>
                                            <th>Unit Service Charge</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach( $allUnitData as $key => $unit)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $unit['get_floor_name']['name'] }}</td>
                                                <td>{{ $unit->name }}</td>
                                                <td>@if (!is_null($unit['get_user_name']['name'])) {{ $unit['get_user_name']['name'] }} @endif</td>
                                                <td>{{ $unit->rent }}</td>
                                                <td>{{ $unit->serviceCharge }}</td>
                                                <td>
                                                    <a href="{{ route('unit.detail' , $unit->id) }}" class="btn btn-success mr-2">Details</a>
                                                    <a href="{{ route('unit.detail' , $unit->id) }}" class="btn btn-info mr-2">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->


                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
<!-- /.content-wrapper -->
@endsection
