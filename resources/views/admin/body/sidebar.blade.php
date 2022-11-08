@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();

@endphp
<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">

        <div class="user-profile">
            <div class="ulogo">
                <a href="">
                    <!-- logo for regular state and mobile devices -->
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="{{asset('backend/images/logo-dark.png')}}" alt="">
                        <h3><b>Flat Owners</b> Admin</h3>
                    </div>
                </a>
            </div>
        </div>

        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="{{ ($route == 'dashboard')? 'active' : '' }}">
                <a href="{{route('dashboard')}}">
                    <i data-feather="pie-chart"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="header nav-small-cap">Entry Basic Information</li>


            <li class="treeview">
                <a href="#"><i data-feather="layers"></i><span>Basic Setting</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>

                <ul class="treeview-menu">
                @if(Auth::user()->usertype == 'admin')
                    <li class="treeview {{ ($prefix == '/users')? 'active' : '' }}">
                        <a href="{{route('user.view')}}">
                            <i data-feather="user"></i>
                            <span>Owner Information</span>
                            <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('user.view')}}"><i class="ti-more"></i>Owner List</a></li>
                            <li><a href="{{route('user.add')}}"><i class="ti-more"></i>Add Owner</a></li>
                            <li><a href="{{route('user.assign_flat')}}"><i class="ti-more"></i>Assign Flat to Owner</a></li>
                        </ul>
                    </li>
                @endif
                    <li class="treeview {{ ($prefix == '/profile')?'active':'' }}">
                        <a href="#">
                            <i data-feather="grid"></i> <span>Manage Profile</span>
                            <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('profile.view') }}"><i class="ti-more"></i>Your Profile</a></li>
                            <li><a href="{{ route('password.view') }}"><i class="ti-more"></i>Change Password</a></li>

                        </ul>
                    </li>
                    <li class="treeview {{( $prefix == '/floor' )? 'active' : '' }}">
                        <a href="#">
                            <i data-feather="home"></i>
                            <span>Floor Information</span>
                            <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('floor.view') }}"><i class="ti-more"></i>Floor List</a></li>
                            <li><a href="{{ route('floor.add') }}"><i class="ti-more"></i>Add Floor</a></li>
                        </ul>
                    </li>
                    <li class="treeview {{( $prefix == '/unit' )? 'active' : '' }}">
                        <a href="#">
                            <i data-feather="home"></i>
                            <span>Unit Information</span>
                            <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('unit.view') }}"><i class="ti-more"></i>Unit List</a></li>
                            <li><a href="{{ route('unit.add') }}"><i class="ti-more"></i>Add Unit</a></li>
                        </ul>
                    </li>
                    <li class="treeview {{($prefix == '/utility')? 'active' : ''}}">
                        <a href="#">
                            <i data-feather="users"></i>
                            <span>Owner Utility</span>
                            <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('utility.view')}}"><i class="ti-more"></i>Utility List</a></li>
                            <li><a href="{{ route('utility.add')}}"><i class="ti-more"></i>Add Utility</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i data-feather="users"></i>
                            <span>Tenants Information</span>
                            <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href=""><i class="ti-more"></i>Tenants List</a></li>
                            <li><a href=""><i class="ti-more"></i>Add Tenant</a></li>
                        </ul>
                    </li>

                    <li class="treeview {{ ($prefix == '/employee')? 'active' : '' }}">
                        <a href="#">
                            <i data-feather="users"></i>
                            <span>Employee Information</span>
                            <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ ($route == 'employee.view')?'active':'' }}"><a href="{{route('employee.view')}}"><i class="ti-more"></i>Employee List</a></li>
                            <li class="{{ ($route == 'employee.add')?'active':'' }}"><a href="{{route('employee.add')}}"><i class="ti-more"></i>Add Employee</a></li>
                        </ul>
                    </li>

                </ul>


            </li>

            <li class="header nav-small-cap">Accounting Information</li>

            <li class="treeview {{ ($prefix == '/servicecharge')? 'active' : '' }}">
                <a href="#">
                    <i data-feather="dollar-sign"></i>
                    <span>Service Charge Collec</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('servicecharge.view')}}"><i class="ti-more"></i>All Service charge</a></li>
                    <li><a href="{{route('servicecharge.add')}}"><i class="ti-more"></i>Add Service charge</a></li>
                </ul>
            </li>

            <li class="treeview {{ ($prefix == '/maintenance')? 'active' : '' }}">
                <a href="#">
                    <i data-feather="dollar-sign"></i>
                    <span>Maintenance Cost</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ ($route == 'maintenance.view')?'active':'' }}"><a href="{{route('maintenance.view')}}"><i class="ti-more"></i>Maintenance Cost Search</a></li>
                    <li class="{{ ($route == 'maintenance.add')?'active':'' }}"><a href="{{route('maintenance.add')}}"><i class="ti-more"></i>Add Maintenance Cost</a></li>
                    <li class="{{ ($route == 'maintenance.salary')?'active':'' }}"><a href="{{route('maintenance.salary')}}"><i class="ti-more"></i>Salary Disbursement</a></li>
                </ul>
            </li>


            <li class="header nav-small-cap">Project/Programme Management</li>

            <li class="treeview">
                <a href="#"><i data-feather="layers"></i><span>Project/Programme Setting</span><span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span></a>

                <ul class="treeview-menu">

                    <li class="treeview {{ ($prefix == '/project')?'active':'' }}">
                        <a href="#">
                            <i data-feather="grid"></i> <span>Project</span>
                            <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('project.view') }}"><i class="ti-more"></i>All Project</a></li>
                            <li><a href="{{ route('project.add') }}"><i class="ti-more"></i>Add New Project</a></li>
                        </ul>
                    </li>

                </ul>
            </li>

            <li class="header nav-small-cap">Results and Reports</li>

            <li class="treeview" {{ ($prefix == '/report')? 'active' : '' }}>
                <a href="#">
                    <i data-feather="users"></i>
                    <span>Report</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ ($route == 'report.monthly.balancesheet')?'active':'' }}"><a href="{{route('report.monthly.balancesheet')}}"><i class="ti-more"></i>Monthly Report</a></li>
                </ul>
            </li>

            <li class="header nav-small-cap">Others Actions</li>

            <li class="treeview {{ ($prefix == '/notice')? 'active' : '' }}">
                <a href="#">
                    <i data-feather="users"></i>
                    <span>Notice Board</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ ($route == 'notice.view')? 'active' : '' }}"><a href="{{ route('notice.view') }}"><i class="ti-more"></i>Notice List</a></li>
                    <li class="{{ ($route == 'notice.add')? 'active' : '' }}"><a href="{{ route('notice.add') }}"><i class="ti-more"></i>Add Notice</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i data-feather="users"></i>
                    <span>Email/SMS Alert</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="ti-more"></i>Email/SMS List</a></li>
                    <li><a href=""><i class="ti-more"></i>Add Email/SMS</a></li>
                </ul>
            </li>

        </ul>
    </section>

    <div class="sidebar-footer">
        <!-- item-->
        <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Settings" aria-describedby="tooltip92529"><i class="ti-settings"></i></a>
        <!-- item-->
        <a href="mailbox_inbox.html" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="ti-email"></i></a>
        <!-- item-->
        <a href="{{route('admin.logout')}}" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="ti-lock"></i></a>
    </div>
</aside>
