@extends('auth.layout')

@section('title', '404')

@section('content')
    <div class="ex-page-content text-center">
        <div class="text-error">404</div>
        <h3 class="text-uppercase text-white font-600">Page not Found</h3>
        <p class="text-white">
            It's looking like you may have taken a wrong turn. Don't worry... it happens to
            the best of us. You might want to check your internet connection. Here's a little tip that might
            help you get back on track.
        </p>
        <br>
        <a class="btn-pyramd btn-pyramd-fix waves-effect waves-light" href="/"> Return Home</a>

    </div>
@endsection