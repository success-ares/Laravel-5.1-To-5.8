@extends('layout')

@section('title', 'Create new business')

@section('content')
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-title">Register your business</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card-box">
					<form class="form-horizontal" role="form" method="post" action="{{ route('site.biz.store') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="form-group">
							<label class="col-md-2 control-label" for="input_first_name">Business name</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_first_name" name="biz_name" value="{{ old('biz_name') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_phone">Phone number</label>
							<div class="col-md-10">
								<input class="form-control" type="tel" id="input_phone" name="phone" value="{{ old('phone') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_email">Email</label>
							<div class="col-md-10">
								<input class="form-control" type="email" id="input_email" name="email" value="{{ old('email') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_last_name">Contact person</label>
							<div class="col-md-10">
								<input class="form-control" type="text" id="input_last_name" name="contact_person" value="{{ old('contact_person') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="input_description">Public description</label>
							<div class="col-md-10">
								<textarea class="form-control" id="input_description" name="description" rows="3">{{ old('description') }}</textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="first_select">Business category</label>
							<div class="col-md-5">
								<select id="first_select" class="form-control">
									<option value="">---</option>
									@foreach($categories as $category)
										<option value="{{$category->code}}">{{ $category->category_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-5">
								<select id="second_select" title="Business Category" class="form-control" name="category_code" required>
									<option value="">---</option>
									@foreach($subCategories as $subCategory)
										<option value="{{ $subCategory->code }}" class="{{ $subCategory->parent_code }}">{{ $subCategory->category_name }}</option>
									@endforeach
								</select>
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-2 control-label" for="input_logo">Upload logo</label>
							<div class="col-md-10">
								<input type="file" id="input_logo" name="logo">
							</div>
						</div>

						<div class="row">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<!--/ meta -->
			</div>

			<div class="col-sm-4">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Pyramd Tips</h4>
					<p>
						Log your business details here. The company email and contact person can be your details, or the 
						details of someone else in your company. Write a clear outline of your business, what it offers and 
						why it’s awesome in the public description. Accurate and compelling information will help users 
						decide if you’re the right company for the lead they want to refer.<br />
						Next, you’ll create your referral programs, providing rewards in exchange for successful leads.
					</p>
				</div>

			</div>
		</div>
		<!-- end row -->
    </div>

@endsection

@section('scripts')
    <script src="/assets/plugins/chained/jquery.chained.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#second_select').chained('#first_select');
        })
    </script>
@endsection