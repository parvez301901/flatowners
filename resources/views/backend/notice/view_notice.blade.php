@extends('admin.admin_master');

@section('admin');

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">All Notice View</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Notice List</li>
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
                            <h3 class="box-title">Utility List</h3>
                            <a href="{{ route('notice.add') }}" class="btn btn-rounded btn-success mb-5">Add Notice</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Notice</th>
                                        <th>Description</th>
                                        <th>Email Notify</th>
                                        <th>SMS Notify</th>
                                        <th>Dashboard Notify</th>
                                        <th>notice_to</th>
                                        <th>notice_for</th>
                                        <th>notice_status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $allNoticeData as $key => $notice)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $notice->noticeTitle }}</td>
                                            <td>{{ $notice->noticeDescription }}</td>
                                            <td>{{ $notice->email_notification }}</td>
                                            <td>{{ $notice->sms_notification }}</td>
                                            <td>{{ $notice->dashboard_notification }}</td>
                                            <td>{{ $notice->notice_to }}</td>
                                            <td>{{ $notice->notice_for }}</td>
                                            <td>{{ $notice->notice_status }}</td>
                                            <td>
                                                <a href="{{ route('notice.detail' , $notice->id) }}" class="btn btn-success mr-2">Details</a>
                                                <a href="{{ route('notice.detail' , $notice->id) }}" class="btn btn-info mr-2">Edit</a>

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
