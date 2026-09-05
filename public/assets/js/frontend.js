(function ($) {

    'use strict';

    /*  ============================================
        faq
        =============================================== */
    $(".faq-question").on("click", function (event) {
        event.preventDefault();
        var question = $(this).parent();
        question.addClass("active");
        question.find('.faq-answer').show(200);
        question.siblings().removeClass('active').children('.faq-answer').hide(200);
    });


    /*  ============================================
            Mobile Menu
        =============================================== */
    $(".open-menu").on("click", function (event) {
        event.preventDefault();
        $(".offcanvas-wrapper").addClass("active");
    });

    $(".offcanvas-close").on("click", function (event) {
        event.preventDefault();
        $(".offcanvas-wrapper").removeClass("active");
    });


    /*  ============================================
            Check Cart
    =============================================== */
    function checkHeaderCart() {
        var cartCount =
            parseInt($('.header-cart-count').html(), 10) || 0;

        if (cartCount > 0) {
            $('.header-cart').addClass('show');
        } else {
            $('.header-cart').removeClass('show');
        }
    }

    checkHeaderCart();

    $('.product-add-cart').on('click', function () {
        setTimeout(function () {
            checkHeaderCart();
        }, 500);
    });

    $('.cart-item-remove').on('click', function () {
        setTimeout(function () {
            location.reload();
        }, 500);
    });


})(jQuery);
