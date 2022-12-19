@extends('admin.admin_master');

@section('admin');

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">All Flat View</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Flat List</li>
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

                    <div class="box">
                        <div class="box-header with-border d-flex justify-content-between align-items-center">
                            <h3 class="box-title">Flat List</h3>
                            <a href="{{ route('unit.add') }}" class="btn btn-rounded btn-success mb-5">Add Flat</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="unit_list" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Floor No</th>
                                            <th>Flat No</th>
                                            <th>Flat Rent(Base Amount)</th>
                                            <th>Flat Service Charge</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $allUnitData as $key => $unit)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $unit['get_floor_name']['name'] }}</td>
                                            <td>{{ $unit->name }}</td>
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
        </section>

    </div>
</div>
<!-- /.content-wrapper -->
@endsection
