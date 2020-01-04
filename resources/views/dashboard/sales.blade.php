@extends('layout')

@section('title', 'Dashboard')

@section('first-styles')
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="/assets/plugins/morris/morris.css">
@endsection

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<div class="btn-group pull-right m-t-15">
					<p class="lead">
						Account Balance: ${{ (float)$user->balance }} &emsp;
						<button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#fundsModal">WITHDRAW FUNDS</button>
					</p>
				</div>
				<h1 class="page-title">Sales Dashboard</h1>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="fundsModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Confirm withdrawal of funds</h4>
					</div>
					<form action="{{ route('admin.withdrawal.request') }}" method="post">
						<div class="modal-body">
							<p class="text-primary">Account balance: ${{ $user->balance }}</p>

								{{ csrf_field() }}

								<div class="form-group">
									<label for="input-amount">Withdrawal amount</label>
									<input type="number" step="0.01" class="form-control" id="input-amount" name="amount" value="{{ $user->balance }}">
									<p class="help-block text-danger">Minimum $50</p>
								</div>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default waves-effect waves-light" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary waves-effect waves-light">Confirm</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="card-box">
					<h3 class="header-title m-t-0">Statistics</h3>
					<div id="morris-bar" style="height: 260px;"></div>
				</div>
			</div><!-- end col -->
			<div class="col-sm-4">
				<div class="card-box favorite-products">
					<h3 class="header-title m-t-0 m-b-30">Favourite Products</h3>
					<div>
						@foreach($favourites->take(4) as $favourite)
							<div class="product-info">
								<h4 class="m-t-0 m-b-5 font-600">{{ $favourite->name }}</h4>
								<p class="product-description text-muted m-b-5">{{ str_limit($favourite->description, 50) }}</p>
								<p class="product-refer">
									<a href="{{ route('site.ref.add', [$favourite->id]) }}"><span class="text-warning"> Refer Someone</span></a>
								</p>
							</div>
						@endforeach
					</div>
					@if($favourites->count() >= 4)
						<div class="row">
							<div class="col-sm-12 text-center">
								<a href="#" role="button" class="btn btn-xs btn-primary waves-effect waves-light">VIEW ALL</a>
							</div>
						</div>
					@endif
				</div>
			</div><!-- end col -->
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box">
							<h3 class="m-t-0 m-b-20 text-center">Total Revenue</h3>
							<div class="total-revenue text-center">
								<p>${{ $totalRevenue }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box">
							<h3 class="m-t-0 m-b-20 text-center">This Month</h3>
							<div class="total-revenue text-center">
								<p>${{ $thisMonth }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			@foreach($business->take(4) as $biz)
				<div class="col-lg-3 col-md-6">
					<div class="card-box widget-user">
						<div>
							@if($biz->logo)
								<img src="{{ '/images/logos/'.$biz->logo }}" class="img-responsive img-circle" alt="user">
							@else
								<img src="/assets/images/no_logo.png" class="img-responsive img-circle" alt="user">
							@endif
							<div class="wid-u-info">
								<h4 class="m-t-0 m-b-5 font-600">{{ $biz->biz_name }}</h4>
								<p class="text-muted m-b-5 font-13">{{ $biz->email }}</p>
								<p class="text-warning">
									<b><a href="{{ route('site.biz.view', $biz->name_alias) }}">View</a></b>
								</p>
							</div>
						</div>
					</div>
				</div><!-- end col -->
			@endforeach
		</div>
		<!-- end row -->

		<div class="row">
			<div class="col-md-3">
				<div class="card-box">

					<h4 class="header-title m-t-0 m-b-30">Inbox</h4>

					<div class="inbox-widget nicescroll" style="height: 315px;">
						@foreach($messages->take(5) as $message)
							<a href="{{ route('site.ref.view', [$message->referral_id]) }}">
								<div class="inbox-item">
									<div class="inbox-item-img">
										@if($message->sender->photo)
											<img class="img-circle" src="{{ '/images/avatars/'.$message->sender->photo }}" alt="{{ $message->sender->first_name }}">
										@else
											<img class="img-circle" src="/assets/images/no_avatar.png" alt="{{ $message->sender->first_name }}">
										@endif
									</div>
									<p class="inbox-item-author">{{ $message->sender->first_name.' '.$message->sender->last_name }}</p>
									<p class="inbox-item-text">{{ $message->message }}</p>
									<p class="inbox-item-date">{{ $message->created_at->format('g:i A') }}</p>
								</div>
							</a>
						@endforeach
					</div>
				</div>
			</div><!-- end col -->

			<div class="col-md-9">
				<div class="card-box">
					<h3 class="header-title m-t-0 m-b-30">List of References</h3>
					<div class="table-responsive">
						<table class="table">
							<thead>
							<tr>
								<th>Full name</th>
								<th>Email</th>
								<th>Value</th>
								<th>Status</th>
								<th>Product</th>
								<th>Actions</th>
							</tr>
							</thead>

							<tbody>
							@foreach($referrals->take(10) as $referral)
								<tr>
									<td>{{ $referral->first_name.' '.$referral->last_name }}</td>
									<td>{{ $referral->email }}</td>
									<td>{{ $referral->value or '---' }}</td>
									@if( $referral->status == 'Pending contact' )
										<td><span class="label label-default">{{ $referral->status }}</span></td>
									@elseif( $referral->status == 'In progress' )
										<td><span class="label label-warning">{{ $referral->status }}</span></td>
									@elseif( $referral->status == 'Agreement achieved' )
										<td><span class="label label-purple">{{ $referral->status }}</span></td>
									@elseif( $referral->status == 'Approved' )
										<td><span class="label label-success">{{ $referral->status }}</span></td>
									@elseif( $referral->status == 'Declined' )
										<td><span class="label label-danger">{{ $referral->status }}</span></td>
									@elseif( $referral->status == 'Withdrew' )
										<td><span class="label label-inverse">{{ $referral->status }}</span></td>
									@endif
									<td>{{ $referral->product_name }}</td>
									<td>
										<a href="{{ route('site.ref.view', [$referral->id]) }}" role="button" class="btn btn-primary btn-xs waves-effect waves-light">View and Chat</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
					@if($referrals->count() > 10)
						<div class="row">
							<div class="col-sm-12 text-center">
								<a href="{{ route('site.ref.programList') }}" role="button" class="btn btn-xs btn-primary waves-effect waves-light">VIEW ALL</a>
							</div>
						</div>
					@endif
				</div>
			</div><!-- end col -->

		</div>
	</div>
@endsection

@section('scripts')
    <!--Morris Chart-->
    <script src="/assets/plugins/raphael/raphael-min.js"></script>
    <script src="/assets/plugins/morris/morris.min.js"></script>

    <!-- Dashboard init -->
    <script>

        var data = [
            @foreach($perMonth as $key => $item)
            { y: '{{ date('M', mktime(0, 0, 0, $key, 10)) }}', a: '{{ $item->sum('amount') }}' },
            @endforeach
        ];

        // Total Revenue chart
        new Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'morris-bar',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: data.length ? data : [ { y: 'No Data', a: 0 } ],
            // The name of the data record attribute that contains x-values.
            xkey: 'y',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['a'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Revenue'],
            hideHover: 'auto',
            gridLineColor: '#eeeeee',
            barSizeRatio: 0.2,
            barColors: ['#188ae2']
        });
    </script>
@endsection