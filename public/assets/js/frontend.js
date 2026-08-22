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

})(jQuery);
