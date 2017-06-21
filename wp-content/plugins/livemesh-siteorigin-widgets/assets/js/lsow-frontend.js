/**
 * Reviews JS
 */
if (typeof (jQuery) != 'undefined') {

    jQuery.noConflict(); // Reverts '$' variable back to other JS libraries

    (function ($) {
        "use strict";

        $(function () {


            var LSOW_Frontend = {

                init: function () {
                    this.output_custom_css();
                    this.carousel();
                    this.setup_parallax();
                    this.setup_ytp();
                },

                output_custom_css: function () {

                    var custom_css = lsow_settings['custom_css'];
                    if (custom_css !== undefined && custom_css != '') {
                        custom_css = '<style type="text/css">' + custom_css + '</style>';
                        $('head').append(custom_css);
                    }
                },

                isMobile: function () {
                    "use strict";
                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        return true;
                    }
                    return false;
                },

                vendor_prefix: function () {

                    var prefix;

                    function prefix() {
                        var styles = window.getComputedStyle(document.documentElement, '');
                        prefix = (Array.prototype.slice.call(styles).join('').match(/-(moz|webkit|ms)-/) || (styles.OLink === '' && ['', 'o']))[1];

                        return prefix;
                    }

                    prefix();

                    return prefix;
                },

                carousel: function () {

                    if ($().slick === undefined) {
                        return;
                    }

                    var carousel_elements = $('.lsow-carousel, .lsow-posts-carousel, .lsow-gallery-carousel');

                    carousel_elements.each(function () {

                        var carousel_elem = $(this);

                        var arrows = carousel_elem.data('arrows') ? true : false;

                        var dots = carousel_elem.data('dots') ? true : false;

                        var autoplay = carousel_elem.data('autoplay') ? true : false;

                        var autoplay_speed = carousel_elem.data('autoplay_speed') || 3000;

                        var animation_speed = carousel_elem.data('animation_speed') || 300;

                        var fade = carousel_elem.data('fade') ? true : false;

                        var pause_on_hover = carousel_elem.data('pause_on_hover') ? true : false;

                        var display_columns = carousel_elem.data('display_columns') || 4;

                        var scroll_columns = carousel_elem.data('scroll_columns') || 4;

                        var gutter = carousel_elem.data('gutter') || 10;

                        var tablet_width = carousel_elem.data('tablet_width') || 800;

                        var tablet_display_columns = carousel_elem.data('tablet_display_columns') || 2;

                        var tablet_scroll_columns = carousel_elem.data('tablet_scroll_columns') || 2;

                        var mobile_width = carousel_elem.data('mobile_width') || 480;

                        var mobile_display_columns = carousel_elem.data('mobile_display_columns') || 1;

                        var mobile_scroll_columns = carousel_elem.data('mobile_scroll_columns') || 1;

                        carousel_elem.slick({
                            arrows: arrows,
                            dots: dots,
                            infinite: true,
                            autoplay: autoplay,
                            autoplaySpeed: autoplay_speed,
                            speed: animation_speed,
                            fade: false,
                            pauseOnHover: pause_on_hover,
                            slidesToShow: display_columns,
                            slidesToScroll: scroll_columns,
                            responsive: [
                                {
                                    breakpoint: tablet_width,
                                    settings: {
                                        slidesToShow: tablet_display_columns,
                                        slidesToScroll: tablet_scroll_columns
                                    }
                                },
                                {
                                    breakpoint: mobile_width,
                                    settings: {
                                        slidesToShow: mobile_display_columns,
                                        slidesToScroll: mobile_scroll_columns
                                    }
                                }
                            ]
                        });
                    });
                },

                setup_parallax: function () {

                    var scroll = window.requestAnimationFrame ||
                        window.webkitRequestAnimationFrame ||
                        window.mozRequestAnimationFrame ||
                        window.msRequestAnimationFrame ||
                        window.oRequestAnimationFrame ||
                        function (callback) {
                            window.setTimeout(callback, 1000 / 600);
                        };

                    function init_parallax() {

                        if (LSOW_Frontend.isMobile() === false) {
                            var windowHeight = $(window).height();
                            $('.lsow-section-bg-parallax').each(function () {
                                var segment = $(this);
                                var elementHeight = segment.outerHeight(true);

                                /* Apply transform only when the element is in the viewport */
                                var boundingRect = segment[0].getBoundingClientRect();
                                if (boundingRect.bottom >= 0 && boundingRect.top <= windowHeight) {
                                    var distanceToCover = windowHeight + elementHeight;
                                    var pixelsMoved = windowHeight - boundingRect.top;
                                    var toTransform = 50; // only 50% of the image height is available for transforming
                                    var transformPercent = toTransform * Math.abs(pixelsMoved / distanceToCover);
                                    transformPercent = -transformPercent.toFixed(2); // not more than 2 decimal places for performance reasons

                                    segment.find('.lsow-parallax-bg').css('-' + LSOW_Frontend.vendor_prefix() + '-transform', 'translate3d(0px, ' + transformPercent + '%, 0px)');
                                }
                            });
                        }

                    }

                    if (this.isMobile() === false) {

                        // Call once to initialize parallax and then call on each scroll
                        scroll(init_parallax);
                        $(window).on('scroll', function () {
                            scroll(init_parallax);
                        });
                    }

                },

                setup_ytp: function () {

                    // Do not initialize YouTube backgrounds in mobile devices
                    if (this.isMobile() || $().mb_YTPlayer === undefined) {
                        return;
                    }

                    /* Video Backgrounds */
                    $('.lsow-section-bg-youtube').mb_YTPlayer({
                        startAt: 0,
                        showYTLogo: false,
                        showControls: false,
                        autoPlay: true,
                        mute: true,
                        containment: 'self'});


                },
            }

            LSOW_Frontend.init();

        });

    }(jQuery));

}