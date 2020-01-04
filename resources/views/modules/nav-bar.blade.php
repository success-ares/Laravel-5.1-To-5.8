<div class="navbar-custom">
    <div class="container">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
            @isset($user)
				@if (!$user)
					<li class="hidden-md hidden-lg">
						<a href="/business">For Business</a>
					</li>
					<li class="hidden-md hidden-lg">
						<a href="/salespeople">For Salespeople</a>
					</li>
					<li class="hidden-md hidden-lg">
						<a href="{{ route('auth.login') }}">Log In</a>
					</li>
					<li class="hidden-md hidden-lg">
						<a href="{{ route('auth.register') }}">Sign Up Free</a>
					</li>
                @endif
            @endisset
				<li>
					<a href="{{ route('site.dashboard') }}"><i class="zmdi zmdi-view-dashboard"></i> Home</a>
                </li>
            @isset($user)
                @if ($user)
                    @if($user->type == 'user')
                        <li>
                            <a href="{{ route('site.ref.programList') }}"><i class="ti-user"></i> Referrals I Made</a>
                        </li>
                        @if($user->business)
                            <li><a href="{{ route('site.biz.index') }}"><i class="ti-money m-r-5"></i> My Business</a></li>
                            <li><a href="{{ route('site.ref.bizReferrals') }}"><i class="ti-user"></i> Business Referrals</a></li>
                            <li><a href="{{ route('site.sales.index') }}"><i class="ti-user"></i> Sales People</a></li>
                            <li><a href="{{ route('site.sales.invite') }}"><i class="ti-wand m-r-5"></i> Invite Referrer</a></li>
                        @else
                            <li><a href="{{ route('site.biz.accept') }}"><i class="ti-money m-r-5"></i> Become a Business</a></li>
                        @endif
						<li><a href="{{ route('site.friend') }}"><i class="ti-user"></i> Friends</a></li>
                    @elseif($user->type == 'admin')
                        <li><a href="{{ route('admin.transaction.index') }}"><i class="ti-server m-r-5"></i> Transactions</a></li>
                        <li><a href="{{ route('admin.directDebit.index') }}"><i class="ti-server m-r-5"></i> Direct Debits</a></li>
                        <li><a href="{{ route('admin.withdrawal.index') }}"><i class="ti-server m-r-5"></i> Withdrawals</a></li>
                    @endif
                @endif
            @endisset
            </ul>
            <!-- End navigation menu  -->
        </div>
    </div>
</div>