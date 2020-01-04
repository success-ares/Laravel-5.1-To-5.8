@extends('layout')

@section('title', 'Withdrawal request')


@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Withdrawal request</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<form action="{{ route('admin.transaction.credit') }}" method="post" role="form" class="form-horizontal">
						{{ csrf_field() }}
						<input type="hidden" name="withdrawal_id" value="{{  $withdrawal->id }}">

						<div class="form-group">
							<label class="col-sm-2 control-label">Salesperson</label>
							<div class="col-sm-6">
								<p class="form-control-static">{{ $withdrawal->user->first_name.' '.$withdrawal->user->last_name }}</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Withdrawal amount</label>
							<div class="col-sm-6">
								<p class="form-control-static">${{ $withdrawal->amount }}</p>
							</div>
						</div>

						@if( $withdrawal->status )
							<div class="form-group">
								<label class="col-sm-2 control-label">Paid</label>
								<div class="col-sm-6">
									<p class="form-control-static">{{ $withdrawal->updated_at->toDayDateTimeString() }}</p>
								</div>
							</div>
						@else
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-6">
									<button type="submit" class="btn btn-sm btn-primary waves-effect waves-light">Confirm</button>
									<button class="btn btn-sm btn-warning waves-effect waves-light">Log issue</button>
								</div>
							</div>
						@endif
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