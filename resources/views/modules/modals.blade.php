{{-- Modals --}}
@if( !Auth::check() )
	<div id="login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabelLogin">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<a type="button" class="close" data-dismiss="modal"><span class="sprite close"></span></a>
					<div class="application-form">
						<h3 class="white-c">Log In</h3>
						<form action="{{ route('auth.postLogin') }}" method="POST">
							{{ csrf_field() }}
							<input type="email" name="email"  placeholder="Email" id="email" required><br/>
							<input type="password" name="password"  placeholder="Password"  id="password" required><br/>
							<button class="pm-button-style-3 pm-button" type="submit">Log In</button><br>
							<br>
							<a href="{{ route('auth.password.email') }}" class="white-c"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="signup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabelSignup">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<a type="button" class="close" data-dismiss="modal"><span class="sprite close"></span></a>
					<div class="application-form">
						<h3 class="white-c">Sign up Here</h3>
						<form action="{{ route('auth.postRegister') }}" method="POST">
							{{ csrf_field() }}

							<input type="email" name="email" value="{{ old('email') }}" placeholder="Email" id="email" required>
							<input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
							<input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
							<input type="password" name="password" placeholder="Password" required>
							<input type="password" name="password_confirmation" placeholder="Confirm password" required>
							<div class="checkbox">
								<input id="check" type="checkbox" name="terms">
								<label for="check"><span class="white-c">I accept <a href="{{ route('terms') }}" target="_blank" class="grey-c">Terms and Conditions</a></span></label>
							</div>
							<button class="pm-button-style-3 pm-button" type="submit">Sign Up</button>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
@endif