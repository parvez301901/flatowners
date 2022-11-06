@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Add project</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Project</li>
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
                            <h4 class="box-title">Entry Project information</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="{{ route('project.store') }}">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Project Info:</h4>
                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <input name="name" type="text" class="form-control" required="required" placeholder="Project Name">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Project Budget</label>
                                            <input name="budget" type="number" class="form-control" required="required" placeholder="Project Budget">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Project Description</label>
                                            <textarea name="project_description" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Project Start Date</label>
                                            <input name="project_start_date" type="date" class="form-control" required="required" placeholder="Project Start Date">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Project End Date</label>
                                            <input name="project_end_date" type="date" class="form-control" required="required" placeholder="Project End Date">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Project Status</label>
                                            <select name="status" required="" class="form-control select2">
                                                <option value="" selected="" disabled="">Select Status</option>
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
                                <input type="submit" class="btn btn-rounded btn-info" value="Add Project">
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
