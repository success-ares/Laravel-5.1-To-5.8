@extends('auth.layout')

@section('title', 'Sign In')

@section('content')
<div class="m-t-40 card-box">
    <div class="text-center">
        <h4 class="text-uppercase font-bold m-b-0">Sign In</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal m-t-20" method="POST" action="{{ route('auth.postLogin') }}">
            {{ csrf_field() }}
            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="email" name="email" placeholder="Email">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </div>
            </div>

            <div class="form-group ">
                <div class="col-xs-12">
                    <div class="checkbox checkbox-custom">
                        <input id="checkbox-signup" type="checkbox" name="remember">
                        <label for="checkbox-signup">
                            Remember me
                        </label>
                    </div>

                </div>
            </div>

            <div class="form-group text-center m-t-30">
                <div class="col-xs-12">
                    <button class="btn-pyramd btn-pyramd-full waves-effect waves-light" type="submit">Log In</button>
                </div>
            </div>

            <div class="form-group m-t-30 m-b-0">
                <div class="col-sm-12">
                    <a href="{{ route('auth.password.email') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                </div>
            </div>
        </form>

    </div>
</div>
<!-- end card-box-->

<div class="row">
    <div class="col-sm-12 text-center">
        <p class="text-white">Don't have an account? <a href="{{ route('auth.register') }}" class="text-white m-l-5"><b>Sign Up</b></a></p>
    </div>
</div>
@endsection