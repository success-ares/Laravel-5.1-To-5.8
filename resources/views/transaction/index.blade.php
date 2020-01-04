@extends('layout')

@section('title', 'Transactions')

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
				<h1 class="page-title">Transactions</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="card-box">
					<h3 class="text-center m-t-0 m-b-20">Commission to pay</h3>
					<div class="total-commission text-center">
						<p>${{ $toPay }}</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card-box">
					<h3 class="text-center m-t-0 m-b-20">Total value</h3>
					<div class="total-commission text-center">
						<p>${{ $totalValue }}</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card-box">
					<h3 class="text-center m-t-0 m-b-20">Total commission</h3>
					<div class="total-commission text-center">
						<p>${{ $totalCommission }}</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
						<tr>
							<th>Business</th>
							<th>Salesperson</th>
							<th>Referral Value</th>
							<th>Commission</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</thead>

						<tbody>
						@foreach($transactions as $transaction)
							<tr>
								<td>{{ $transaction->biz_name }}</td>
								<td>{{ $transaction->first_name.' '.$transaction->last_name }}</td>
								<td>
									@if($transaction->lead)
										<span class="label label-info">Lead</span>
									@else
										${{ $transaction->value or 0}}
									@endif
								</td>

								<td>${{ (float)$transaction->amount }}</td>
								<td>
									@if($transaction->paid_status == 'Pending')
										<span class="label label-info">Pending</span>
									@elseif($transaction->paid_status == 'Paid')
										<span class="label label-success">Paid</span>
									@elseif($transaction->paid_status == 'Attention')
										<span class="label label-danger">Attention</span>
									@endif
								</td>
								<td>
									<a href="{{ route('admin.transaction.edit', $transaction->id) }}"
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