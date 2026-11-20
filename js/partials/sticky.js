/**
 * Webokids - ficha de producto: columna sticky, "ver más" de la galería y zoom.
 *
 * Fuente:      js/partials/sticky.js
 * Minificado:  js/partials-min/sticky.min.js
 * Compilar:    php ditto build:partial-js sticky   (o npm run build:js)
 *
 * Se encola solo desde woocommerce/content-single-product.php.
 */
(function ($, window, document) {
    'use strict';

    function exists(selector) {
        return document.querySelector(selector) !== null;
    }

    /*============= Columna de información sticky (desktop) =============*/
    function initStickySummary() {
        if (!exists('.content-product-sticky') || !exists('.body-post') || !exists('.end-sticky')) return;

        var $sticky = $('.content-product-sticky');
        var $row = $('#row-product-details');
        var $start = $('.body-post');
        var $end = $('.end-sticky');
        var ticking = false;

        function update() {
            ticking = false;
            if ($(window).width() <= 768) return;

            var scroll = $(window).scrollTop();
            var position = $start.offset().top;
            var endPosition = $end.offset().top - 580;

            if (scroll >= position) {
                $sticky.addClass('sticky');
            }
            if (scroll >= endPosition) {
                $sticky.removeClass('sticky');
                $row.addClass('align-items-end');
            }
            if (scroll < position) {
                $sticky.removeClass('sticky');
                $row.removeClass('align-items-end');
            }
        }

        window.addEventListener('scroll', function () {
            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame(update);
            }
        }, { passive: true });
    }

    /*============= Ver más / ver menos imágenes =============*/
    function initShowMoreImages() {
        if (!exists('.show-more-img')) return;

        var $button = $('.show-more-img');
        var expanded = false;

        $button.on('click', function (e) {
            e.preventDefault();
            expanded = !expanded;
            $('.this-hidden').toggleClass('d-none', !expanded);
            $button.find('.more').toggleClass('d-none', expanded);
            $button.find('.less').toggleClass('d-none', !expanded);
            $button.attr('aria-expanded', expanded ? 'true' : 'false');
        });
    }

    /*============= Zoom de imágenes =============*/
    function initZoom() {
        if (!exists('.zoom-trigger') || !$.fn.zoom) return;

        $('.zoom-trigger').each(function () {
            var $trigger = $(this);
            $trigger.zoom({
                url: $trigger.attr('href'),
                magnify: 2
            });
        });
    }

    $(function () {
        initStickySummary();
        initShowMoreImages();
        initZoom();
    });
})(jQuery, window, document);
