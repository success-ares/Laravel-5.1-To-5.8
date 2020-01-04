@extends('layout')

@section('title', 'Person details')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Person details</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="card-box">
					<dl class="dl-horizontal">
						<dt>First name</dt>
						<dd><p>{{ $user->first_name }}</p></dd>

						<dt>Last name</dt>
						<dd><p>{{ $user->last_name }}</p></dd>

						<dt>Phone</dt>
						<dd><p>{{ $user->phone or '--' }}</p></dd>

						<dt>Company</dt>
						<dd><p>{{ $user->company or '--'}}</p></dd>

						<dt>Address</dt>
						<dd><p>{{ $user->address or '--' }}</p></dd>

						<dt>Description</dt>
						<dd><p>{{ $user->description or '--' }}</p></dd>

					</dl>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Select referral program</h4>
					<form method="post" action="{{ route('site.sales.postJoin') }}">
						{{ csrf_field() }}
						<input type="hidden" name="code" value="{{ $code }}">
						@if( !$products->product->isEmpty() )
							@foreach($products->product as $product)
								<div class="checkbox checkbox-primary">
									<input id="checkbox-{{ $product->id }}" type="checkbox" name="product[]" value="{{ $product->id }}">
									<label for="checkbox-{{ $product->id }}">{{ $product->name }}</label>
								</div>
							@endforeach
						@else
							<p>You don't have any products/services!</p>
						@endif

						@if( !$products->product->isEmpty() )
							<button type="submit" class="btn btn-primary">Apply to join</button>
						@endif
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection