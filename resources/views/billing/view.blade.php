@extends('layout')

@section('title', 'Billing information')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Billing information</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Billing details</h4>

					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label">First name</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{ $billing->first_name }}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Last name</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{ $billing->last_name }}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Business name</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{ $billing->business_name }}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Address</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{ $billing->address }}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Suburb</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{ $billing->suburb }}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">City</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{ $billing->city }}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{ $billing->country }}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Phone</label>
							<div class="col-sm-10">
								<p class="form-control-static">{{ $billing->phone }}</p>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-3">
								<a href="{{ route('site.billing.edit') }}" role="button" class="btn btn-warning waves-effect waves-light">Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Payment details</h4>
					@if($card)

						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-5 control-label">Name on Card</label>
								<div class="col-sm-7">
									<p class="form-control-static">{{ $card->Customers[0]->CardDetails->Name }}</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label">Card Number</label>
								<div class="col-sm-7">
									<p class="form-control-static">{{ $card->Customers[0]->CardDetails->Number }}</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label">Expiration Date</label>
								<div class="col-sm-7">
									<div class="row">
										<div class="col-xs-4">
											<p class="form-control-static">{{ $card->Customers[0]->CardDetails->ExpiryMonth }}</p>
										</div>
										<div class="col-xs-4">
											<p class="form-control-static">20{{ $card->Customers[0]->CardDetails->ExpiryYear }}</p>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="text-center">
									<a href="{{ route('site.billing.addCard') }}" role="button" class="btn btn-danger waves-effect waves-light">New Card</a>
								</div>
							</div>
						</div>
					@elseif($billing->directDebit)

						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-5 control-label">Account number</label>
								<div class="col-sm-7">
									<p class="form-control-static">{{ $billing->directDebit->account_number }}</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label">Account name</label>
								<div class="col-sm-7">
									<p class="form-control-static">{{ $billing->directDebit->account_name }}</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label">Bank name</label>
								<div class="col-sm-7">
									<p class="form-control-static">{{ $billing->directDebit->bank_name }}</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label">Status</label>
								<div class="col-sm-7">
									<p class="form-control-static">
										@if($billing->directDebit->status == 'pending')
											<span class="label label-info">Pending</span>
										@elseif($billing->directDebit->status == 'approved')
											<span class="label label-success">Approved</span>
										@elseif($billing->directDebit->status == 'declined')
											<span class="label label-danger">Declined</span>
										@endif
									</p>
								</div>
							</div>
							<div class="form-group">
								<div class="text-center">
									<a href="{{ route('site.billing.deleteDirect') }}" role="button"
									   class="btn btn-danger waves-effect waves-light"
									onclick="return confirm('Are you sure you want to delete?')">Delete</a>
								</div>
							</div>
						</div>

					@else

						<p>
							<a href="{{ route('site.billing.addCard') }}" role="button" class="btn btn-primary btn-block waves-effect waves-light">Add card</a>
						</p>
						<p class="text-center text-muted">OR</p>
						<p>
							<a href="{{ route('site.billing.addDirect') }}" role="button" class="btn btn-success btn-block waves-effect waves-light">Authorise direct debit</a>
						</p>

					@endif
				</div>
			</div>
		</div>
		<!-- end row -->
	</div>
@endsection