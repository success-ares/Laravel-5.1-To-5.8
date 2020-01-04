@extends('layout')

@section('title', 'Friends')

@section('styles')
    <!-- JQueri-ui -->
    <link href="/assets/plugins/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">
@endsection

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Friends</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<div class="row">
						<div class="col-sm-12">
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam dignissimos, dolor illum perferendis provident quidem sunt temporibus!
								Adipisci asperiores deserunt, ea necessitatibus, officia omnis pariatur qui quia, recusandae similique voluptates?
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam asperiores aspernatur eius enim et,
								fugiat, illo incidunt ipsa iste laudantium maiores mollitia nam nesciunt omnis pariatur quas sed sunt voluptatem!
								<br>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi cumque fugit nostrum sunt temporibus.
								Accusamus corporis cupiditate deleniti dicta ducimus ea earum eligendi excepturi fuga iusto molestias, nam nulla porro!
							</p>
							<hr>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
							<button type="button" id="add-contact" class="btn btn-success btn-md waves-effect waves-light m-b-0">
								Add Contact
							</button>
						</div><!-- end col -->

						<div class="col-sm-4 hidden" id="add-contact-form">
							<form class="form-inline" method="post" action="{{ route('site.friend.store') }}">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="input-email">Email Address </label>
									<input type="email" class="form-control" id="input-email" name="email">
								</div>
								<button type="submit" class="btn btn-default waves-effect waves-light">Save</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end row -->

		@foreach($friends->chunk(3) as $chunk)
			<div class="row">
				@foreach($chunk as $friend)
					<div class="col-md-4">
						<div class="text-center card-box">
							<div class="dropdown pull-right">
								<a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
									<i class="zmdi zmdi-more-vert"></i>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ route('site.friend.delete', $friend->pivot->id) }}">Delete</a></li>
								</ul>
							</div>
							<div>
								@if($friend->photo)
									<img src="{{ asset('images/avatars/'.$friend->photo) }}" class="img-circle thumb-xl img-thumbnail m-b-10" alt="profile-image">
								@endif
								<p class="text-muted font-13 m-b-30">
									{{ $friend->description }}
								</p>

								<div class="text-left">
									<p class="text-muted font-13"><strong>Full Name :</strong> <span class="m-l-15">{{ $friend->first_name.' '.$friend->last_name }}</span></p>

									<p class="text-muted font-13"><strong>Phone :</strong><span class="m-l-15">{{ $friend->phone }}</span></p>

									<p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15">{{ $friend->email }}</span></p>

									<p class="text-muted font-13"><strong>Location :</strong> <span class="m-l-15">{{ $friend->address }}</span></p>
								</div>
							</div>

						</div>

					</div> <!-- end col -->
				@endforeach
			</div>
		@endforeach
	</div>
@endsection

@section('scripts')
    <!-- Jquery-ui -->
    <script src="/assets/plugins/jquery-ui-1.11.4/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function () {

            // add new friend form
            var form = $('#add-contact-form');

            $('#add-contact').on('click', function (event) {
                if ( form.hasClass('hidden') ){
                    // clean
                    $("#input-email").val('');

                    form.removeClass('hidden');
                }else{
                    form.addClass('hidden');
                }
            });

            // search user
            $("#input-email").autocomplete({
                source: "{{ route('site.ref.searchUser') }}",
                minLength: 2,
                delay: 500
            });

        })
    </script>

@endsection