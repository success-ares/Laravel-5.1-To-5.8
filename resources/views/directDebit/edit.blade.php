@extends('layout')

@section('title', 'Edit request')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Edit request</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<form action="{{ route('admin.directDebit.update') }}" method="post" role="form" class="form-horizontal">
						{{ csrf_field() }}
						<input type="hidden" name="id" value="{{ $directDebit->id }}">

						<div class="form-group">
							<label class="col-sm-3 control-label">Account number</label>
							<div class="col-sm-6">
								<p class="form-control-static">{{ $directDebit->account_number }}</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Account name</label>
							<div class="col-sm-6">
								<p class="form-control-static">{{ $directDebit->account_name }}</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Bank name</label>
							<div class="col-sm-6">
								<p class="form-control-static">{{ $directDebit->bank_name }}</p>
							</div>
						</div>

						<div class="form-group">
							<label for="select-status" class="col-sm-3 control-label">Status</label>
							<div class="col-sm-3">
								<select id="select-status" class="form-control input-sm" name="status">
									<option value="pending" {{ $directDebit->status == 'pending' ? 'selected' : '' }}>Pending</option>
									<option value="approved" {{ $directDebit->status == 'approved' ? 'selected' : '' }}>Approved</option>
									<option value="declined" {{ $directDebit->status == 'declined' ? 'selected' : '' }}>Declined</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-sm btn-success waves-effect waves-light">Submit</button>
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