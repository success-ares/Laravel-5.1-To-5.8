@extends('auth.layout')

@section('title', 'Set password')

@section('content')
<div class="m-t-40 card-box">
    <div class="text-center">
        <h4 class="text-uppercase font-bold m-b-0">Set Password</h4>

        <p class="text-muted m-b-0 font-13 m-t-20">Please set a password for your account.</p>
    </div>
    <div class="panel-body">
        <form class="form-horizontal m-t-20" method="post" action="{{ route('auth.password.inviteSet') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $user->id }}">
            <input type="hidden" name="activation_code" value="{{ $user->activation_code }}">
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="password" class="form-control" name="password" placeholder="Password" required minlength="6">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required minlength="6" >
                </div>
            </div>

            <div class="form-group text-center m-t-20 m-b-0">
                <div class="col-xs-12">
                    <button class="btn-pyramd btn-pyramd-full waves-effect waves-light" type="submit">Set password</button>
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