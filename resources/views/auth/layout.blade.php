<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.png">

    <!-- App title -->
    <title>@yield('title', 'Pyramd')</title>

    <!-- Notification css (Toastr) -->
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />

    <!-- App CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/auth.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="/assets/js/modernizr.min.js"></script>

</head>
<body>
	<div class="wrapper-page">
		<div class="text-center">
			<div class="logo-container">
				<a href="{{ URL::to('/') }}" class="logo">
					<img src="/assets/images/pyramd-icon.png" width="62" />
					<img src="/assets/images/pyramd_logo.png" />
				</a>
			</div>
			<h5 class="text-white m-t-20 font-600">{{ config('settings.slogan') }}</h5>
		</div>
		@yield('content')
	</div>
	<!-- end wrapper page -->



	<script>
		var resizefunc = [];
	</script>

	<!-- jQuery  -->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/bootstrap.min.js"></script>
	<script src="/assets/js/detect.js"></script>
	<script src="/assets/js/fastclick.js"></script>
	<script src="/assets/js/jquery.slimscroll.js"></script>
	<script src="/assets/js/jquery.blockUI.js"></script>
	<script src="/assets/js/waves.js"></script>
	<script src="/assets/js/wow.min.js"></script>
	<script src="/assets/js/jquery.nicescroll.js"></script>
	<script src="/assets/js/jquery.scrollTo.min.js"></script>

	<!-- Toastr js -->
	<script src="/assets/plugins/toastr/toastr.min.js"></script>

	<!-- App js -->
	<script src="/assets/js/jquery.core.js"></script>
	<script src="/assets/js/jquery.app.js"></script>
	@yield('scripts')

	<!-- Notifications -->
	@include('modules.notifications')

</body>
</html>