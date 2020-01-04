@extends('layout')

@section('title', 'Referrals I Made')

@section('styles')
    <!-- DataTables -->
    <link href="/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Referrals I Made</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<table id="datatable-buttons" class="table table-striped table-bordered">
						<thead>
						<tr>
							<th>Full name</th>
							<th>Company</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Value</th>
							<th>Status</th>
							<th>Product</th>
							<th>Actions</th>
						</tr>
						</thead>

						<tbody>
						@foreach($referrals as $referral)
							<tr>
								<td>{{ $referral->user->first_name.' '.$referral->user->last_name }}</td>
								<td>{{ $referral->user->company }}</td>
								<td>{{ $referral->user->phone }}</td>
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
@endsection

@section('scripts')
    <!-- Datatables-->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="/assets/plugins/datatables/jszip.min.js"></script>
    <script src="/assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="/assets/plugins/datatables/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable-buttons').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {extend: "csv", className: "btn-sm"},
                    {extend: "excel", className: "btn-sm"},
                    {extend: "print", className: "btn-sm"}
                ],responsive: !0
            } );
        } );
    </script>
@endsection