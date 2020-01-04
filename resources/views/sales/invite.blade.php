@extends('layout')

@section('title', 'Invite referrer')

@section('styles')
    <link href="/assets/plugins/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">
@endsection

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Invite referrer</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<form class="form-horizontal" role="form" method="post" action="{{ route('site.sales.postInvite') }}">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="col-md-3 control-label" for="select_product">Select program</label>
							<div class="col-md-8">
								<select multiple id="select_product" class="form-control" name="product_id[]">
									@foreach($products->biz->product as $product)
										<option value="{{ $product->id }}">{{ str_limit($product->name) }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="input_email">Email</label>
							<div class="col-md-8">
								<input class="form-control" type="text" id="input_email" name="email" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="input_first_name">First name</label>
							<div class="col-md-8">
								<input class="form-control" type="text" id="input_first_name" name="first_name" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="input_last_name">Last name</label>
							<div class="col-md-8">
								<input class="form-control" type="text" id="input_last_name" name="last_name" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="input_address">Address</label>
							<div class="col-md-8">
								<input class="form-control" type="text" id="input_address" name="address">
							</div>
						</div>

						<div class="text-center">
							<button type="submit" class="btn btn-success waves-effect waves-light m-t-10">SEND INVITATION</button>
						</div>
					</form>
				</div>
				<!--/ meta -->
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Pyramd Tips</h4>
					<p>Invite someone to become a salesperson for your business. You can give the salesperson access to 
						all your referral programs, or just one or two. If they accept, the salesperson will be able to refer 
						leads to your business and earn rewards. </p>

				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
    <meta name="_token" content="{{ csrf_token() }}" />

    <!-- Jquery-ui -->
    <script src="/assets/plugins/jquery-ui-1.11.4/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {

            $( "#input_email" ).autocomplete({
                source: "{{ route('site.ref.searchUser') }}",
                response: function (event, ui) {
                    if ( !ui.content.length ){
                        $('#input_first_name').val('');
                        $('#input_last_name').val('');
                        $('#input_address').val('');
                    }
                },
                select: function( event, ui ) {
                    $('#input_email').val(ui.item.email);
                    $('#input_first_name').val(ui.item.first_name);
                    $('#input_last_name').val(ui.item.last_name);
                    $('#input_address').val(ui.item.address);
                },
                minLength: 2,
                delay: 500
            });

        });
    </script>
@endsection