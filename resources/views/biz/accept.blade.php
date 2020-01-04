@extends('layout')

@section('title', 'Become a business')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">My Business</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<div class="row">
						<div class="col-sm-12">
							<div class="text-center">
								<h3 class="font-600">Are you sure you want to become a business user?</h3>
								<p class="text-muted"> Register your business with Pyramd and start receiving leads from other Pyramd users.
									How it works: <br/>1. Create your referral programs for your different products and services<br/>2. Your referral programs can be public or only shown to specific salespeople<br/>
									3. Offer a small reward for a successful lead – eg, $10 or 5% of the sale value<br/>
									4. Watch the leads come in and grow your business!                          
								</p>
								<hr>

								<form class="form-horizontal" role="form" method="post" action="{{ route('site.biz.postAccept') }}">
									{{ csrf_field() }}
									<div class="form-group">
										<div class="checkbox checkbox-primary">
											<input id="checkbox1" type="checkbox" name="accept" required>
											<label for="checkbox1">
												Accept <span class="text-muted"><a href="{{ route('terms') }}" target="_blank">terms and conditions</a></span>
											</label>
										</div>
									</div>

									<button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Yes</button>
									<a class="btn btn-primary waves-effect waves-light m-t-10" href="{{ route('site.dashboard') }}" role="button">Cancel</a>

								</form>

							</div>
						</div><!-- end col -->
					</div><!-- end row -->
				</div>
				<!--/ meta -->
			</div>
		</div>
		<!-- end row -->
	</div>
@endsection