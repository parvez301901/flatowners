@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Add Sub Project</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Sub Project</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-lg-6 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Entry Project information</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="{{ route('project.sub_project_store') }}">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Project Info:</h4>
                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Sub Project Name</label>
                                    <select name="project_id" class="form-control select2">
                                        <option value="">Select Parent Project</option>
                                        @foreach( $allProjects as $project )
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Sub Project Name</label>
                                            <input name="name" type="text" class="form-control" required="required" placeholder="Project Name">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Sub Project Budget</label>
                                            <input name="sub_project_budget" type="number" class="form-control" required="required" placeholder="Project Budget">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Sub Project Description</label>
                                            <textarea name="sub_project_description" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Sub Project Start Date</label>
                                            <input name="project_start_date" type="date" class="form-control" required="required" placeholder="Project Start Date">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Sub Project End Date</label>
                                            <input name="project_end_date" type="date" class="form-control" required="required" placeholder="Project End Date">
                                        </div>
                                        <p class="date-diff-message d-none text-danger"><i>End Date</i> must not be before <i>Start Date</i></p>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Sub Project Status</label>
                                            <select name="sub_project_status" required="" class="form-control select2">
                                                <option value="" selected="" disabled="">Select Status</option>
                                                <option value="complete" >Complete</option>
                                                <option value="active" >Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info add_project_button" value="Add Project">
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-12">

                            <div class="box">
                                <div class="box-header with-border d-flex justify-content-between align-items-center">
                                    <h3 class="box-title">Utility List</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Utility Name</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach( $allUtilityData as $key => $unit)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $unit->name }}</td>
                                                    <td>
                                                        <a href="{{ route('utility.detail' , $unit->id) }}" class="btn btn-success mr-2">Details</a>
                                                        <a href="{{ route('utility.detail' , $unit->id) }}" class="btn btn-info mr-2">Edit</a>
                                                        <a href="{{ route('utility.delete' , $unit->id) }}" class="btn btn-danger mr-2">delete</a>
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

        </section>
    </div>
</div>

@endsection
