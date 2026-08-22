<!-- Vendors Js -->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/popper/popper.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('assets/vendor/fancybox/fancybox.umd.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/sweetalert2/sweetalert2@11.js')}}"></script>

<!-- Main Js -->
<script src="{{asset('assets/js/backend.js')}}"></script>

@include('backend.components.alerts')

<!-- Page Specific Js -->
@stack('scripts')
</body>

</html>
