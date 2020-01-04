@extends('auth.layout')

@section('title', '500')

@section('content')
    <div class="ex-page-content text-center">
        <div class="text-error">500</div>
        <h3 class="text-uppercase text-white font-600">Internal Server Error</h3>
        <p class="text-white">
            Why not try refreshing your page? or you can contact <a href="#" class="text-primary">support</a>
        </p>
        <br>
        <a class="btn-pyramd btn-pyramd-fix waves-effect waves-light" href="/"> Return Home</a>

    </div>
@endsection