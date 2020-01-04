@extends('pages.layout')

@section('title', 'Join Pyramd for Business | Pyramd')

@section('content')

   <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron business-top top-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="container-inner fl-text">
                        <img class="business-img" src="assets/images/business-illustration.svg"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="application-form">
                        <div class="content">
                            <h1 class="white-c">Join Pyramd for Business</h1>
                            <p class="white-c">It's free to register your business on Pyramd. Create your business profile, add your products and services and watch your sales grow!</p>
                            <div class="separator"></div>
                            @if(Auth::check())
                                <a role="button" class="pm-button-style-3 pm-button" href="{{ route('site.dashboard') }}">Dashboard</a>
                            @else
                                <button class="pm-button-style-3 pm-button" data-toggle="modal" data-target="#signup">Sign Up</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="jumbotron light-grey">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container-inner text-centered">
                        <div class="text">
                            <h2 class="text-centered">How it Works </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-inner">
                <div class="row">
                    <div class="col-md-4">
                        <div class="container-inner feature">
                            <img src="assets/images/feature-circle.png" alt=""/>
                            <h4 class="uppercase">List your Products</h4>
                            <p>List your products and services on your Pyramd business page and offer rewards for successful referrals. </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="container-inner feature">
                            <img src="assets/images/feature-circle.png" alt=""/>
                            <h4 class="uppercase">Invite your Sales Team</h4>
                            <p>Invite your sales network to join you on Pyramd and keep track of leads, sales and sales rewards.  </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="container-inner feature">
                            <img src="assets/images/feature-circle.png" alt=""/>
                            <h4 class="uppercase">Go Public</h4>
                            <p>Set your referrals programs to public and allow other Pyramd users to refer leads and sales to you for rewards.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="container-inner">
                        <h2>Grow your Business</h2>
                        <ul class="bullet-pt">
                            <li class="black">
                                <p>Streamline your salesforce into one easy to manage system, where you can keep track of salespeople, leads, sales and reward payments in one place.</p>
                            </li>
                            <li class="black">
                                <p>Encourage other Pyramd users to send leads to your business by posting referral programs and rewards to your business profile. </p>
                            </li>
                            <li class="black">
                                <p>Expand your business network, raise your business profile and create a community of users on Pyramd.</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <img class="block-center" src="assets/images/image-placeholder1.gif" alt="">
                </div>
            </div>
        </div>
    </div>

    @if( !Auth::check() )
        <div class="jumbotron light-grey sign-up">
            <div class="container">
                <div class="container-inner">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="text">
                                <h2>Join Pyramd for Business Today</h2>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <button class="sendButton pm-button-style-2 pm-button" data-toggle="modal" data-target="#signup">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection