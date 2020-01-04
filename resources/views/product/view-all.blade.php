@extends('layout')

@section('title', 'Refer someone')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Refer someone</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<div class="text-center">
						<h4 class="font-600">Send your referral to earn rewards</h4>
						<p class="text-muted">
							Choose the right program from the list of products and services below. Each program clearly outlines 
							the product or service on offer, plus what rewards you may be eligible for. You will earn either a 
							fixed amount, or a percentage of the sale value for each referral you make that turns into a
							successful sale. In addition, you may be offered a reward for sending a lead to a company, regardless 
							of whether the sale goes through. These may be subject to the company’s approval first.
						</p>
					</div>
				</div>
			</div>
		</div>

		@foreach($products->chunk(3) as $chunk)
		<div class="row">
			@foreach($chunk as $product)
				<div class="col-md-4">
					<div class="panel panel-color panel-info">
						<div class="dropdown pull-right">
							<a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
							   aria-expanded="false">
								<i class="zmdi zmdi-more-vert"></i>
							</a>
							<ul class="dropdown-menu" role="menu">
								@if( in_array($product->id, $favourites))
									<li><a href="{{ route('site.favour.delete', $product->id) }}">Remove from favourites</a></li>
								@else
									<li><a href="{{ route('site.favour.create', $product->id) }}">Add to favourites</a></li>
								@endif
							</ul>
						</div>
						<div class="panel-heading">
							<h3 class="panel-title programs-title">{{ $product->name }}</h3>
						</div>
						<div class="panel-body">
							<p>{{ $product->description }}</p>
							@if($product->measure == '%')
								<p><i class="ti-angle-double-right"></i> Earn {{ $product->amount }}% of sale price</p>
							@else
								<p><i class="ti-angle-double-right"></i> Earn ${{ $product->amount }} per sale</p>
							@endif
							@if($product->lead_reward)
								<p><i class="ti-angle-double-right"></i> Earn ${{ $product->lead_reward }} per approved lead</p>
							@endif
							<p class="text-center">
								<a href="{{ route('site.ref.add', [$product->id]) }}" role="button" class="btn btn-sm btn-success waves-effect waves-light">Refer</a>
							</p>
						</div>
					</div>
					<!--/ meta -->
				</div>
			@endforeach
		</div>
		@endforeach
	</div>
@endsection