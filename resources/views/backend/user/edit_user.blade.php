@extends('admin.admin_master')
@section('admin')


 <div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h3 class="page-title">Edit User</h3>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                  <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
            <!-- Basic Forms -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Update User</h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form method="post" action="{{route('user.update', $editData->id)}}">
                                @csrf
                                <div class="box-body">

                                    <div class="form-group row">
                                        <label for="inputname" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" class="form-control" required="required" id="inputname" value="{{ $editData->name }}" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputemail" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" class="form-control" required="required" id="inputemail" value="{{ $editData->email }}" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputphone" class="col-sm-2 control-label">Phone number</label>
                                        <div class="col-sm-10">
                                            <input name="phone" type="tel" class="form-control" required="required" id="inputphone" value="{{ $editData->phone }}" required="">
                                        </div>
                                    </div>

                                    <!-- select -->
                                    <div class="form-group row">
                                        <label for="inputtype" class="col-sm-2 control-label">Select</label>
                                        <div class="col-sm-10">
                                            <select name="usertype" required="required" class="form-control">
                                                <option value="" selected="" disabled="">Select Role</option>
                                                <option value="admin" {{ ($editData->usertype == "admin" ? "selected": "") }}>Admin</option>
                                                <option value="flatowner" {{ ($editData->usertype == "flatowner" ? "selected": "") }}>Flat Owner</option>
                                                <option value="manger" {{ ($editData->usertype == "manger" ? "selected": "") }}>Manager</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
                                </div>
                                <!-- /.box-footer -->
                            </form>

                        </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

	    </section>
    </div>
</div>
@endsection
