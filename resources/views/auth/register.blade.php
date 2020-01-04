@extends('auth.layout')

@section('title', 'Sign Up')

@section('content')
	<div class="m-t-40 card-box">
		<div class="text-center">
			<h4 class="text-uppercase font-bold m-b-0">Sign up to Pyramd Referrals</h4>
		</div>
		<div class="panel-body">
			<form class="form-horizontal m-t-20" method="post" action="{{ route('auth.postRegister') }}">
				{{ csrf_field() }}

				@if(isset($friendId))
					<input type="hidden" name="friend_id" value="{{ $friendId }}">
				@endif

				<div class="form-group ">
					<div class="col-xs-12">
						<input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
					</div>
				</div>

				<div class="form-group ">
					<div class="col-xs-12">
						<input class="form-control" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
					</div>
				</div>

				<div class="form-group ">
					<div class="col-xs-12">
						<input class="form-control" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
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

				<div class="form-group">
					<div class="col-xs-12">
						<div class="checkbox checkbox-custom">
							<input id="checkbox-signup" type="checkbox" name="terms" required>
							<label for="checkbox-signup">I accept <a href="{{ route('terms') }}" target="_blank">Terms and Conditions</a></label>
						</div>
					</div>
				</div>

				<div class="form-group text-center m-t-40">
					<div class="col-xs-12">
						<button class="btn-pyramd btn-pyramd-full waves-effect waves-light" type="submit">
							Register
						</button>
					</div>
				</div>

			</form>
		</div>
	</div>
	<!-- end card-box -->

	<div class="text-center">
		<p class="text-white">Already have an account?<a href="{{ route('auth.login') }}" class="text-white m-l-5"><b>Sign In</b></a></p>
	</div>
@endsection