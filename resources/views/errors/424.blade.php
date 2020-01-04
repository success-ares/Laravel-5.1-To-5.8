@extends('auth.layout')

@section('title', '424')

@section('content')
    <div class="ex-page-content text-center">
        <div class="text-error">424</div>
        <h3 class="text-uppercase text-white font-600">PayPal: An error in the processing of payment.</h3>
        <p class="text-white">
            {{ $exception->getMessage() }}
        </p>
        <br>
        <a class="btn-pyramd btn-pyramd-fix waves-effect waves-light" href="/"> Return Home</a>
    </div>
@endsection