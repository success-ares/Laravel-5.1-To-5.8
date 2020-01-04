@extends('layout')

@section('title', 'View referral')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">View referral</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<div class="row">
						<div class="col-sm-offset-1 col-sm-11">
							<dl class="dl-horizontal">
								<dt>First name</dt>
								<dd><p>{{ $referral->user->first_name }}</p></dd>

								<dt>Last name</dt>
								<dd><p>{{ $referral->user->last_name }}</p></dd>

								<dt>Phone</dt>
								<dd><p>{{ $referral->user->phone }}</p></dd>

								<dt>Company</dt>
								<dd><p>{{ $referral->user->company }}</p></dd>

								<dt>Address</dt>
								<dd><p>{{ $referral->user->address }}</p></dd>

								<dt>Description</dt>
								<dd><p>{{ $referral->user->description }}</p></dd>

								<dt>Value</dt>
								<dd><p>{{ $referral->value }}</p></dd>

								<dt>Status</dt>
								<dd>
									@if( $referral->status == 'Pending contact' )
										<span class="label label-default">{{ $referral->status }}</span>
									@elseif( $referral->status == 'In progress' )
										<span class="label label-warning">{{ $referral->status }}</span>
									@elseif( $referral->status == 'Agreement achieved' )
										<span class="label label-purple">{{ $referral->status }}</span>
									@elseif( $referral->status == 'Approved' )
										<span class="label label-success">{{ $referral->status }}</span>
									@elseif( $referral->status == 'Declined' )
										<span class="label label-danger">{{ $referral->status }}</span>
									@elseif( $referral->status == 'Withdrew' )
										<span class="label label-inverse">{{ $referral->status }}</span>
									@endif
								</dd>
							</dl>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-offset-3 col-sm-9">
							<a href="{{ URL::previous() }}" role="button" class="btn btn-primary waves-effect waves-light">
								Back
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				@include('modules.ref-message')
			</div>
		</div>
	</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="/assets/js/bootstrap.file-input.js"></script>
    <script>
        $(document).ready(function(){
            $('#file_attach').bootstrapFileInput();
        });
    </script>
@endsection