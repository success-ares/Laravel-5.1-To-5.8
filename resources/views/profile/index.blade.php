@extends('layout')

@section('title', 'Profile')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Profile</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="bg-picture card-box">
					@if($user->activation_code)
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							Please confirm your new email address.
						</div>
					@endif
					<div class="profile-info-name">
						@if($user->photo)
							<a href="#input_photo">
								<img src="{{ '/images/avatars/'.$user->photo }}" data-toggle="tooltip" data-placement="top" title="Change photo"
									 class="img-thumbnail" alt="profile-image">
							</a>
						@else
							<a href="#input_photo">
								<img src="/assets/images/upload_photo.png" data-toggle="tooltip" data-placement="top" title="Upload photo"
									 class="img-thumbnail" alt="profile-image">
							</a>
						@endif


						<div class="profile-info-detail">
							<h3 class="m-t-0 m-b-0">{{ $user->first_name.' '.$user->last_name }}</h3>
							<p class="text-muted m-b-20"><i>{{ $user->company }}</i></p>
							<p>{{ $user->description }}</p>
						</div>

						<div class="clearfix"></div>
					</div>
				</div>
				<!--/ meta -->

				<div class="card-box">

					<h4 class="header-title m-t-0 m-b-30">Edit profile</h4>

					<div class="row">
						<div class="col-lg-12">
							<form class="form-horizontal" role="form" method="post" action="{{ route('site.profile.update') }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<input type="hidden" name="profile_id" value="{{ $user->id }}">
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_first_name">First name</label>
									<div class="col-md-10">
										<input class="form-control" type="text" id="input_first_name" name="first_name" value="{{ $user->first_name }}" required>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_last_name">Last name</label>
									<div class="col-md-10">
										<input class="form-control" type="text" id="input_last_name" name="last_name" value="{{ $user->last_name }}" required>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_email">Email</label>
									<div class="col-md-10">
										<input class="form-control" type="email" id="input_email" name="email" value="{{ $user->email }}" required>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_company_name">Company name</label>
									<div class="col-md-10">
										<input class="form-control" type="text" id="input_company_name" name="company" value="{{ $user->company }}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_company_url">Company Website URL</label>
									<div class="col-md-10">
										<input class="form-control" type="url" id="input_company_url" name="company_url" value="{{ $user->company_url }}" required placeholder="http://">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_phone">Phone number</label>
									<div class="col-md-10">
										<input class="form-control" type="tel" id="input_phone" name="phone" value="{{ $user->phone }}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_address">Address</label>
									<div class="col-md-10">
										<input class="form-control" type="tel" id="input_address" name="address" value="{{ $user->address }}">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_old_password">Old password</label>
									<div class="col-md-10">
										<input type="password" id="input_old_password" name="old_password" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_password">New password</label>
									<div class="col-md-10">
										<input type="password" id="input_password" name="password" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_confirm_password">Confirm new password</label>
									<div class="col-md-10">
										<input type="password" id="input_confirm_password" name="password_confirmation" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label" for="input_description">Public description</label>
									<div class="col-md-10">
										<textarea class="form-control" id="input_description" name="description" rows="3">{{ $user->description }}</textarea>
									</div>
								</div>
								<div class="form-group">
									@if($user->photo)
										<label class="col-md-2 control-label" for="input_photo">Change photo</label>
									@else
										<label class="col-md-2 control-label" for="input_photo">Upload photo</label>
									@endif
									<div class="col-md-10">
										<input type="file" id="input_photo" name="photo">
									</div>
								</div>
								<div class="row">
									<div class="col-md-offset-2 col-md-10">
										<button type="submit" class="btn btn-default waves-effect waves-light">Submit</button>
									</div>
								</div>
							</form>
						</div>

					</div><!-- end row -->
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">My Team Members</h4>

					{{--<ul class="list-group m-b-0 user-list">
						@if($referrals->isEmpty())
							<li class="list-group-item">
								<div class="user-desc">
									<span class="name">You don't have referrals</span>
								</div>
							</li>
						@else
							@foreach($referrals as $referral)
							<li class="list-group-item">
								<a href="{{ route('site.profile.view', [$referral->id]) }}" class="user-list-item">
									@if($referral->photo)
										<div class="avatar">
											<img src="{{ '/images/avatars/'.$referral->photo }}" alt="{{ $referral->first_name }}">
										</div>
									@else
										<div class="avatar">
											<img src="/assets/images/no_avatar.png" alt="no-avatar">
										</div>
									@endif
									<div class="user-desc">
										<span class="name">{{ $referral->first_name.' '.$referral->last_name }}</span>
										<span class="desc">{{ $referral->company }}</span>
									</div>
								</a>
							</li>
							@endforeach
						@endif
					</ul>--}}
				</div>

				<div class="card-box">

					<h4 class="header-title m-t-0 m-b-30"><i class="zmdi zmdi-notifications-none m-r-5"></i> My Reminders</h4>

					<ul class="list-group m-b-0 user-list">
						<li class="list-group-item">
							<a href="#" class="user-list-item">
								<div class="avatar text-center">
									<i class="zmdi zmdi-circle text-primary"></i>
								</div>
								<div class="user-desc">
									<span class="name">Meet Manager</span>
									<span class="desc">February 29, 2016 - 10:30am to 12:45pm</span>
								</div>
							</a>
						</li>

						<li class="list-group-item">
							<a href="#" class="user-list-item">
								<div class="avatar text-center">
									<i class="zmdi zmdi-circle text-success"></i>
								</div>
								<div class="user-desc">
									<span class="name">Project Discussion</span>
									<span class="desc">February 29, 2016 - 10:30am to 12:45pm</span>
								</div>
							</a>
						</li>

						<li class="list-group-item">
							<a href="#" class="user-list-item">
								<div class="avatar text-center">
									<i class="zmdi zmdi-circle text-pink"></i>
								</div>
								<div class="user-desc">
									<span class="name">Meet Manager</span>
									<span class="desc">February 29, 2016 - 10:30am to 12:45pm</span>
								</div>
							</a>
						</li>

						<li class="list-group-item">
							<a href="#" class="user-list-item">
								<div class="avatar text-center">
									<i class="zmdi zmdi-circle text-muted"></i>
								</div>
								<div class="user-desc">
									<span class="name">Project Discussion</span>
									<span class="desc">February 29, 2016 - 10:30am to 12:45pm</span>
								</div>
							</a>
						</li>

						<li class="list-group-item">
							<a href="#" class="user-list-item">
								<div class="avatar text-center">
									<i class="zmdi zmdi-circle text-danger"></i>
								</div>
								<div class="user-desc">
									<span class="name">Meet Manager</span>
									<span class="desc">February 29, 2016 - 10:30am to 12:45pm</span>
								</div>
							</a>
						</li>
					</ul>
				</div>

			</div>
		</div>
		<!-- end row -->
    </div>
@endsection