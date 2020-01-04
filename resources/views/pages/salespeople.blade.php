@extends('pages.layout')

@section('title', 'Join Pyramd for Sales | Pyramd')

@section('content')

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron salespeople-top top-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="container-inner fl-text">
                        <img class="salespeople-img" src="assets/images/salespeople-illustration.svg"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="application-form">
                        <div class="content">
                            <h1 class="white-c">Grow your Sales Network</h1>
                            <p class="white-c">Join Pyramd and start selling for your favourite businesses. Earn rewards for successful sales and cash out anytime.</p>
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
                            <h2 class="text-centered">How Pyramd Works</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-inner">
                <div class="row">
                    <div class="col-md-4">
                        <div class="container-inner feature">
                            <img src="assets/images/feature-circle2.png" alt=""/>
                            <h4 class="uppercase">Free Signup</h4>
                            <p>Sign up to Pyramd and submit leads and referrals to businesses in exchange for sales rewards. </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="container-inner feature">
                            <img src="assets/images/feature-circle2.png" alt=""/>
                            <h4 class="uppercase">Grow your Network</h4>
                            <p>Become a preferred salesperson with your business network and find new business connections through Pyramd. </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="container-inner feature">
                            <img src="assets/images/feature-circle2.png" alt=""/>
                            <h4 class="uppercase">Get Paid</h4>
                            <p>Get paid immediately for each successful sale you make. You can cash out your funds anytime. </p>
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
                        <h2>Why Choose Pyramd</h2>
                        <ul class="bullet-pt">
                            <li class="red">
                                <p>One easy to use system for all your business referrals and sales. </p>
                            </li>
                            <li class="red">
                                <p>Watch the progress of each lead and get paid as soon as your lead turns into a sale. </p>
                            </li>
                            <li class="red">
                                <p>Expand your reseller network by connecting with other businesses looking for more leads and sales.</p>
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