@extends('layout')

@section('title', 'Create new business')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">My business</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="bg-picture card-box">
					<div class="profile-info-name">
						@if($biz->logo)
							<img src="{{ '/images/logos/'.$biz->logo }}" class="img-thumbnail" alt="profile-image">
						@else
							<img src="/assets/images/upload_photo.png" class="img-thumbnail" alt="profile-image">
						@endif


						<div class="profile-info-detail">
							<h3 class="m-t-0 m-b-0">{{ $biz->biz_name }}</h3>
							<p class="text-muted m-b-20"><i>{{ $biz->category->category_name }}</i></p>
							<p>{{ $biz->description }}</p>
							<hr>
							<a class="btn btn-warning waves-effect waves-light m-t-10" href="{{ route('site.biz.edit') }}" role="button">Edit</a>
							<a class="btn btn-primary waves-effect waves-light m-t-10" href="{{ route('site.product.create') }}" role="button">Add referral program</a>
						</div>


						<div class="clearfix"></div>
					</div>
				</div>

				@if( !$biz->product->isEmpty() )
					<div class="card-box">

						<h4 class="header-title m-t-0 m-b-30">Referral programs</h4>

						<div class="table-responsive">
							<table class="table">
								<thead>
								<tr>
									<th>Product Name</th>
									<th>Amount</th>
									<th>Lead reward</th>
									<th>Public</th>
									<th>Actions</th>
									<th>Share</th>
								</tr>
								</thead>
								<tbody>
								@foreach($biz->product as $product)
									<tr>
										<td>{{ $product->name }}</td>
										<td>
											@if($product->measure == '$')
												{{ '$'.$product->amount }}
											@else
												{{ $product->amount.' %' }}
											@endif
										</td>
										<td>{{ $product->lead_reward ? '$'.$product->lead_reward : ''}}</td>
										<td>
											@if($product->public)
												<span class="label label-success">On</span>
											@else
												<span class="label label-danger">Off</span>
											@endif
										</td>
										<td>
											<a href="{{ route('site.product.edit', $product->id) }}" role="button" class="btn btn-xs btn-primary waves-effect w-md waves-light m-b-0">Edit</a>
											<a href="{{ route('site.product.delete', $product->id) }}" onclick="return confirm('Are you sure want to delete this referral program and all referrals?')" role="button" class="btn btn-xs btn-danger waves-effect w-md waves-light m-b-0">Delete</a>
										</td>
										<td>
											@if($product->public)
												<button id="share-{{ $product->id }}" class="btn btn-xs btn-purple waves-effect waves-light">
													<i class="ti-facebook"></i> <span>Share</span>
												</button>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				@endif
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Contacts</h4>
					<p class="text-muted m-b-20"><i class="ti-user"> {{ $biz->contact_person }}</i></p>
					<p class="text-muted m-b-20"><i class="ti-mobile"> {{ $biz->phone }}</i></p>
					<p class="text-muted m-b-20"><i class="ti-email"> {{ $biz->email }}</i></p>
					<p class="text-muted m-b-20">
						<i class="ti-link"> <a href="{{ route('site.biz.view', [$biz->name_alias]) }}">{{ route('site.biz.view', [$biz->name_alias]) }}</a></i>
					</p>
				</div>

			</div>
		</div>
		<!-- end row -->
	</div>
@endsection

@section('scripts')
    <script>
        // load facebook js
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ config('settings.facebookId') }}',
                xfbml      : true,
                version    : 'v2.7'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        // when we click share button
        $(document).ready(function(){

            @if( !$biz->product->isEmpty() )
                @foreach($biz->product as $product)

                $('#share-{{ $product->id }}').click(function(e){
                    e.preventDefault();
                    FB.ui(
                        {
                            method: 'share',
                            title: "Introducing {{ $biz->biz_name }}'s referral program",
                            href: "{{ route('site.biz.view', $biz->name_alias) }}",
                            caption: "{{ config('settings.slogan') }}",
                            @if($biz->logo)
                            picture: "{{ url('images/logos').'/'.$biz->logo }}",
                            @endif
                            description: "Get cash for referrals! Refer someone to our product \"{{ $product->name }}\" and earn " +
                                "{{ $product->lead_reward ? '$'.$product->lead_reward.' for a qualified lead and ' : ' ' }}" +
                                "{{ $product->amount.' '.$product->measure }} for a successful sale."
                        });
                });

                @endforeach
            @endif
        });
    </script>
@endsection