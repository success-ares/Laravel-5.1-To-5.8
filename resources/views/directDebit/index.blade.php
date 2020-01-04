@extends('layout')

@section('title', 'Direct Debits')

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
				<h1 class="page-title">Direct Debits</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
						<tr>
							<th>User</th>
							<th>Account number</th>
							<th>Account name</th>
							<th>Bank name</th>
							<th>Request date</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</thead>

						<tbody>
						@foreach($directDebits as $direct)
							<tr>
								<td>{{ $direct->billing->user->first_name.' '.$direct->billing->user->last_name }}</td>
								<td>{{ $direct->account_number }}</td>
								<td>{{ $direct->account_name }}</td>
								<td>{{ $direct->bank_name }}</td>
								<td>{{ $direct->created_at->toDayDateTimeString() }}</td>
								<td>
									@if($direct->status == 'pending')
										<span class="label label-info">Pending</span>
									@elseif($direct->status == 'approved')
										<span class="label label-success">Approved</span>
									@elseif($direct->status == 'declined')
										<span class="label label-danger">Declined</span>
									@endif
								</td>
								<td>
									<a href="{{ route('admin.directDebit.edit', $direct->id) }}"
									   role="button" class="btn btn-xs btn-warning waves-effect waves-light">
										Edit
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