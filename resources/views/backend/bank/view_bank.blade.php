@extends('admin.admin_master');

@section('admin');

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">All Bank View</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Bank List</li>
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
                            <h3 class="box-title">Bank List</h3>
                            <a href="{{ route('bank.add') }}" class="btn btn-rounded btn-success mb-5">Add Bank</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Bank Name</th>
                                        <th>Bank Account No</th>
                                        <th>Bank Branch Name</th>
                                        <th>Bank Account Holder Name</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $allBanks as $key => $banks)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $banks->name }}</td>
                                            <td>{{ $banks->bank_account_no }}</td>
                                            <td>{{ $banks->bank_branch_name }}</td>
                                            <td>{{ $banks->bank_account_holder_name }}</td>
                                            <td>
                                                <a href="{{ route('bank.detail' , $banks->id) }}" class="btn btn-info mr-2">Edit</a>
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
