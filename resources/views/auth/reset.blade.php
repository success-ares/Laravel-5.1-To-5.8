@extends('auth.layout')

@section('title', 'Reset password')

@section('content')
<div class="m-t-40 card-box">
    <div class="text-center">
        <h4 class="text-uppercase font-bold m-b-0">Reset Password</h4>
    </div>
    <div class="panel-body">
        <form class="form-horizontal m-t-20" method="post" action="{{ route('auth.password.reset') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" type="email" name="email" placeholder="Enter email" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm password" required>
                </div>
            </div>

            <div class="form-group text-center m-t-20 m-b-0">
                <div class="col-xs-12">
                    <button class="btn-pyramd btn-pyramd-full waves-effect waves-light" type="submit">Reset Password</button>
                </div>
            </div>

        </form>

    </div>
</div>
<!-- end card-box-->

<div class="row">
    <div class="col-sm-12 text-center">
        <p class="text-white">Return to <a href="{{ route('auth.login') }}" class="text-white m-l-5"><b>Sign in</b></a></p>
    </div>
</div>
@endsection