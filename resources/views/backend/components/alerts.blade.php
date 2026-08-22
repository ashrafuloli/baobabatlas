<script>
    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | Global Toast Configuration
        |--------------------------------------------------------------------------
        */

        const Toast = Swal.mixin({

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
        | Session Success
        |--------------------------------------------------------------------------
        */

        @if(session('success'))

        Toast.fire({
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

        Toast.fire({
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

        Toast.fire({
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

        Toast.fire({
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

        Toast.fire({
            icon: 'error',
            title: @json($errors->first())
        });

        @endif

    });
</script>
