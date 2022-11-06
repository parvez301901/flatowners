@extends('admin.admin_master');

@section('admin');

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">All Project View</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Project List</li>
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
                            <h3 class="box-title">Project List</h3>
                            <a href="{{ route('project.add') }}" class="btn btn-rounded btn-success mb-5">Add Project</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Budget</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $allProject as $key => $project)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $project->name }}</td>
                                            <td>{{ $project->project_budget }}</td>
                                            <td>{{ $project->project_start_date }}</td>
                                            <td>{{ $project->project_end_date }}</td>
                                            <td>{{ $project->project_status }}</td>
                                            <td>
                                                <a href="{{ route('project.detail' , $project->id) }}" class="btn btn-success mr-2">Details</a>
                                                <a href="{{ route('project.detail' , $project->id) }}" class="btn btn-info mr-2">Edit</a>
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
