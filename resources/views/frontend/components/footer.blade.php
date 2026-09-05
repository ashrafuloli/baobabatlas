
<footer class="footer-section" style="background-image: url({{asset('assets/img/bg/bg-2.jpg')}});">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="footer-grid">

                    <!-- Logo -->
                    <div class="footer-brand">
                        <a href="#" class="f-logo">
                            <img src="{{asset('logo-white.png')}}" alt="logo">
                        </a>

                        <div class="social-links">
                            <a href="#"><i class="ri-facebook-fill"></i></a>
                            <a href="#"><i class="ri-twitter-x-fill"></i></a>
                            <a href="#"><i class="ri-linkedin-fill"></i></a>
                            <a href="#"><i class="ri-instagram-line"></i></a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-links">
                        <h4>Quick Links</h4>

                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Track Shipment</a></li>
                            <li><a href="#">Marketplace</a></li>
                        </ul>
                    </div>

                    <!-- Company -->
                    <div class="footer-links">
                        <h4>Company</h4>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Partners</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">News</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="footer-links">
                        <h4>Support</h4>

                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div class="newsletter">

                        <h4>Newsletter</h4>

                        <p>
                            Subscribe to get updates and news about our services.
                        </p>

                        <form>
                            <input type="email" placeholder="Enter your email">

                            <button type="submit">
                                <i class="ri-send-plane-fill"></i>
                            </button>
                        </form>

                    </div>

                </div>
                <div class="footer-bottom">
                    © 2026 Baobab Atlas. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- Vendors Js -->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/popper/popper.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('assets/vendor/fancybox/fancybox.umd.js')}}"></script>
<script src="{{asset('assets/vendor/sweetalert2/sweetalert2@11.js')}}"></script>


<!-- Main Js -->
<script src="{{asset('assets/js/frontend.js')}}"></script>

@include('frontend.components.alerts')

<!-- Page Specific Js -->
@stack('scripts')
</body>

</html>
