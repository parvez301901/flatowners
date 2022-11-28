@extends('admin.admin_master');

@section('admin');

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Add New Maintenance Cost</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New Maintenance Cost</li>
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
                            <h4 class="box-title">Entry Maintenance Cost</h4>
                        </div>
                        <!-- /.box-header -->
                        <form class="form-horizontal" method="POST" action="{{route('maintenance.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Cost Information:</h4>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input name="amount" type="number" class="form-control" required="required" placeholder="Cost">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>From which account to spend?</label>
                                            <select name="from_where_to_spend" required class="form-control select2 from-where-to-spend">
                                                <option value="petty_cash">From Petty Cash</option>
                                                <option value="bank">From Bank</option>
                                                <option value="petty_cash">From where to spend?</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Floor</label>
                                            <select name="floorId" class="form-control select2 required">
                                                <option value="">Select Floor</option>
                                                @foreach( $allFloorlist as $floor )
                                                    <option value="{{ $floor->id }}">{{ $floor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 banklist d-none">
                                        <div class="form-group">
                                            <label>Select Bank</label>
                                            <select name="bank_id" class="form-control select2" style="width:100%">
                                                <option value="">Select Back</option>
                                                @foreach( $allBanklist as $bank )
                                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Unit</label>
                                            <select name="unitId" class="form-control select2">
                                                <option value="">Select Unit</option>
                                                @foreach( $allUnitlist as $unit )
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
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
                                            <input class="form-control" name="maintenanceCostDate" type="date" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea rows="5" class="form-control" name="maintenancenote" placeholder="Write note"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Slips/Receipt</label>
                                            <input type="file" name="maintenanceImage" accept="image/png, image/gif, image/jpeg" class="form-control" id="image" >
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
            </div>

        </section>
    </div>
</div>

<script type="text/javascript">

</script>
@endsection
