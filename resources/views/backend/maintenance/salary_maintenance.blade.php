@extends('admin.admin_master');

@section('admin');

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">All Employee View</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Employee List</li>
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
                            <h3 class="box-title">Employee List</h3>
                            <a href="{{ route('employee.add') }}" class="btn btn-rounded btn-success mb-5">Add Employee</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Position</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Basic Salary</th>
                                        <th>Bonus / Deduction</th>
                                        <th>Final Salary</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $allEmployee as $key => $employee)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $employee->usertype }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td><span class="basic_salary">{{ $employee->salary }}</span></td>
                                        <td><input name="bonus_or_deduction" type="number" class="form-control bonus_or_deduction" value="0" /></td>
                                        <td><input name="final_salary" type="number" disabled class="form-control total" value="{{ $employee->salary }}" /></td>
                                        <td>
                                            <a href="{{ route('employee.detail' , $employee->id) }}" class="btn btn-success mr-2">Details</a>
                                            <a href="{{ route('employee.detail' , $employee->id) }}" class="btn btn-info mr-2">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="text-center"><h1>Total Salary: <Span class="final-salary"></Span></h1></div>
                                <div class="container mt-5">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            @if($all_matched)
                                                <a href="#" data-salary="" class="btn btn-success mr-2 ">Salary for This Month already Disbursed</a>
                                            @else
                                                <a href="#" data-salary="" class="btn btn-success mr-2 insert-salary-expense">Disburse Salary</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <p class="message d-none">Salary Disbursed Successfully</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
<!-- /.content-wrapper -->
@endsection
