@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Project Detail</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$detailData->name}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-light rounded w-60 h-60">
                                <i class="text-white mr-0 font-size-24 mdi mdi-chart-line"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Total Budget</p>
                                <h3 class="text-white mb-0 font-weight-500">BDT {{$detailData->project_budget}} </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-primary-light rounded w-60 h-60">
                                <i class="text-primary mr-0 font-size-24 mdi mdi-account-multiple"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Total Collected</p>
                                <h3 class="text-white mb-0 font-weight-500">BDT ??? </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-warning-light rounded w-60 h-60">
                                <i class="text-warning mr-0 font-size-24 mdi mdi-car"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Balance Remaining</p>
                                <h3 class="text-white mb-0 font-weight-500">????</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-warning-light rounded w-60 h-60">
                                <i class="text-warning mr-0 font-size-24 mdi mdi-car"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Last Date of Deposit</p>
                                <h3 class="text-white mb-0 font-weight-500">????</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-warning-light rounded w-60 h-60">
                                <i class="text-warning mr-0 font-size-24 mdi mdi-car"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Finish Date of Project</p>
                                <h3 class="text-white mb-0 font-weight-500">????</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-6">
                    <div class="box overflow-hidden pull-up">
                        <div class="box-body">
                            <div class="icon bg-info-light rounded w-60 h-60">
                                <i class="text-info mr-0 font-size-24 mdi mdi-sale"></i>
                            </div>
                            <div>
                                <p class="text-mute mt-20 mb-0 font-size-16">Did Not Deposited</p>
                                <h3 class="text-white mb-0 font-weight-500">?????</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Recent Expense List</h4>
                        </div>
                        <!-- /.box-header -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-lg-6 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Recent Deposit Money</h4>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Project Name</th>
                                        <th>Amout</th>
                                        <th>Expense Head</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $allFloors as $key => $floor)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $floor->name }}</td>
                                            <td>
                                                <a href="{{ route('floor.detail' , $floor->id) }}" class="btn btn-success mr-2">Details</a>
                                                <a href="{{ route('floor.detail' , $floor->id) }}" class="btn btn-info mr-2">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-lg-6 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Add Project Cost</h4>
                        </div>
                        <!-- /.box-header -->
                        <form class="form-horizontal" method="POST" action="{{route('project_cost.store')}}" enctype="multipart/form-data">
                            @csrf
                            <input name="project_id" type="hidden" class="form-control" value="{{$detailData->id}}" required="required" placeholder="Cost">
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Cost Information:</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input name="amount" type="number" class="form-control" required="required" placeholder="Cost">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Utility</label>
                                            <select name="utilityId" class="form-control select2">
                                                <option value="">Select Utility</option>
                                                @foreach( $allUtilitylist as $utility )
                                                    <option value="{{ $utility->id }}">{{ $utility->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Responsible User</label>
                                            <select name="userId" class="form-control select2">
                                                <option value="">Select User</option>
                                                @foreach( $users as $user )
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Maintenance Cost added Date</label>
                                            <input class="form-control" name="project_cost_date" type="date" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea rows="5" class="form-control" name="project_cost_note" placeholder="Write note"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Slips/Receipt</label>
                                            <input type="file" name="project_cost_image" accept="image/png, image/gif, image/jpeg" class="form-control" id="image" >
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <img id="showImage" src="{{ (!empty($user->image))? url('upload/user_images/'.$user->image):url('upload/no_image.jpg') }}" style="width: 100px; width: 100px; border: 1px solid #000000;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Add Maintenance">
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-lg-6 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Deposit Money To Project</h4>
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
