@extends('layout')

@section('title', 'Create billing details')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Create billing information</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Billing details</h4>

					<form class="form-horizontal" role="form" method="post" action="{{ route('site.billing.create') }}">
						{{ csrf_field() }}

						<div class="form-group">
							<label class="col-md-2 control-label" for="input_first_name">First name</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_first_name" name="first_name" value="{{ old('first_name') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_last_name">Last name</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_last_name" name="last_name" value="{{ old('last_name') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_business_name">Business name</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_business_name" name="business_name" value="{{ old('business_name') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_address">Address</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_address" name="address" value="{{ old('address') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_suburb">Suburb</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_suburb" name="suburb" value="{{ old('suburb') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_city">City</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_city" name="city" value="{{ old('city') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_country">Country</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_country" name="country" value="{{ old('country') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_phone">Phone</label>
							<div class="col-md-10">
								<input class="form-control" type="tel" id="input_phone" name="phone" value="{{ old('phone') }}" required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<!--/ meta -->
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Pyramd Tips</h4>

					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, dolor explicabo illo illum,
						in inventore ipsam mollitia numquam officiis praesentium tempore,
						unde ut? Numquam obcaecati, praesentium. Est, voluptatem voluptates? At.
					</p>
				</div>
			</div>

		</div>
		<!-- end row -->
	</div>
@endsection