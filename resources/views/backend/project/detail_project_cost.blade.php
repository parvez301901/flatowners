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
                                <li class="breadcrumb-item active" aria-current="page">Detail Project</li>
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
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Detail Project Cost</h4>
                        </div>
                        <form class="form-horizontal" method="POST" action="{{route('project_cost.update', $allexpensedata->id)}}" enctype="multipart/form-data">
                            @csrf
                            <input name="project_id" type="hidden" class="form-control" value="{{$allexpensedata->project_id}}" required="required" placeholder="Cost">
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Cost Information:</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input name="amount" type="number" class="form-control" required="required" value="{{$allexpensedata->amount}}" placeholder="Cost">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Utility</label>
                                            <select name="utility_id" class="form-control select2">
                                                <option value="">Select Utility</option>
                                                @foreach( $allUtilitylist as $utility )
                                                    <option value="{{ $utility->id }}" @if($utility->id == $allexpensedata->utility_id) selected @endif>{{ $utility->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Responsible User</label>
                                            <select name="user_id" class="form-control select2">
                                                <option value="">Select User</option>
                                                @foreach( $users as $user )
                                                    <option value="{{ $user->id }}" @if($user->id == $allexpensedata->user_id) selected @endif>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Maintenance Cost added Date</label>
                                            <input class="form-control" name="project_cost_date" type="date" value="{{$allexpensedata->project_cost_date}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea rows="5" class="form-control" name="project_cost_note" placeholder="Write note">{{$allexpensedata->project_cost_note}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Slips/Receipt</label>
                                            <input type="file" src="{{ (!empty($allexpensedata->project_cost_image))? url('upload/maintenance_images/'.$allexpensedata->project_cost_image):url('upload/no_image.jpg') }}" name="project_cost_image" accept="image/png, image/gif, image/jpeg" class="form-control" id="image" >
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <img id="showImage" src="{{ (!empty($allexpensedata->project_cost_image))? url('upload/maintenance_images/'.$allexpensedata->project_cost_image):url('upload/no_image.jpg') }}" style="width: 100px; width: 100px; border: 1px solid #000000;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Add Project Cost">
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
