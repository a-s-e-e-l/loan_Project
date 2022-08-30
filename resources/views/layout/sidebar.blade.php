<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li>
                    <!-- User Profile-->
                    <div class="user-profile dropdown m-t-20">
                        <div class="user-pic">
                            <img src="{{asset('assets/images/login/logo-icon.png')}}" alt="users"
                                 class="rounded-circle img-fluid"/>
                        </div>
                        <div class="user-content hide-menu m-t-10">
                            @if( auth()->check() )
                                <h5 class="m-b-10 user-name font-medium">{{ auth()->user()->name }}</h5>
                            @else
                                {
                                <h5 class="m-b-10 user-name font-medium">{{ __('dashboard.user')}}</h5>--}}
                                }
                            @endif
                            {{--                            <h5 class="m-b-10 user-name font-medium">{{$data->name}}</h5>--}}
                            <a href="javascript:void(0)" class="btn btn-circle btn-sm m-r-5" id="Userdd"
                               role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="ti-settings"></i>
                            </a>
                            <a href="{{ url('logout') }}" title="Logout" class="btn btn-circle btn-sm">
                                <i class="ti-power-off"></i>
                            </a>
                            <div class="dropdown-menu animated flipInY" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-user m-r-5 m-l-5"></i> {{ __('dashboard.My Profile')}} </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-wallet m-r-5 m-l-5"></i> {{ __('dashboard.My Balance')}}</a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-email m-r-5 m-l-5"></i> {{ __('dashboard.Inbox')}}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-settings m-r-5 m-l-5"></i> {{ __('dashboard.Account Setting')}}</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                                        <i class="fa fa-power-off m-r-5 m-l-5"></i> {{ __('dashboard.Log Out')}}
                                    </button>
                                </form>
                                {{--                                <a class="dropdown-item" href="{{ url('logout') }}">--}}
                                {{--                                    <i class="fa fa-power-off m-r-5 m-l-5"></i> {{ __('dashboard.Log Out')}}</a>--}}
                            </div>
                        </div>
                    </div>
                    <!-- End User Profile-->
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                       aria-expanded="false">
                        <i class="icon-Car-Wheel"></i>
                        <span class="hide-menu">{{ __('dashboard.Dashboards')}}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item">
                            <a href="{{ url('users') }}" class="sidebar-link">
                                <i class="icon-Record"></i>
                                <span class="hide-menu">{{ __('dashboard.Users')}}</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('transactions') }}" class="sidebar-link">
                                <i class="icon-Record"></i>
                                <span class="hide-menu">{{ __('dashboard.Transactions')}}</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('debts') }}" class="sidebar-link">
                                <i class="icon-Record"></i>
                                <span class="hide-menu">{{ __('dashboard.Debts')}}</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('register') }}" class="sidebar-link">
                                <i class="icon-Record"></i>
                                <span class="hide-menu">{{ __('dashboard.addadmin')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                       href="{{ url('logout') }}" aria-expanded="false">
                        <i class="mdi mdi-directions"></i>
                        <span class="hide-menu">{{ __('dashboard.Log Out')}} </span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
