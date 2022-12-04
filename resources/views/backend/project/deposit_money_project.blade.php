@extends('admin.admin_master');

@section('admin');
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Deposit money for project</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="mdi mdi-home-outline"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Deposit money for project</li>
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
                            <h4 class="box-title">Deposit Money To Project</h4>
                        </div>
                        <!-- /.box-header -->

                        <form class="form-horizontal" method="POST" action="{{route('project_deposit.money')}}">
                            @csrf
                            <div class="box-body">
                                <h4 class="mt-0 mb-20">1. Deposit Money Information:</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Project</label>
                                            <select name="project_id" required="" class="form-control select2 project_id">
                                                @foreach($allProjectlist as $project)
                                                    <option value="{{$project->id}}" selected="">{{$project->name}}</option>
                                                @endforeach
                                                <option selected="selected" disabled="" value="">Select Project</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Floor</label>
                                            <select name="floor_id" id="on_select_floor" required="" class="form-control select2">
                                                @foreach($allFloorlist as $floor)
                                                    <option value="{{$floor->id}}" selected="">{{$floor->name}}</option>
                                                @endforeach
                                                <option selected="selected" disabled="" value="">Select Floor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Flat</label>
                                            <select name="unit_id" id="assign_subject_id"  required="" class="form-control select2 find_user_by_unit">
                                                <option selected="selected" value="">Select Floor First?</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User Name</label>
                                            <select name="user_id" id="flatowner_info" class="form-control select2" style="width: 100%;">
                                                <option selected="selected" value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- Get what is the Money Due --}}

                                    <div class="col-md-6 ">
                                        <div class="form-group has-error">
                                            <label>Due Amount For Project</label>
                                            <input name="project_due_amount" disabled type="number" class="form-control project_due_amount" required="required" placeholder="Total Due">
                                        </div>
                                    </div>
                                    {{-- How Much to Pay --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Amount To Pay in Total</label>
                                            <input name="project_amount_per_head" disabled type="number" class="form-control project_amount_per_head" required="required" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group has-success">
                                            <label>Amount wants to pay now</label>
                                            <input name="amount" type="number" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Deposited Date</label>
                                            <input class="form-control" name="project_cost_date" type="date" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea rows="5" class="form-control" name="project_cost_note" placeholder="Write note"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-rounded btn-danger">Reset</button>
                                <input type="submit" class="btn btn-rounded btn-info" value="Deposit Money">
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
