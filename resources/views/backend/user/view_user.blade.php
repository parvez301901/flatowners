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
                                <li class="breadcrumb-item active" aria-current="page">All User List</li>
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
                            <h3 class="box-title">User List</h3>
                            <a href="{{ route('user.add') }}" class="btn btn-rounded btn-success mb-5">Add Use</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="unit_list" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Position</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Floor</th>
                                        <th>Unit</th>
                                        <th>Phone</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $allUnitData as $key => $unit)
                                        <tr @if($key == 0) style="display: none" @endif>
                                            <td>{{ $key }}</td>
                                            <td>Flat Owner</td>
                                            <td>{{ $unit['get_user_name']['name'] }}</td>
                                            <td>{{ $unit['get_user_name']['email'] }}</td>
                                            <td>{{ $unit['get_floor_name']['name'] }}</td>
                                            <td>{{ $unit->name }}</td>
                                            <td>{{ $unit['get_user_name']['phone'] }}</td>
                                            <td>
                                                <a href="{{ route('user.detail' , $unit['get_user_name']['id']) }}" class="btn btn-success mr-2">Details</a>
                                                <a href="{{ route('user.detail' , $unit['get_user_name']['id']) }}" class="btn btn-info mr-2">Edit</a>
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
