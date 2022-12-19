@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Save & Send SMS</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Write SMS</li>
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
                            <h4 class="box-title">Write and Send SMS</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="{{ route('sms.send') }}">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. SMS Info:</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Write Message</label>
                                            <textarea name="message" class="form-control"></textarea>
                                            <p class="count-word"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Select Users</label>
                                            <ul style="list-style: none; column-count: 3; padding: 0;">
                                                @foreach ($allUnits as $key => $unitInfo)
                                                <li>
                                                    <input type="checkbox" id="md_checkbox_{{$unitInfo->id}}" name="phones[]" value="{{$unitInfo['get_user_name']['phone']}}" class="chk-col-success" />
                                                    <label for="md_checkbox_{{$unitInfo->id}}">{{$unitInfo['get_user_name']['name']}} - {{$unitInfo->name}}</label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Send SMS">
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
