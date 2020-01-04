@extends('layout')

@section('title', 'Profile view')

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
					<div class="profile-info-name">
						@if($user->photo)
							<img src="{{ '/images/avatars/'.$user->photo }}" class="img-thumbnail" alt="profile-image">
						@else
							<img src="/assets/images/upload_photo.png" class="img-thumbnail" alt="profile-image">
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
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Team Members</h4>

					{{--<ul class="list-group m-b-0 user-list">
                    @if($user->userFollowers->isEmpty())
                        <li class="list-group-item">
                            <div class="user-desc">
                                <span class="name">User don't have referrals</span>
                            </div>
                        </li>
                    @else
                        @foreach($user->userFollowers as $referral)
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

			</div>
		</div>
    <!-- end row -->
    </div>
@endsection