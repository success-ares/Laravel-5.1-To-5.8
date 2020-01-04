@extends('layout')

@section('title', 'View/Edit referral')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">View/Edit referral</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<form action="{{ route('site.ref.editRef') }}" method="post" class="form-horizontal">
						{{ csrf_field() }}
						<input type="hidden" name="referral_id" value="{{ $referral->id }}">

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-first-name">First name</label>
							<div class="col-sm-9">
								<input type="text" id="input-first-name" class="form-control" name="first_name" value="{{ $referral->user->first_name }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-last-name">Last name</label>
							<div class="col-sm-9">
								<input type="text" id="input-last-name" class="form-control" name="last_name" value="{{ $referral->user->last_name }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-phone">Phone</label>
							<div class="col-sm-9">
								<input type="tel" id="input-phone" class="form-control" name="phone" value="{{ $referral->user->phone }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-company">Company</label>
							<div class="col-sm-9">
								<input type="text" id="input-company" class="form-control" name="company" value="{{ $referral->user->company }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-address">Address</label>
							<div class="col-sm-9">
								<input type="text" id="input-address" class="form-control" name="address" value="{{ $referral->user->address }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-description">Description</label>
							<div class="col-sm-9">
								<textarea class="form-control" name="description" id="input-description" rows="3">{{ $referral->user->description }}</textarea>
							</div>
						</div>

						{{-- If product have lead --}}
						@if($product->lead_reward)

							{{-- If lead approved and paid --}}
							@if($referral->lead_status == 'Approved')
								<div class="form-group">
									<label class="col-sm-2 control-label">Lead status</label>
									<div class="col-sm-9">
										<p class="form-control-static">{{ $referral->lead_status }} and Paid</p>
									</div>
								</div>
							@else
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-lead-status">Lead status</label>
									<div class="col-sm-9">
										<select class="form-control" id="input-lead-status" name="lead_status">
											<option value="Pending" {{ $referral->lead_status == 'Pending' ? 'selected' : '' }}>Pending</option>
											<option value="Approved" {{ $referral->lead_status == 'Approved' ? 'selected' : '' }}>Approved</option>
										</select>
									</div>
								</div>
							@endif

						@endif

						@if($referral->status == 'Approved')
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-value">Value</label>
								<div class="col-sm-9">
									<p class="form-control-static">{{ $referral->value or '---' }}</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status">Status</label>
								<div class="col-sm-9">
									<p class="form-control-static">{{ $referral->status }} and Paid</p>
								</div>
							</div>
						@else
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-value">Value</label>
								<div class="col-sm-9">
									<input type="number" id="input-value" class="form-control" name="value" value="{{ $referral->value }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-status">Status</label>
								<div class="col-sm-9">
									<select class="form-control" id="input-status" name="status">
										<option value="Pending contact" {{ $referral->status == 'Pending contact' ? 'selected' : '' }}>Pending contact</option>
										<option value="In progress" {{ $referral->status == 'In progress' ? 'selected' : '' }}>In progress</option>
										<option value="Agreement achieved" {{ $referral->status == 'Agreement achieved' ? 'selected' : '' }}>Agreement achieved</option>
										<option value="Approved" {{ $referral->status == 'Approved' ? 'selected' : '' }}>Approved</option>
										<option value="Declined" {{ $referral->status == 'Declined' ? 'selected' : '' }}>Declined</option>
										<option value="Withdrew" {{ $referral->status == 'Withdrew' ? 'selected' : '' }}>Withdrew</option>
									</select>
								</div>
							</div>
						@endif
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-9">
								<button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
								<a href="{{ route('site.ref.bizReferrals') }}" role="button" class="btn btn-primary waves-effect waves-light">
									Back
								</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-sm-4">
				@include('modules.ref-message')
			</div>
		</div>
	</div>
@endsection

@section('scripts')
    <!-- XEditable Plugin -->
    <script type="text/javascript" src="/assets/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap.file-input.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // change style input file
            $('#file_attach').bootstrapFileInput();

            var measure = '{{ $referral->product->measure }}';

            // change select block
            $('#input-status').change(function () {

                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;

                var inputValue = $('#input-value');

                if( measure == '%' && valueSelected == 'Approved' && !inputValue.val()){

                    var errorsHtml = '<span class="help-block">How much the deal is worth?</span>';

                    // add error class
                    inputValue.parent().parent().addClass('has-error').children('.col-sm-9').append(errorsHtml);
                    inputValue.prop('required', true);

                }else{
                    inputValue.parent().parent().removeClass('has-error');
                    inputValue.prop('required', false);
                }
            });

        } );
    </script>
@endsection