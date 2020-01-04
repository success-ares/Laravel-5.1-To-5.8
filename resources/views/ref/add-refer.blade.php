@extends('layout')

@section('title', 'Add new referral')

@section('styles')
    <!-- Select 2 -->
    <link href="/assets/plugins/select-2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/select-2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- JQueri-ui -->
    <link href="/assets/plugins/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">
@endsection

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h4 class="page-title">Make a referral</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<div class="row">
						<div class="col-sm-12">
							<div class="text-center">
								<h1 class="font-600">{{ $product->name }}</h1>
								<span class="title-separator"></span>
								<h5 class="text-muted uppercase font-600">HOW IT WORKS</h5>
								<p class="item-collapse mobile-only">
									Refer someone to this program and earn rewards. Fill in the details of the person you’d like to refer or simply upload a photo of their business card.                       
								</p>
								<p class="item-expand">
									Refer someone to this program and earn rewards. Fill in the details of the person you’d like to refer. 
									The company which runs this referral program will receive these details. The person you are 
									referring will also receive a notification. Make sure you only refer genuine leads to the relevant referral program.                                
								</p>

								<hr>
								<h5 class="text-muted uppercase item-collapse font-600">ENTER DETAILS</h5>
							</div>
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="row">
						<div class=" col-sm-12">
							<form class="form-horizontal form-referral" role="form" method="post" action="{{ route('site.ref.postAdd') }}">
								{{ csrf_field() }}
								<input type="hidden" name="product_id" value="{{ $product->id }}">
								@if($owner)
								<div class="form-group">
									<label class="col-md-3 control-label" for="input_referrer">Referrer</label>
									<div class="col-md-7">
										<select class="form-control" id="input_referrer" name="referrer"></select>
									</div>
									<div class="col-md-1 text-right">
										<button class="btn btn-primary waves-effect waves-light m-t-0" data-toggle="modal" data-target="#form-modal">
											Invite new
										</button>
									</div>
								</div>
								@endif
								<div class="form-group">
									<label class="col-md-3 control-label" for="input_email">Referring email</label>
									<div class="col-md-8">
										<input class="form-control" type="text" id="input_email" name="email" required>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="first_name">Referring first name</label>
									<div class="col-md-8">
										<input class="form-control" type="text" id="first_name" name="first_name" required>
									</div>
								</div>
								<!--  -->
								<div class="reff-more-detail mobile-only text-center">
									<a class="expand"><h5 class="font-600 karla">ENTER MORE INFO</h5></a>
									<p>(Not required but recommended)</p>
									<hr class="separator mobile-only">
								</div>
								<div class="item-expand" >
									<div class="form-group">
										<label class="col-md-3 control-label" for="last_name">Referring last name</label>
										<div class="col-md-8">
											<input class="form-control" type="text" id="last_name" name="last_name" required>
										</div>
									</div>
									<div class="form-group ">
										<label class="col-md-3 control-label" for="company">Referring company</label>
										<div class="col-md-8">
											<input class="form-control" type="text" id="company" name="company">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="phone">Referring phone</label>
										<div class="col-md-8">
											<input class="form-control" type="tel" id="phone" name="phone" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="description">Referring description</label>
										<div class="col-md-8">
											<textarea class="form-control" id="description" name="description" rows="3"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="value">Referral value</label>
										<div class="col-md-8">
											<input class="form-control" type="number" id="value" name="value">
										</div>
									</div>
									<div class="form-group referral-value">
										<label class="col-md-3 control-label">You will potentially earn</label>
										<div class="col-md-8">
											@if( $product->measure == '$')
												<p class="form-control-static">${{ $product->amount }}</p>
											@else
												<p class="form-control-static product-value"></p>
											@endif
										</div>
									</div>

								    </div>

									<div class="businessphoto item-collapse">
									<h5 class="text-muted uppercase">UPLOAD A BUSINESS CARD PHOTO</h5>
									<img class="business-card" src="/assets/images/referral-image.jpg">
									<div class="form-group">
										<button class="btn btn-pyramd half waves-effect btn-grey font-600">
											TAKE A PHOTO 
										</button>

										<button class="btn btn-pyramd  half waves-effect btn-grey font-600">
											CHOOSE A FILE 
										</button>
					
									
									</div>
									
								</div>	

								<div class="form-group">
									<div class="col-md-offset-3 col-md-8">
										<div class="checkbox checkbox-primary">
											<input id="checkbox2" type="checkbox" name="terms" required>
											<label for="checkbox2">
												Accept <a href="{{ route('terms') }}" target="_blank">terms and conditions</a>
											</label>
										</div>
									</div>
								</div>
								<div class="col-md-offset-3 col-md-8 no-padding">
									<button type="submit" class="btn btn-pyramd btn-pyramd-2 waves-effect waves-light">
										<span class="pyramd-icon">
											Submit
										</span>
									</button>
								</div>
							</form>
						</div>
					</div>
					{{--Modal form if this user is owner for this biz product--}}
					@if($owner)
						<div id="form-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Invite referrer</h4>
								</div>
								<div class="modal-body">
									<div class="row">
										<form class="form-horizontal" id="invite_form" role="form">
											<div class="form-group">
												<label class="col-md-3 control-label" for="select_product">Product</label>
												<div class="col-md-8">
													<p class="form-control-static">{{ str_limit($product->name) }}</p>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="input_invite_email">Email</label>
												<div class="col-md-8">
													<input class="form-control" type="text" id="input_invite_email" name="invite_email" required>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="input_first_name">First name</label>
												<div class="col-md-8">
													<input class="form-control" type="text" id="input_first_name" name="invite_first_name" required>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="input_last_name">Last name</label>
												<div class="col-md-8">
													<input class="form-control" type="text" id="input_last_name" name="invite_last_name" required>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="input_address">Address</label>
												<div class="col-md-8">
													<input class="form-control" type="text" id="input_address" name="invite_address">
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="modal-footer">
									<button id="send_invitation" class="btn btn-success waves-effect waves-light m-t-10">SEND INVITATION</button>
									<button type="button" class="btn btn-default waves-effect waves-light m-t-10" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div><!-- /.modal -->
					@endif
				</div>
				<!--/ meta -->
			</div>
		</div>
	</div>
