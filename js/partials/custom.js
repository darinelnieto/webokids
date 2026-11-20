/**
 * Webokids - scripts globales (se cargan en todas las vistas).
 *
 * Fuente:      js/partials/custom.js
 * Minificado:  js/partials-min/custom.min.js
 * Compilar:    php ditto build:partial-js custom   (o npm run build:js)
 *
 * Cada módulo valida que sus elementos existan en la vista antes de ejecutarse,
 * así una vista que no tenga, por ejemplo, FAQs no registra eventos de FAQs.
 */
(function ($, window, document) {
    'use strict';

    var Webokids = window.Webokids = window.Webokids || {};

    /**
     * true si el selector existe en la vista actual.
     */
    function exists(selector) {
        return document.querySelector(selector) !== null;
    }
    Webokids.exists = exists;

    /*============= Accesibilidad: role="button" con teclado =============*/
    // Los elementos que no son <button> pero actúan como botón responden a Enter y Espacio.
    function initKeyboardButtons() {
        $(document).on('keydown', '[role="button"]:not(button)', function (e) {
            if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar') {
                e.preventDefault();
                $(this).trigger('click');
            }
        });
    }

    /*============= Menú móvil =============*/
    function initMobileMenu() {
        if (!exists('.bar-menu') || !exists('.nav-contain')) return;

        var $bar = $('.bar-menu');
        var $nav = $('.nav-contain');

        $bar.on('click', function () {
            var open = !$nav.hasClass('active');
            $nav.toggleClass('active', open);
            $bar.attr('aria-expanded', open ? 'true' : 'false');
        });
    }

    /*============= Header sticky =============*/
    function initStickyHeader() {
        if (!exists('.header-contain')) return;

        var $header = $('.header-contain');
        var ticking = false;

        function update() {
            var limit = $header.height() - 10;
            $header.toggleClass('sticky', $(window).scrollTop() >= limit);
            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame(update);
            }
        }, { passive: true });

        update();
    }

    /*============= Checkbox de políticas =============*/
    // Delegado: el contenedor puede llegar por AJAX (formularios / checkout).
    function initPoliciesCheckbox() {
        $(document).on('click', '.policies-container label', function () {
            var checked = $('input[type="checkbox"]', this).prop('checked');
            $('.checkbox', this).toggleClass('active', !!checked);
        });
    }

    /*============= Slide de productos (home, landing y relacionados) =============*/
    function initProductsSlideNav() {
        if (!exists('.nav-slide-products')) return;

        $('.nav-slide-products').each(function () {
            var $nav = $(this);
            var $list = $nav.closest('.container').find('.product-list');
            var $prev = $nav.find('.prev');
            var $next = $nav.find('.next');

            if (!$list.length) {
                $list = $('.product-list');
            }

            function setAtStart(atStart) {
                $prev.toggleClass('disabled', atStart).attr('aria-disabled', atStart ? 'true' : 'false');
                $next.toggleClass('disabled', !atStart).attr('aria-disabled', atStart ? 'false' : 'true');
            }

            setAtStart(true);

            // Con 3 productos o menos la lista no desborda: sin scroll no hay nada que navegar,
            // así que las flechas se ocultan. Se recalcula al cambiar el tamaño de la ventana.
            function updateVisibility() {
                var list = $list.get(0);
                var overflows = !!list && list.scrollWidth - list.clientWidth > 2;
                $nav.toggleClass('d-none', !overflows).attr('aria-hidden', overflows ? 'false' : 'true');
                if (!overflows) {
                    $list.scrollLeft(0);
                    setAtStart(true);
                }
            }

            var resizeTimer = null;
            $(window).on('resize', function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(updateVisibility, 150);
            });
            // Las imágenes pueden cambiar el ancho de las tarjetas al terminar de cargar.
            $(window).on('load', updateVisibility);
            updateVisibility();

            $next.on('click', function (e) {
                e.preventDefault();
                if ($next.hasClass('disabled')) return;
                $list.scrollLeft($list.width() + 50);
                setAtStart(false);
            });

            $prev.on('click', function (e) {
                e.preventDefault();
                if ($prev.hasClass('disabled')) return;
                $list.scrollLeft(0);
                setAtStart(true);
            });
        });
    }

    /*============= Galería de producto de WooCommerce =============*/
    function initWooGalleryHover() {
        if (!exists('.woocommerce-product-gallery__image')) return;

        var $images = $('.woocommerce-product-gallery__image');
        $images.on('mouseover', function () {
            $images.removeClass('flex-active-slide');
            $(this).addClass('flex-active-slide');
        });
    }

    /*============= Variaciones (tallas) =============*/
    function initVariations() {
        if (!exists('#options-color')) return;

        var $options = $('#options-color li');

        $('#options-color').on('click', 'li', function () {
            var $item = $(this);
            var option = $item.children('.variation-checkbox').val();

            $options.removeClass('active').attr('aria-pressed', 'false');
            $('#pa_essize').val(option).trigger('change');

            var stock = $('.woocommerce-variation-availability p').text();
            if (stock === 'Agotado' || stock === 'Out of stock') {
                $item.addClass('disabled').attr('aria-disabled', 'true');
            } else {
                $item.addClass('active').attr('aria-pressed', 'true');
            }
        });

        $('.reset_variations').on('click', function () {
            $options.removeClass('active').attr('aria-pressed', 'false');
        });
    }

    /*============= FAQs (acordeón) =============*/
    function initFaqs() {
        if (!exists('.fqas-list .question')) return;

        var $items = $('.fqas-list .fqa-item');

        $('.fqas-list').on('click', '.question', function (e) {
            e.preventDefault();
            var $item = $(this).closest('.fqa-item');
            var open = !$item.hasClass('active');

            $items.removeClass('active').find('.question').attr('aria-expanded', 'false');
            if (open) {
                $item.addClass('active');
                $(this).attr('aria-expanded', 'true');
            }
        });
    }

    /*============= Tabs de la guía de tallas =============*/
    function initSizeGuideTabs() {
        if (!exists('.tab-contoller')) return;

        $('.tab-contoller').on('click', 'a', function (e) {
            e.preventDefault();
            var $tab = $(this);
            var target = $tab.data('tab') || $tab.attr('href');

            $('.tab-contoller li').removeClass('active');
            $('.tab-contoller a').attr('aria-selected', 'false');
            $tab.attr('aria-selected', 'true').parent().addClass('active');

            $('.body-tab .the-body').removeClass('active');
            $('.body-tab .' + target).addClass('active');
        });
    }

    /*============= Formulario de suscripción (HubSpot) =============*/
    function initSubscriptionForm() {
        if (!exists('.footer-content form')) return;

        $('.footer-content form').on('submit', function () {
            var email = $('.wpcf7-email', this).val();
            if (email) {
                submitSubscription(email);
            }
        });
    }

    function submitSubscription(value) {
        fetch('https://api.hsforms.com/submissions/v3/integration/submit/49847598/b6485c2d-bcc0-485d-ae1e-c3feec6faac6', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                fields: [
                    { name: 'email', value: value },
                    {
                        name: 'acepto_tratamiento_de_datos_personales_conforme_a_la_siguiente_solicitud_de_autorizacion_',
                        value: 'true'
                    }
                ],
                context: {
                    pageUri: window.location.href,
                    pageName: document.title
                }
            })
        }).catch(function () {
            // El envío a HubSpot es secundario: si falla, CF7 sigue funcionando.
        });
    }

    /*============= Cloudflare Turnstile diferido (Contact Form 7) =============*/
    // functions.php quita el script de la carga inicial y deja su URL en window.webokidsTurnstile.
    // Se descarga cuando un formulario con Turnstile se acerca a la pantalla o al hacer foco en él,
    // con margen para que el token esté listo antes de enviar.
    function initLazyTurnstile() {
        var config = window.webokidsTurnstile;
        if (!config || !config.src || !exists('.cf-turnstile')) return;

        var loaded = false;
        var observer = null;

        function load() {
            if (loaded) return;
            loaded = true;
            if (observer) observer.disconnect();
            var script = document.createElement('script');
            script.src = config.src;
            script.async = true;
            document.head.appendChild(script);
        }

        if ('IntersectionObserver' in window) {
            observer = new IntersectionObserver(function (entries) {
                for (var i = 0; i < entries.length; i++) {
                    if (entries[i].isIntersecting) {
                        load();
                        return;
                    }
                }
            }, { rootMargin: '300px 0px' });
            document.querySelectorAll('.cf-turnstile').forEach(function (widget) {
                observer.observe(widget.closest('form') || widget);
            });
        } else {
            load();
        }

        document.addEventListener('focusin', function (e) {
            if (e.target && e.target.closest && e.target.closest('.wpcf7-form')) {
                load();
            }
        });

        // Lo que hacía el inline de CF7: un token nuevo después de cada envío.
        document.addEventListener('wpcf7submit', function () {
            if (window.turnstile) {
                window.turnstile.reset();
            }
        });
    }

    $(function () {
        initKeyboardButtons();
        initLazyTurnstile();
        initMobileMenu();
        initStickyHeader();
        initPoliciesCheckbox();
        initProductsSlideNav();
        initWooGalleryHover();
        initVariations();
        initFaqs();
        initSizeGuideTabs();
        initSubscriptionForm();
    });
})(jQuery, window, document);
