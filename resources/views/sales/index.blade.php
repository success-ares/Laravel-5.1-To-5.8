@extends('layout')

@section('title', 'Sales people')

@section('styles')
    <!-- DataTables -->
    <link href="/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Sales people
				</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
						<tr>
							<th>Full name</th>
							<th>Company</th>
							<th>Email</th>
							<th>Total Referral Value</th>
							<th>Total Referral Bonus</th>
							<th>Actions</th>
						</tr>
						</thead>

						<tbody>
						@if($referrals)
							@foreach($referrals as $referral)
								<tr>
									<td>{{ $referral->first_name.' '.$referral->last_name }}</td>
									<td>{{ $referral->company }}</td>
									<td>{{ $referral->email }}</td>
									<td>{{ $referral->total_value or '0'}}</td>
									<td>{{ (float)$referral->total_bonus}}</td>
									<td>
										<a href="{{ route('site.sales.view', $referral->user_id ) }}" role="button" class="btn btn-primary btn-xs waves-effect waves-light">View</a>
									</td>
								</tr>
							@endforeach
						@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
    <!-- Datatables-->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>
@endsection