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
				<h1 class="page-title">Business Dashboard</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="card-box">
					<h3 class="m-t-0 m-b-30 text-center">Total Sales</h3>
					<div class="total-sum text-center">
						<p>${{ $totalSales or 0 }}</p>
					</div>
				</div>
			</div><!-- end col -->

			<div class="col-md-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Revenue</h4>

					<div class="widget-box-2">
						<div class="widget-detail-2">
							@if($change)
								@if($changeSign)
									<span class="badge badge-success pull-left m-t-20">{{ $change }}% <i class="zmdi zmdi-trending-up"></i> </span>
								@else
									<span class="badge badge-danger pull-left m-t-20">{{ $change }}% <i class="zmdi zmdi-trending-down"></i> </span>
								@endif
							@endif
							<h2 class="m-b-0">${{ $thisMonth or 0 }}</h2>
							<p class="text-muted m-b-25">This Month</p>
						</div>
						@if($change)
							@if($changeSign)
								<p class="text-success m-b-0">{{ $change }}% increased compared to last month</p>
							@else
								<p class="text-danger m-b-0">{{ $change }}% decreased compared to last month</p>
							@endif
						@else
							<p class="m-b-0">No data for previous month.</p>
						@endif
					</div>
				</div>
			</div><!-- end col -->

			<div class="col-md-4">
				<div class="card-box">
					<h3 class="m-t-0 m-b-30 text-center">Unpaid Commision</h3>
					<div class="total-sum text-center">
						<p>XXX</p>
					</div>
				</div>
			</div><!-- end col -->
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="card-box">
					<h4 class="header-title m-t-0">Total Revenue</h4>
					<div id="morris-bar" style="height: 250px;"></div>
				</div>
			</div><!-- end col -->
			<div class="col-md-6">
				<div class="card-box">
					<h4 class="header-title m-t-0">Top Products</h4>

					<div class="widget-chart text-center">
						<div id="morris-donut" style="height: 250px;"></div>
					</div>
				</div>
			</div><!-- end col -->
		</div>

		<div class="row">
			<div class="col-md-3">
				<div class="card-box">
					<h3 class="header-title m-t-0 m-b-30">Top 5 Sellers</h3>
					<div class="inbox-widget">
						@foreach($topSellers->take(5) as $seller)
							<div class="inbox-item">
								<div class="inbox-item-img">
									@if($seller->user->photo)
										<img src="{{ '/images/avatars/'.$seller->user->photo }}" class="img-circle" alt="user">
									@else
										<img src="/assets/images/no_avatar.png" class="img-circle" alt="user">
									@endif
								</div>
								<p class="inbox-item-author">{{ $seller->user->first_name.' '.$seller->user->last_name }}</p>
								<p class="inbox-item-text">{{ $seller->user->email }}</p>
								<p class="inbox-item-link">
									<a href="{{ route('site.sales.view', [$seller->user->id]) }}"><span class="text-warning"> View</span></a>
								</p>

							</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="card-box">
					<h3 class="header-title m-t-0 m-b-30">Latest Referrals</h3>
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
									<td>{{ $referral->user->first_name.' '.$referral->user->last_name }}</td>
									<td>{{ $referral->user->email }}</td>
									<td>{{ $referral->value }}</td>
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
									<td>{{ $referral->product->name }}</td>
									<td>
										<a href="{{ route('site.ref.view', [$referral->id]) }}" role="button" class="btn btn-primary btn-xs waves-effect waves-light">View and Chat</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
    <!--Morris Chart-->
    <script src="/assets/plugins/raphael/raphael-min.js"></script>
    <script src="/assets/plugins/morris/morris.min.js"></script>

    <!-- Dashboard init -->
    <script>
        // Total Revenue chart
        var data = [
            @foreach($perMonth as $key => $item)
            { y: '{{ date('M', mktime(0, 0, 0, $key, 10)) }}', a: '{{ $item->sum('value') }}' },
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

        // Top Products chart
        new Morris.Donut({
            element: 'morris-donut',
            data: [
                @foreach($topProducts as $key => $item)
                {label: "{{ $key }}", value: {{ $item->count() }} },
                @endforeach

            ],
            resize: true
        });
    </script>
@endsection