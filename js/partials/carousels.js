/**
 * Webokids - carruseles Owl (banner del home, galerías y galería móvil de producto).
 *
 * Fuente:      js/partials/carousels.js
 * Minificado:  js/partials-min/carousels.min.js
 * Compilar:    php ditto build:partial-js carousels   (o npm run build:js)
 *
 * Se encola solo desde los partials que tienen carrusel (webokids_enqueue_carousels()).
 */
(function ($, document) {
    'use strict';

    function exists(selector) {
        return document.querySelector(selector) !== null;
    }

    var arrows = ['<span></span>', '<span></span>'];
    var isEn = /^en/i.test(document.documentElement.lang || '');
    var labels = isEn ? { prev: 'Previous slide', next: 'Next slide' } : { prev: 'Diapositiva anterior', next: 'Diapositiva siguiente' };

    /**
     * Owl crea las flechas como <button role="presentation"> sin texto: se les da nombre accesible.
     */
    function labelNav($carousel) {
        $carousel.find('.owl-prev').removeAttr('role').attr('aria-label', labels.prev);
        $carousel.find('.owl-next').removeAttr('role').attr('aria-label', labels.next);
    }

    /*============= Banner del home =============*/
    function initHomeBanner() {
        if (!exists('.banner-slide')) return;

        var $banner = $('.banner-slide');
        $banner.on('refreshed.owl.carousel', function () {
            labelNav($banner);
        });

        $banner.owlCarousel({
            autoplay: true,
            loop: true,
            nav: true,
            navText: arrows,
            dots: false,
            margin: 0,
            items: 1,
            responsive: {
                0: { nav: false },
                768: { nav: true }
            }
        }).css({ opacity: 1 });

        // Las flechas existen cuando termina la inicialización.
        labelNav($banner);
    }

    /*============= Galerías genéricas (banners) =============*/
    function initGalleries() {
        if (!exists('.galleries')) return;

        $('.galleries').owlCarousel({
            autoplay: true,
            loop: true,
            nav: false,
            dots: false,
            margin: 0,
            responsive: {
                0: { items: 1 },
                640: { items: 2 },
                991: { items: 3 }
            }
        }).css({ opacity: 1 });
    }

    /*============= Galería de producto en móvil =============*/
    function initProductGallerySlide() {
        if (!exists('.gallery-slide')) return;

        $('.gallery-slide').owlCarousel({
            autoplay: false,
            loop: false,
            nav: false,
            dots: true,
            margin: 0,
            items: 1
        });
    }

    $(function () {
        if (!$.fn.owlCarousel) return;
        initHomeBanner();
        initGalleries();
        initProductGallerySlide();
    });
})(jQuery, document);
