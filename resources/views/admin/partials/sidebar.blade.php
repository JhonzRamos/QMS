<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <!-- Sidebar user panel -->
            @include('admin.partials.userpanel')
            
            @can('risks_access')
                <li class="treeview @if(Request::segment(2) == 'risks' ) active menu-open @endif"  >
                    <a href="{{ route('admin.risks.index') }}">
                        <i class="fa fa-warning"></i>
                        <span class="title">Risk Register</span>
                    </a>
                </li>
            @endcan
@can('management_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                        <span class="title">Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                    @can('riskmatrix_access')
                        <li class="@if(Request::segment(2) == 'riskmatrix' ) active active-sub @endif">
                            <a href="{{ route('admin.riskmatrix.index') }}">
                                <i class="fa fa-table"></i>
                                <span class="title">Risk Matrix</span>
                            </a>
                        </li>
                    @endcan
                    @can('risktreatmentoptions_access')
                        <li class="@if(Request::segment(2) == 'risktreatmentoptions' ) active active-sub @endif">
                            <a href="{{ route('admin.risktreatmentoptions.index') }}">
                                <i class="fa fa-info-circle"></i>
                                <span class="title">Risk Treatment Options</span>
                            </a>
                        </li>
                    @endcan
                    @can('risklikelihood_access')
                        <li class="@if(Request::segment(2) == 'risklikelihood' ) active active-sub @endif">
                            <a href="{{ route('admin.risklikelihood.index') }}">
                                <i class="fa fa-clock-o"></i>
                                <span class="title">Risk Likelihood</span>
                            </a>
                        </li>
                    @endcan
                    @can('riskconsequence_access')
                        <li class="@if(Request::segment(2) == 'riskconsequence' ) active active-sub @endif">
                            <a href="{{ route('admin.riskconsequence.index') }}">
                                <i class="fa fa-gavel"></i>
                                <span class="title">Risk Consequence</span>
                            </a>
                        </li>
                    @endcan
                    @can('riskexposure_access')
                        <li class="@if(Request::segment(2) == 'riskexposure' ) active active-sub @endif">
                            <a href="{{ route('admin.riskexposure.index') }}">
                                <i class="fa fa-eye"></i>
                                <span class="title">Risk Exposure</span>
                            </a>
                        </li>
                    @endcan
                    @can('responsibility_access')
                        <li class="@if(Request::segment(2) == 'responsibility' ) active active-sub @endif">
                            <a href="{{ route('admin.responsibility.index') }}">
                                <i class="fa fa-users"></i>
                                <span class="title">Responsibility Group</span>
                            </a>
                        </li>
                    @endcan
                    @can('strategies_access')
                        <li class="@if(Request::segment(2) == 'strategies' ) active active-sub @endif">
                            <a href="{{ route('admin.strategies.index') }}">
                                <i class="fa fa-align-justify"></i>
                                <span class="title">Strategies</span>
                            </a>
                        </li>
                    @endcan
                    @can('riskcategory_access')
                        <li class="@if(Request::segment(2) == 'riskcategory' ) active active-sub @endif">
                            <a href="{{ route('admin.riskcategory.index') }}">
                                <i class="fa fa-tags"></i>
                                <span class="title">Risk Category</span>
                            </a>
                        </li>
                    @endcan
                    </ul>
                </li>
            @endcan


              @can('user_management_access')
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-users"></i>
                                    <span class="title">User Management</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">

                                @can('role_access')
                                <li class="{{Request::segment(2) == 'roles' ? 'active active-sub' : '' }}">
                                        <a href="{{ route('admin.roles.index') }}">
                                            <i class="fa fa-briefcase"></i>
                                            <span class="title">
                                                Roles
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                                @can('user_access')
                                <li class="{{ Request::segment(2) == 'users' ? 'active active-sub' : '' }}">
                                        <a href="{{ route('admin.users.index') }}">
                                            <i class="fa fa-user"></i>
                                            <span class="title">
                                               Users
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                                </ul>
                            </li>
                        @endcan


                        <li class="{{  (Request::path() == 'change_password')? 'active' : ''}}">
                            <a href="{{ route('auth.change_password') }}">
                                <i class="fa fa-key"></i>
                                <span class="title">Change Password</span>
                            </a>
                        </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">Logout</span>
                </a>
            </li>
        </ul>
    </section>
</aside>