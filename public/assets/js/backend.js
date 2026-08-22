(function ($) {

    'use strict';

    $('.has-submenu > a').on('click', function (e) {
        e.preventDefault();

        const $parent = $(this).parent('.has-submenu');
        const $submenu = $parent.children('.submenu');

        $('.has-submenu')
            .not($parent)
            .removeClass('active')
            .children('.submenu')
            .slideUp(300);

        $parent.toggleClass('active');

        $submenu.stop(true, true).slideToggle(300);
    });

    $(".account-info .current").on("click", function (event) {
        event.preventDefault();
        $(this).parent().toggleClass("active");
    });

    $(".open-menu").on("click", function (event) {
        event.preventDefault();
        $('.dashboard-sidebar,.dashboard-overlay').toggleClass("active");
    });

    $(".close-menu,.dashboard-overlay").on("click", function (event) {
        event.preventDefault();
        $('.dashboard-sidebar,.dashboard-overlay').removeClass("active");
    });


})(jQuery);
