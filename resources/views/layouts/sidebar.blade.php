<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
        <a class="sidebar-brand brand-logo" href="{{ route('home') }}"><img src="{{asset('images/logo.svg')}}" alt="logo"></a>
        <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="{{ route('home') }}"><img
                src="{{asset('images/logo-mini.svg')}}" alt="logo"></a>
    </div>
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{asset(!empty(Auth::user()->images) ? Auth::user()->images :'/images/face0.jpg')}}" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column pr-1">
                    <span class="font-weight-medium mb-2">{{ Auth::user()->name }}</span>
                    <span class="font-weight-normal">
                        @if(Auth::user()->type ==1)
                            Supper Admin
                        @elseif(Auth::user()->type ==2)
                            Admin
                        @elseif(Auth::user()->type ==3)
                            Client
                        @elseif(Auth::user()->type ==4)
                            Employee
                        @endif

                    </span>
                </div>
                <span class="badge badge-danger text-white ml-0 rounded">3</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
               aria-controls="ui-basic">
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                <span class="menu-title">Projects</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="/project">Project List</a>
                    </li>
                </ul>
            </div>
        </li>
        @if(Auth::user()->type ==1)
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#user-manage" aria-expanded="false"
               aria-controls="user-manage">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Manage User</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="user-manage">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user')}}">User List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user-role')}}">Role List</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif
        <li class="nav-item sidebar-actions">
            <div class="nav-link">
                <div class="mt-4">
                    <div class="border-none">
                        <p class="text-black">Notification</p>
                    </div>
                    <ul class="mt-4 pl-0">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout mr-2 text-primary"></i> Sign Out </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</nav>
