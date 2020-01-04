@extends('layout')

@section('title', 'Create a referral program')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">My business</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<div class="row">
						<div class="col-sm-12">
							<div class="text-center">
								<h1 class="font-600">{{ $biz->biz_name }} referral program</h1>
								<p class="text-muted">
									Here’s the exciting part! Your referral programs will showcase your products and services, and offer 
									rewards for successful referrals. You can choose to make your program public (so anyone can refer 
									business to you), or private (so you choose who to show it to). You’ll offer either a fixed amount or a 
									percentage of the lead value for a successful referral. When the sale goes through, your salesperson 
									gets their reward. You may also choose to offer a small reward for every lead sent your way, regardless of its success.<br/>
									Click the button below to add a program to your business.
								</p>
								<hr>
								<p>
									<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
										Add Program
									</a>
								</p>
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="row">
						<div class=" col-sm-12">
							<div class="collapse" id="collapseForm">
								<form class="form-horizontal" role="form" method="post" action="{{ route('site.product.store') }}">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="col-md-3 control-label" for="input_name">Product/Service name</label>
										<div class="col-md-8">
											<input class="form-control" type="text" id="input_name" name="name" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="input_description">Product/Service description</label>
										<div class="col-md-8">
											<textarea class="form-control" id="input_description" name="description" rows="3" required></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="input_amount">Successful sale reward</label>
										<div class="col-md-4">
											<input class="form-control" type="number" step="0.01" id="input_amount" name="amount" required>
										</div>
										<div class="col-md-4">
											<select class="form-control" name="measure">
												<option value="%">%</option>
												<option value="$">$</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="input_lead_reward">Lead reward (optional) - $</label>
										<div class="col-md-8">
											<input class="form-control" type="number" step="0.01" id="input_lead_reward" name="lead_reward">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-3 col-md-8">
											<div class="checkbox checkbox-primary">
												<input id="checkbox2" type="checkbox" name="public">
												<label for="checkbox2">
													Available for public
												</label>
											</div>
										</div>
									</div>
									<div class="text-center">
										<button type="submit" class="btn btn-success waves-effect waves-light m-t-10">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!--/ meta -->
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-20">Referral programs</h4>

					<ul class="list-group m-b-0 user-list">
						@if($biz->product->isEmpty())
							<li class="list-group-item">
								<div class="user-desc">
									<span class="name">No programs</span>
								</div>
							</li>
						@else
							@foreach($biz->product as $product)
								<li class="list-group-item">
									<div class="user-list-item">
										<div class="avatar text-center">
											@if($product->public)
												<i class="ti-briefcase text-success"></i>
											@else
												<i class="ti-briefcase text-danger"></i>
											@endif
										</div>
										<div class="user-desc">
											<p>
												<a href="{{ route('site.product.edit', $product->id) }}">
													<span class="name">{{ $product->name }}</span>
												</a>
												<span class="desc">{{ $product->description }}</span>
											</p>
										</div>
									</div>
								</li>
							@endforeach
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection