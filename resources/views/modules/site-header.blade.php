<header>
	<div class="mobile-menu-btn">
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="logo-container">
					<a href="{{ URL::to('/') }}" class="logo">
						<img src="/assets/images/pyramd-icon.png" width="62" />
						<img src="/assets/images/pyramd_logo.png" />
					</a>
                </div>
                <div class="menu pull-right">
					<div id="navigation">
						<!-- Navigation Menu-->
						<ul class="navigation-menu">
							<li>
								<a href="{{ URL::to('business') }}">For Business</a>
							</li>
							<li>
								<a href="{{ URL::to('salespeople') }}">For Salespeople</a>
							</li>
							@if(Auth::check())
								<li><a href="{{ route('auth.logout') }}">Log Out</a></li>
								<li><a href="{{ route('site.dashboard') }}">Dashboard</a></li>
							@else
								<li><button data-toggle="modal" data-target="#login">Log In</button></li>
								<li><button data-toggle="modal" data-target="#signup">Sign Up Free</button></li>
							@endif
						</ul>
						<!-- End navigation menu  -->
					</div>
                </div>
            </div>
        </div>
    </div>
</header>