@extends('layout')

@section('title', 'Withdrawals')

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
				<h1 class="page-title">Withdrawals</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
						<tr>
							<th>User</th>
							<th>Amount</th>
							<th>Request date</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</thead>

						<tbody>
						@foreach($withdrawals as $withdrawal)
							<tr>
								<td>{{ $withdrawal->user->first_name.' '.$withdrawal->user->last_name }}</td>
								<td>${{ $withdrawal->amount }}</td>
								<td>{{ $withdrawal->created_at->toDayDateTimeString() }}</td>
								<td>
									@if($withdrawal->status)
										<span class="label label-info">Paid</span>
									@else
										<span class="label label-danger">Not paid</span>
									@endif
								</td>
								<td>
									<a href="{{ route('admin.withdrawal.show', $withdrawal->id) }}"
									   role="button" class="btn btn-xs btn-warning waves-effect waves-light">
										Show
									</a>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>
@endsection