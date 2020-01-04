<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/favicon.png">

    <title>@yield('title', 'Pyramd')</title>

    <meta name="description" content="@yield('description', config('settings.description') )">
    <meta name="keywords" content="@yield('keywords', config('settings.keywords') )">
    <meta property="og:title" content="@yield('ogTitle', config('settings.title') )">
    <meta property="og:type" content="@yield('ogType', 'website')">
    <meta property="og:locale" content="en_EN">
    <meta property="og:url" content="@yield('ogUrl', \Request::url())">
    <meta property="og:site_name" content="{{ config('settings.siteName') }}">
    <meta property="og:image" content="@yield('ogImage', config('settings.siteImage'))" />
    <meta property="og:description" content="@yield('ogDescription', config('settings.description'))">
    <meta name="_token" content="{{ csrf_token() }}"/>

    @yield('first-styles')

    <!-- Notification css (Toastr) -->
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/responsive.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/dashboard.css" rel="stylesheet" type="text/css" />
	
    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    @yield('styles')

    <script src="/assets/js/modernizr.min.js"></script>

</head>


<body>

<!-- Navigation Bar-->
<header id="topnav">
	@include('modules.beta-message')
    <div class="topbar-main">
        <div class="container">

            <!-- LOGO -->
            <div class="topbar-left hidden-xs">
                <a href="{{ URL::to('/') }}" class="logo"><img src="/assets/images/pyramd_logo.png" /></a>
            </div>
			
			<div class="topbar-center">
                <img src="/assets/images/pyramd-icon.png" width="42" />
            </div>

            <!-- End Logo container-->

            @include('modules.header-bar')

        </div>
    </div>

    @include('modules.nav-bar')

</header>
<!-- End Navigation Bar-->

<div class="wrapper">
    
	@yield('content')

	<!-- Footer -->
	@include('modules.footer')
	<!-- End Footer -->
		
    <!-- end container -->

    @if(Auth::check())
        @include('modules.right-sidebar')
    @endif

</div>

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

<script src="/assets/js/dashboard.js"></script>

<!-- Notifications -->
@include('modules.notifications')

{{-- Right bar --}}
<script>
    $(document).ready(function () {
        // token
        var CSRF_TOKEN = $('input[name="_token"]').val();

        // show bell alert, if exist notifications
        alertBell();

        $('.read-button').on('click', function () {

            // notification id
            var id = $(this).data('notification-id');

            deleteMessage(id);

        });

        $('.notification-link').on('click', function (evt) {

            evt.preventDefault();

            // get url
            var url = $(this).attr('href');

            // notification id
            var id = $(this).parent().data('notification-id');

            //deleteMessage(id);
            if (deleteMessage(id)){
                // go to url
                window.location.href = url;
            }


        });

        function alertBell() {

            // notifications bell
            var bell = $('.noti-dot');

            // get notifications length
            var notifications = $('.user-list-item').length;

            // if notifications exist
            if ( notifications ){
                // delete hidden class
                if ( bell.hasClass('hidden') ){
                    bell.removeClass('hidden');
                }

            }else{
                // add hidden class
                if ( !bell.hasClass('hidden') ){
                    bell.addClass('hidden');
                }
            }
        }

        function deleteMessage(id) {
            return $.ajax({
                url: "{{ route('site.notification.delete') }}",
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function (data) {
                    // if ok - hide notification
                    if (data){
                        $('#notification-' + id).hide(500).remove();

                        // bell
                        alertBell();
                    }
                }
            });
        }
    });
</script>

@yield('scripts')

</body>
</html>