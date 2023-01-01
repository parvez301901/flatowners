@extends('admin.admin_master');

@section('admin');
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Add New User</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New User</li>
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
                            <h4 class="box-title">Entry User information</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="{{ route('users.store') }}"  enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. User Info:</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input name="name" type="text" class="form-control" required="required" placeholder="User Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input name="email" type="email" class="form-control" required="required" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input name="password" type="password" class="form-control" required="required" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input name="phone" type="tel" class="form-control" placeholder="Phone Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Present Address</label>
                                            <textarea rows="5" class="form-control" name="presentaddress" placeholder="Present Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Permanent Address</label>
                                            <textarea rows="5" class="form-control" name="permanentaddress" placeholder="Permanent Address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>NID Number</label>
                                            <input name="nid" type="number" class="form-control" placeholder="NID Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Communications</label>

                                            <div class="c-inputs-stacked d-flex">
                                                <div class="mr-20">
                                                    <input type="checkbox" name="email_nofication" value="on" id="checkbox_123">
                                                    <label for="checkbox_123" class="block">Email</label>
                                                </div>
                                                <div class="mr-20">
                                                    <input type="checkbox" name="sms_nofication" value="on" id="checkbox_234">
                                                    <label for="checkbox_234" class="block">SMS</label>
                                                </div>
                                                <div class="mr-20">
                                                    <input type="checkbox" name="phone_nofication" value="on" id="checkbox_345">
                                                    <label for="checkbox_345" class="block">Phone</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Religion</label>
                                            <select name="religion" required="" class="form-control">
                                                <option value="" selected="" disabled="">Select Religion</option>
                                                {{--
                                                <option value="islam" {{ ($editData->religion == "islam" ? "selected": "") }} >Islam</option>
                                                <option value="hindu" {{ ($editData->religion == "hindu" ? "selected": "") }} >Hindu</option>
                                                <option value="buddhist" {{ ($editData->religion == "buddhist" ? "selected": "") }} >Buddhist</option>
                                                <option value="others" {{ ($editData->religion == "others" ? "selected": "") }} >Others</option>
                                                --}}
                                                <option value="islam">Islam</option>
                                                <option value="hindu">Hindu</option>
                                                <option value="buddhist">Buddhist</option>
                                                <option value="others">Others</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="gender" required="" class="form-control">
                                                <option value="" selected="" disabled="">Select Gender</option>
                                                <option value="Male" >Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h4 class="mt-0 mb-20">2. Access & Others:</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User Role</label>
                                            <select name="usertype" required="required" class="form-control">
                                                <option value="admin">Admin</option>
                                                <option value="flatowner">Flat Owner</option>
                                                <option value="manger">Manager</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User Image</label>
                                            <input type="file" name="image" accept="image/png, image/gif, image/jpeg" class="form-control" id="image" >
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
                                <input type="submit" class="btn btn-rounded btn-info" value="Add User">
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-lg-6 col-12">
                    <!-- Basic Forms -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Flat Information</h4>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h4 class="mt-0 mb-20">1. Important Notification:</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Floor</label>
                                        <select name="floor" id="on_select_floor" required="" class="form-control select2">
                                            <option selected="selected" disabled="" value="">Select Floor</option>
                                            @foreach($allFloorlist as $floor)
                                                <option value="{{$floor->id}}" selected="">{{$floor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Flat</label>
                                        <select name="unit" id="assign_subject_id"  required="" class="form-control select2">
                                            <option selected="selected" value="">Select Flat</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Flat Information</h4>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h4 class="mt-0 mb-20">1. Important Notification:</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul>
                                        <li>01. Bill Pending</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>

        </section>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endsection
