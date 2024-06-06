(function ($) {
    "use strict";
    $(document).ready(function () {
        $('.live-auctions').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            prevArrow: '<i class="bi bi-chevron-left live-left-arrow"></i>',
            nextArrow: '<i class="bi bi-chevron-right live-right-arrow"></i>',
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    arrows: false,
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false,
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                }
            }]
        });

        $('nav a[href^="#"]').click(function(e) {
            e.preventDefault();
            var targetId = $(this).attr('href');
            var target = $(targetId);
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - $('nav').outerHeight()
                }, 1000, function() {
                    $('.navbar-toggler').trigger('click');
                });
                window.location.hash = targetId;
            }
        });

        $('section a[href^="#"]').click(function(e) {
            e.preventDefault();
            var targetId = $(this).attr('href');
            var target = $(targetId);
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                window.location.hash = targetId;
            }
        });
    });
})(jQuery);

function displayToast(type, messages) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
        icon: type,
        title: messages
    });
}