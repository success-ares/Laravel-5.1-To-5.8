@extends('layout')

@section('title', 'Authorise direct debit')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Authorise direct debit</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Direct debit details</h4>

					<form class="form-horizontal" role="form" method="post" action="{{ route('site.billing.saveDirect') }}">
						{{ csrf_field() }}

						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-account-number">Account number</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="input-account-number" name="account_number" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-account-name">Account name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="input-account-name" name="account_name" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="input-bank-name">Bank name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="input-bank-name" name="bank_name" required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-3">
								<button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Pyramd Tips</h4>

					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda consequuntur culpa dicta dolorum,
						earum eos iste itaque iure laboriosam,
						modi molestias placeat praesentium quo repudiandae similique soluta tempora veritatis voluptates!
					</p>
				</div>
			</div>
		</div>
		<!-- end row -->
	</div>
@endsection