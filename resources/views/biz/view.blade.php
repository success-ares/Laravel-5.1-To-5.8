@extends('layout-biz')

@section('title', $biz->biz_name)
@section('description', str_limit($biz->description, 200) )
@section('ogTitle', $biz->biz_name)
@section('ogDescription', str_limit($biz->description, 200))
@if($biz->logo)
	@section('ogImage', asset('images/logos/'.$biz->logo) )
@endif


@section('content')
	<div class="container">
		<div class="row section-container">
			<div class="col-xs-6">
				<div class="section-title">Business</div>
			</div>
			<div class="col-xs-6">
				<div class="share-btn pull-right">
					<a class="facebook" href="https://www.facebook.com/sharer.php?u={{ Request::url() }}">
						<i class="fa fa-reply" aria-hidden="true"></i>
						Share
					</a>
				</div>
			</div>
		</div>

		<div class="row biz-profile-container">
			<div class="col-sm-8">
				<div class="biz-profile">
					<div class="profile-info-detail">
						@if($biz->logo)
							<div class="img-container">
								<img src="{{ '/images/logos/'.$biz->logo }}" class="img-thumbnail" alt="profile-image">
							</div>
						@endif

						<div class="profile-info-name">
							<h2 class="biz-name">{{ $biz->biz_name }}</h2>
							<p class="biz-category">{{ $biz->category->category_name }}</p> 
						</div>
						<p class="biz-description">{{ $biz->description }}</p>
						

						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="contact-box">
					<h4 class="header-title m-b-15">Contacts</h4>
					<table class="contact-detials">
						<tr>
							<td><i class="fa fa-user" aria-hidden="true"></i></td>
							<td>{{ $biz->contact_person }}</td>
						</tr>
						<tr>
							<td><i class="fa fa-mobile fa-lg" aria-hidden="true"></i></td>
							<td>{{ $biz->phone }}</td>
						</tr>
						<tr>
							<td><i class="fa fa-envelope" aria-hidden="true"></i></td>
							<td>{{ $biz->email }}</td>
						</tr>
						<tr>
							<td><i class="fa fa-link" aria-hidden="true"></i></td>
							<td><a href="{{ $biz->user->company_url }}" target="_blank">{{ $biz->user->company_url }}</a></td>
						</tr>
					</table>
				</div>
				<?php
				//echo "<pre>".print_r($biz->user_id,1);
				?>
				@if(Auth::check())
					@if(Auth::user()->id != $biz->user_id)
						<!-- Small modal -->
						<button type="button" class="btn btn-pyramd btn-pyramd-1 waves-effect waves-light" data-toggle="modal" data-target="#confirmModal">
							<span class="pyramd-icon">
								Apply to join referral program
							</span>
						</button>
					@endif
				@else
					<!-- Small modal -->
					<button type="button" class="btn btn-pyramd btn-pyramd-1 waves-effect waves-light" data-toggle="modal" data-target="#confirmModal">
						<span class="pyramd-icon">
							Apply to join referral program
						</span>
					</button>
				@endif
			</div>
		</div>
		<!-- end row -->
	</div>

	<div class="bg-white">
		<div class="container">
			<div class="row products">
				<div class="col-md-12">
					<div class="section-container">
						<div class="section-title">Products</div>
					</div>
					@foreach($products->chunk(4) as $chunk)
					<div class="row">
						@foreach($chunk as $product)
							<div class="col-md-3">
								<div class="product-box">
									<div class="product-details">
										<div class="programs-title">{{ $product->name }}</div>
										<p class="programs-description">{{ $product->description }}</p>
										<div class="row">
											<div class="col-xs-6">
												<div class="amount">
													@if($product->measure == '%')
														{{ $product->amount }}% commission
													@else
														${{ $product->amount }} commission
													@endif
												</div>
												
												@if($product->lead_reward)
													<div class="lead">
														${{ $product->lead_reward }} per approved lead
													</div>
												@endif
												
											</div>
											<div class="col-xs-6">
												<div class="pull-right">
													<a href="{{ route('site.ref.add', [$product->id]) }}" role="button" class="btn-refer">
														<span>Refer</span> <i class="pyramd-circle-icon"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--/ meta -->
							</div>
						@endforeach
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>

    <!-- Small modal -->
    <div id="confirmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Please confirm you want to apply to be a referrer for this business.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                    <a href="{{ route('site.sales.join', $biz->name_alias) }}" role="button" class="btn btn-warning waves-effect waves-light">
                        Confirm
                    </a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection