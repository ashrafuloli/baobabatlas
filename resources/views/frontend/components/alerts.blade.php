<script>
    /*
    |--------------------------------------------------------------------------
    | Global Toast Configuration
    |--------------------------------------------------------------------------
    */

    window.AppToast = Swal.mixin({
        toast: true,

        position: 'top-end',

        showConfirmButton: false,

        timer: 3500,

        timerProgressBar: true,

        showCloseButton: true,

        didOpen: (toast) => {

            toast.addEventListener(
                'mouseenter',
                Swal.stopTimer
            );

            toast.addEventListener(
                'mouseleave',
                Swal.resumeTimer
            );

        }
    });


    /*
    |--------------------------------------------------------------------------
    | Session Alerts
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Session Success
            |--------------------------------------------------------------------------
            */

            @if(session('success'))

            window.AppToast.fire({
                icon: 'success',
                title: @json(session('success'))
            });

            @endif


            /*
            |--------------------------------------------------------------------------
            | Session Error
            |--------------------------------------------------------------------------
            */

            @if(session('error'))

            window.AppToast.fire({
                icon: 'error',
                title: @json(session('error'))
            });

            @endif


            /*
            |--------------------------------------------------------------------------
            | Session Warning
            |--------------------------------------------------------------------------
            */

            @if(session('warning'))

            window.AppToast.fire({
                icon: 'warning',
                title: @json(session('warning'))
            });

            @endif


            /*
            |--------------------------------------------------------------------------
            | Session Info
            |--------------------------------------------------------------------------
            */

            @if(session('info'))

            window.AppToast.fire({
                icon: 'info',
                title: @json(session('info'))
            });

            @endif


            /*
            |--------------------------------------------------------------------------
            | Validation Errors
            |--------------------------------------------------------------------------
            */

            @if($errors->any())

            window.AppToast.fire({
                icon: 'error',
                title: @json($errors->first())
            });

            @endif

        }
    );
</script>
