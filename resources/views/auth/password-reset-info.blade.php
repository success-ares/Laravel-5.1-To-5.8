@extends('auth.layout')

@section('title', 'Password reset')

@section('content')
    <div class="m-t-40 card-box">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0">Password reset</h4>
        </div>
        <div class="panel-body text-center">
            <img src="/assets/images/mail_confirm.png" alt="img" class="thumb-lg m-t-20 center-block" />
            <p class="text-muted font-13 m-t-20">
                An email has been sent to <b>{{ $userEmail }}</b>.
                Please click on the link in the email to reset your password.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <p class="text-white">Return to <a href="{{ route('auth.login') }}" class="text-white m-l-5"><b>Sign in</b></a></p>
        </div>
    </div>
@endsection