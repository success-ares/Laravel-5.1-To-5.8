@extends('auth.layout')

@section('title', 'Sign In')

@section('content')
<div class="m-t-40 card-box">
    <div class="text-center">
        <h4 class="text-uppercase font-bold m-b-0">Reset Password</h4>

        <p class="text-muted m-b-0 font-13 m-t-20">Enter your email address and we'll send you an email with instructions to reset your password.  </p>
    </div>
    <div class="panel-body">
        <form class="form-horizontal m-t-20" method="post" action="{{ route('auth.password.postEmail') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" type="email" name="email" placeholder="Enter email" required>
                </div>
            </div>

            <div class="form-group text-center m-t-20 m-b-0">
                <div class="col-xs-12">
                    <button class="btn-pyramd btn-pyramd-full waves-effect waves-light" type="submit">Send Email</button>
                </div>
            </div>

        </form>

    </div>
</div>
<!-- end card-box-->

<div class="row">
    <div class="col-sm-12 text-center">
        <p class="text-white">Already have an account?<a href="{{ route('auth.login') }}" class="text-white m-l-5"><b>Sign In</b></a></p>
    </div>
</div>
@endsection