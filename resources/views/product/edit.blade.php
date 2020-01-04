@extends('layout')

@section('title', 'Edit referral program')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Edit referral program</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<form class="form-horizontal" role="form" method="post" action="{{ route('site.product.update') }}">
						{{ csrf_field() }}
						<input type="hidden" name="product_id" value="{{ $product->id }}">
						<div class="form-group">
							<label class="col-md-3 control-label" for="input_name">Product/Service name</label>
							<div class="col-md-8">
								<input class="form-control" type="text" id="input_name" name="name" value="{{ $product->name }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="input_description">Product/Service description</label>
							<div class="col-md-8">
								<textarea class="form-control" id="input_description" name="description" rows="3" required>{{ $product->description }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="input_amount">Successful sale reward</label>
							<div class="col-md-4">
								<input class="form-control" type="number" step="0.01" id="input_amount" name="amount" value="{{ $product->amount }}" required>
							</div>
							<div class="col-md-4">
								<select class="form-control" name="measure">
									<option value="%" {{ $product->measure == '%' ? 'selected' : '' }}>%</option>
									<option value="$" {{ $product->measure == '$' ? 'selected' : '' }}>$</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="input_lead_reward">Lead reward (optional)</label>
							<div class="col-md-8">
								<input class="form-control" type="number" step="0.01" id="input_lead_reward" name="lead_reward" value="{{ $product->lead_reward }}">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-3 col-md-8">
								<div class="checkbox checkbox-primary">
									<input id="checkbox2" type="checkbox" name="public" {{ $product->public ? 'checked' : '' }}>
									<label for="checkbox2">
										Available for public
									</label>
								</div>
							</div>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
							<a href="{{ URL::previous() }}" role="button" class="btn btn-primary waves-effect waves-light">
								Back
							</a>
						</div>
					</form>
				</div>
				<!--/ meta -->
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Pyramd Tips</h4>
					<p>
						Edit the details of your referral program here. We do not recommend altering the lead or successful 
						sale rewards once a referral program has been launched.                  
					</p>
				</div>
			</div>
		</div>
	</div>
@endsection