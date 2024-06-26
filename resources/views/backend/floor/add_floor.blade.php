@extends('admin.admin_master');
@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Add New Floor</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New Floor</li>
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
                            <h4 class="box-title">Entry Floor information</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="{{ route('floor.store') }}">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Floor Info:</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Floor Name</label>
                                            <input name="name" type="text" class="form-control" required="required" placeholder="Floor Name">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Add Floor">
                            </div>

                        </form>
                    </div>
                    <!-- /.box -->
                </div>


                <div class="col-lg-6 col-12">
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

