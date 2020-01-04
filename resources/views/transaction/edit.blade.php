@extends('layout')

@section('title', 'Edit transaction')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Edit transaction</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<form action="{{ route('admin.transaction.update') }}" method="post" role="form" class="form-horizontal">
						{{ csrf_field() }}
						<input type="hidden" name="id" value="{{ $transaction->id }}">

						<div class="form-group">
							<label class="col-sm-2 control-label">Business</label>
							<div class="col-sm-6">
								<p class="form-control-static">{{ $transaction->biz_name }}</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Salesperson</label>
							<div class="col-sm-6">
								<p class="form-control-static">{{ $transaction->first_name.' '.$transaction->last_name }}</p>
							</div>
						</div>

						{{-- if it's not lead --}}
						@if($transaction->lead)
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-6">
									<p class="form-control-static"><span class="label label-info">Lead</span></p>
								</div>
							</div>
						@else
							<div class="form-group">
								<label class="col-sm-2 control-label">Referral Value</label>
								<div class="col-sm-6">
									<p class="form-control-static">${{ $transaction->value or 0 }}</p>
								</div>
							</div>
						@endif

						<div class="form-group">
							<label class="col-sm-2 control-label">Commission</label>
							<div class="col-sm-6">
								<p class="form-control-static">${{ (float)$transaction->amount }}</p>
							</div>
						</div>

						<div class="form-group">
							<label for="select-status" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-2">
								@if($transaction->paid_status == 'Paid')
									<p class="form-control-static">{{ $transaction->paid_status }}</p>
								@else
									<select id="select-status" class="form-control input-sm" name="paid_status">
										<option value="Pending" {{ $transaction->paid_status == 'Pending' ? 'selected' : '' }}>Pending</option>
										<option value="Paid" {{ $transaction->paid_status == 'Paid' ? 'selected' : '' }}>Paid</option>
										<option value="Attention" {{ $transaction->paid_status == 'Attention' ? 'selected' : '' }}>Attention</option>
									</select>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-6">
								@if($transaction->paid_status !== 'Paid')
									<button type="submit" class="btn btn-sm btn-success waves-effect waves-light">Submit</button>
								@endif
									<a href="{{ URL::previous() }}" role="button" class="btn btn-sm btn-primary waves-effect waves-light">
										Back
									</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Pyramd Tips</h4>

				</div>
			</div>
		</div>
	</div>
@endsection