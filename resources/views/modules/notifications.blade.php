@if( $errors->any() || session('success') || session('error') )
<script>
    $(document).ready(function() {

        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-bottom-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "10000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // messages
        @if( session('success') )

            // for success - green box
            toastr.success( '{{ session('success') }}' );

        @elseif( session('error') )

            // for errors - red box
            toastr.error( '{{ session('error') }}' );

        @elseif( $errors->any() )

            @foreach($errors->all() as $error)
                toastr.error( '{{ $error }}' );
            @endforeach

        @endif

    });
</script>
@endif