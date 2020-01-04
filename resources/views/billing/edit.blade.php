@extends('layout')

@section('title', 'Edit billing details')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Edit billing details</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Billing details</h4>

					<form class="form-horizontal" role="form" method="post" action="{{ route('site.billing.update') }}">
						{{ csrf_field() }}

						<div class="form-group">
							<label class="col-md-2 control-label" for="input_first_name">First name</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_first_name" name="first_name" value="{{ $billing->first_name }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_last_name">Last name</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_last_name" name="last_name" value="{{ $billing->last_name }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_business_name">Business name</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_business_name" name="business_name" value="{{ $billing->business_name }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_address">Address</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_address" name="address" value="{{ $billing->address }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_suburb">Suburb</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_suburb" name="suburb" value="{{ $billing->suburb }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_country">Country</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_country" name="country" value="{{ $billing->country }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_city">City</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_city" name="city" value="{{ $billing->city }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_phone">Phone</label>
							<div class="col-md-10">
								<input class="form-control" type="tel" id="input_phone" name="phone" value="{{ $billing->phone }}" required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
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