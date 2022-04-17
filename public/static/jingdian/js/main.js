(function ($) {
    'use strict';
    $(window).on('load',function(){
        //==========preloder===========
        var preLoder = $(".preloader");
        preLoder.fadeOut(1000);
    });

//更多精品模板：http://www.bootstrapmb.com

    //==========fixed header & scroll to top button===========
    $(window).on('scroll', function(){
        if($(window).scrollTop() > 300) {
            $('.header').addClass('animated fadeInDown fixed-header');
            $('.scroll-to-top').fadeIn();
            $('.scroll-to-top button').addClass('active');
        } else {
            $('.header').removeClass('animated fadeInDown fixed-header');
            $('.scroll-to-top').fadeOut();
            $('.scroll-to-top button').removeClass('active');
        }
    });
    $(document).ready(function(){
        
        // ========== testimonial slider for home page one ===========
        $('.comment-slider').owlCarousel({
            loop: true,
            smartSpeed: 1000,
            margin: 0,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            center: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                576: {
                    items: 1.5
                },
                768: {
                    items: 2
                },
                960: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        });

        // ========== testimonial slider for home page two===========
        var testimonialSlider = $('.comment-slider-2');
        testimonialSlider.owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            smartSpeed: 1000,
            autoplay: true,
            thumbs: true,
            thumbsPrerendered: true,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                576: {
                    items: 1
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                },
                1920: {
                    items: 1
                }
            }
        });
        $('.owl-next').on('click', function() {
            testimonialSlider.trigger('next.owl.carousel');
        })
        $('.owl-prev').on('click', function() {
            testimonialSlider.trigger('prev.owl.carousel', [300]);
        })
        
        // ========== project slider for home page one ===========
        $('.portfolio-slider').owlCarousel({
            items: 3,
            loop: true,
            smartSpeed: 1000,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            center: true,
            responsive: {
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                576: {
                    items: 1.8
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        });
        
        // ========== service slider for home page two ===========
        $('.service-slider').owlCarousel({
            loop: true,
            smartSpeed: 1000,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            center: true,
            dots: false,
            nav: true,
            navText: ['<i class="icofont-double-left"></i>','<i class="icofont-double-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1.5
                },
                576: {
                    items: 1.6
                },
                768: {
                    items: 2.1
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        });
        
        // ========== main image slider one project details page ===========
        $('.project-details-slider').owlCarousel({
            items: 1,
            loop: true,
            smartSpeed: 1000,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            center: true,
            autoWidth:true,
            dots: false
        });

        // ========== related project slider one project details page ===========
        $('.rel-slider').owlCarousel({
            loop: true,
            smartSpeed: 1000,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: false,
            dots: false,
            nav: true,
            navText: ['<i class="icofont-double-left"></i>','<i class="icofont-double-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1.5,
                    center: true
                },
                576: {
                    items: 2,
                    center: true
                },
                768: {
                    items: 3
                },
                960: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        });
    });
}(jQuery));