@extends('layout')

@section('title', 'Plans')

@section('content')

    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Select your plan</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="row">

                    <!--Pricing Column-->
                    <article class="pricing-column col-lg-6 col-md-6">
                        <div class="inner-box card-box">
                            <div class="plan-header text-center">
                                <h3 class="plan-title">Free</h3>
                                <h2 class="plan-price">NZ$ 0</h2>
                                <div class="plan-duration">Per Month</div>
                            </div>
                            <ul class="plan-stats list-unstyled text-center">
                                <li>5 Projects</li>
                                <li>1 GB Storage</li>
                                <li>No Domain</li>
                                <li>1 User</li>
                                <li>24x7 Support</li>
                            </ul>
                        </div>
                    </article>


                    <!--Pricing Column-->
                    <article class="pricing-column col-lg-6 col-md-6">
                        <div class="ribbon"><span>POPULAR</span></div>
                        <div class="inner-box card-box">
                            <div class="plan-header text-center">
                                <h3 class="plan-title">Business</h3>
                                <h2 class="plan-price">NZ$ 9.99</h2>
                                <div class="plan-duration">Per Month</div>
                            </div>
                            <ul class="plan-stats list-unstyled text-center">
                                <li>5 Projects</li>
                                <li>1 GB Storage</li>
                                <li>No Domain</li>
                                <li>1 User</li>
                                <li>24x7 Support</li>
                            </ul>

                            <div class="text-center">
                                <a href="{{ route('site.plan.buy') }}" class="btn btn-success btn-bordred btn-rounded waves-effect waves-light">Buy Now</a>
                            </div>
                        </div>
                    </article>

                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div>

@endsection