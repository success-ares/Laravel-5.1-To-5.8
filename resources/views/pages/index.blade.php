@extends('pages.layout')

@section('title', 'Grow your Business Network | Pyramd')

@section('content')
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron home-top top-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-centered">
                    <h1 class="white-c">Sign up. Send leads. Get paid.</h1>
					<p class="white-c">Sign up and grow your sales network</p>
					@if(Auth::check())
						<a role="button" class="pm-button-style-3 pm-button" href="{{ route('site.dashboard') }}">Dashboard</a>
					@else
						<button class="pm-button-style-3 pm-button" data-toggle="modal" data-target="#signup">Get started</button>
					@endif
                </div>
            </div>
        </div>
    </div>


    <div class="border-separator">
        <div class="container">
            <div class="row">
				<div class="inner-container">
					<div class="col-md-6 p-50">
						<h2>Best for Business</h2>
						<div class="separator"></div>
						<p>
							Use the Pyramd system to boost your business sales. Simply register as a business on Pyramd and add your referral program and rewards. Invite your network of resellers to join up and use Pyramd to keep track of your sales personnel, their sales and rewards. You can even advertise public referral programs so that other users can bring new leads and sales to your business as well.
						</p>
					</div>
					<div class="col-md-6">
						<img class="block-center img-responsive" src="assets/images/img-placeholder.png" alt="">
					</div>
				</div>
            </div>
        </div>
    </div>
	

	<div class="container">
		<div class="row">
			<div class="inner-container">
				<div class="col-md-6">
					<img class="block-center img-responsive" src="assets/images/img-placeholder.png" alt="">
				</div>
				<div class="col-md-6 p-50">
					<h2>Best for Sales</h2>
					<div class="separator"></div>
					<p>
						Sign up as a user to Pyramd and start earning rewards for referrals and sales. You’ll be able to browse listed businesses and their public referral programs. Know someone who’s been looking for that product or service? Refer them to a business in Pyramd and earn rewards for each successful sale. Each business will clearly list their reward program so start browsing and get paid for sales leads today!
					</p>
				</div>
			</div>
		</div>
	</div>


    <div class="jumbotron bottom-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container-inner text-centered">
                        <div class="text">
                            <h2>Join Now </h2>
							<div class="separator-white"></div>
                            <p>
                                Join now and start earning – whether it’s more leads and sales for your business, or more rewards for each referral sale you make. Pyramd is a business network spreading across NZ and making it easy to grow your business and sales connections.
                            </p>
                            @if(Auth::check())
								<a role="button" class="pm-button-style-4 pm-button" href="{{ route('site.dashboard') }}">Dashboard</a>
							@else
								<button class="pm-button-style-4 pm-button" data-toggle="modal" data-target="#signup">Get started</button>
							@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection