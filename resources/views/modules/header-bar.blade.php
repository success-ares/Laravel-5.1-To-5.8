<div class="menu-extras">

    <ul class="nav navbar-nav navbar-right pull-right">
    @isset($user)
        @if($user)

            <li>
                <!-- Notification -->
                <div class="notification-box">
                    <ul class="list-inline m-b-0">
                        <li>
                            <a href="javascript:void(0);" class="right-bar-toggle">
                                <i class="zmdi zmdi-notifications-none"></i>
                            </a>
                            <div class="noti-dot hidden">
                                <span class="dot"></span>
                                <span class="pulse"></span>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- End Notification bar -->
            </li>

            <li class="dropdown user-box">
                <a href="" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown" aria-expanded="true">
                    @if($user->photo)
                        <img src="{{ '/images/avatars/'.$user->photo }}" alt="user-img" class="img-circle user-img">
                    @else
                        <img src="/assets/images/no_avatar.png" alt="user-img" class="img-circle user-img">
                    @endif
                </a>

                <ul class="dropdown-menu">
                    <li><a href="{{ route('site.profile') }}"><i class="ti-user m-r-5"></i> Profile</a></li>
                    @if($user->business)
                        <li><a href="{{ route('site.billing') }}"><i class="ti-money m-r-5"></i> Billing</a></li>
                        <li><a href="{{ route('site.plan') }}"><i class="ti-money m-r-5"></i> Plans</a></li>
                    @endif
                    <li><a href="{{ route('auth.logout') }}"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                </ul>
            </li>

        @else
			<li class="hidden-xs hidden-sm">
                <a href="/business">For business</a>
            </li>
			<li class="hidden-xs hidden-sm">
                <a href="/salespeople">For salespeople</a>
            </li>
            <li class="hidden-xs hidden-sm">
                <a href="{{ route('auth.login') }}">Log In</a>
            </li>
            <li class="hidden-xs hidden-sm">
                <a href="{{ route('auth.register') }}">Sign Up Free</a>
            </li>
        @endif

        @endisset


    </ul>
    <div class="menu-item">
        <!-- Mobile menu toggle-->
        <a class="navbar-toggle">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>
        <!-- End mobile menu toggle-->
    </div>
</div>