@endsection

@section('scripts')
    <!-- Jquery-ui -->
    <script src="/assets/plugins/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <!-- Select 2 -->
    <script src="/assets/plugins/select-2/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // calculate
            $('#value').bind('input', function () {

                var productValue = 0;

                if ($(this).length > 0){
                    productValue = $(this).val();
                }

                if ( $('p').is('.product-value')){

                    var amount = ( productValue * {{ $product->amount }} ) / 100;

                    $('.product-value').text('$ ' + amount);
                }

            });

            // select 2
            $('#input_referrer').select2({
                theme: "bootstrap",
                ajax: {
                    url: '/referral/search-sales/' + {{ $product->id }},
                    dataType: 'json',
                    delay: 250,
                    minimumInputLength: 1,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            // search user
            $( "#input_email" ).autocomplete({
                source: "{{ route('site.ref.searchUser') }}",
                response: function (event, ui) {
                    if ( !ui.content.length ){
                        $('#first_name').val('').prop( "disabled", false );
                        $('#last_name').val('').prop( "disabled", false );
                        $('#phone').val('').prop( "disabled", false );
                        $('#company').val('').prop( "disabled", false );
                        $('#description').val('').prop( "disabled", false );
                    }
                },
                select: function( event, ui ) {
                    $('#first_name').val(ui.item.first_name).prop( "disabled", true );
                    $('#last_name').val(ui.item.last_name).prop( "disabled", true );
                    $('#phone').val(ui.item.phone).prop( "disabled", true );
                    $('#company').val(ui.item.company).prop( "disabled", true );
                    $('#description').val(ui.item.description).prop( "disabled", true );
                },
                minLength: 4,
                delay: 500
            }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {

                var label;

                if (item.photo && item.friend) {
                    // Friend and have photo
                    label = "<a>" + '<img src="' + item.photo + '" style="width: 25px; height: 25px; margin-right: 10px">' + item.first_name +
                        ' ' + item.last_name + "<br>" + item.value + "</a>";
                }else if (item.friend){
                    // no photo
                    label = "<a>" + item.first_name + ' ' + item.last_name + "<br>" + item.value + "</a>";
                } else{
                    // not friend
                    label = "<a>" + item.value + "</a>";
                }

                return $( "<li>" ).append(label).appendTo( ul );
            };

            @if($owner)
                // ajax post form
                $('#send_invitation').on('click', function () {

                    var formData = {
                        '_token'    : $( "input[name=_token]" ).val(),
                        'product_id[]': $( "input[name=product_id]" ).val(),
                        'email'     : $( "input[name=invite_email]" ).val(),
                        'first_name': $( "input[name=invite_first_name]" ).val(),
                        'last_name' : $( "input[name=invite_last_name]" ).val(),
                        'address'   : $( "input[name=invite_address]" ).val()
                    };

                    // Send the data using post
                    var posting = $.post( '/sales-people/invite', formData );

                    posting.error( function(data){
                        var errors = data.responseJSON;
                    });

                    // Put the results in a div
                    posting.done(function( data ) {
                        // hide modal
                        $('#form-modal').modal('hide');

                        // select new referrer
                        $('#input_referrer').append($("<option>").attr("value", data.new_user_id)
                                .attr("selected", "selected").text(data.new_user_email));
                    });

                });
            @endif

        })
    </script>
@endsection