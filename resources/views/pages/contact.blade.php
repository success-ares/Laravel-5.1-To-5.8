@extends('pages.layout')

@section('title', 'Contact')

@section('content')
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron home-top top-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-centered">
                    <h1 class="white-c">Contacts</h1>
                </div>
            </div>
        </div>
    </div>


    <div class="jumbotron">
	    <div class="container">
		    <div class="row">
			    <div class="col-md-12">
				    <h2>Contact Us</h2>
				    <div class="separator"></div>
				    <form class="form-horizontal" role="form" method="post" action="{{ route('postcontact') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="form-group">
							<label class="col-md-2 control-label" for="input_message">Email</label>
							<div class="col-md-10">
								<input class="form-control" type="email" name="email">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_message">Message</label>
							<div class="col-md-10">
								<textarea class="form-control" id="input_message" name="message" rows="3"></textarea>
							</div>
						</div>

						<div class="row">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>
					</form>
			    </div>
		    </div>
	    </div>
    </div>
@endsection