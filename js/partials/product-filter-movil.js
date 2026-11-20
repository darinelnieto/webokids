/**
 * Webokids - filtro de productos en móvil (panel que se aplica con "Aplicar filtro").
 *
 * Fuente:      js/partials/product-filter-movil.js
 * Minificado:  js/partials-min/product-filter-movil.min.js
 * Compilar:    php ditto build:partial-js product-filter-movil   (o npm run build:js)
 *
 * Se encola desde partials/products/product-filter-movil.php. Depende de product-list.js.
 */
(function ($, window, document) {
    'use strict';

    var root = document.querySelector('.product-filter-movil-partial-8fbed6');
    var filter = window.Webokids && window.Webokids.productFilter;
    if (root === null || !filter) return;

    var $root = $(root);
    var $panel = $('.filter-movil');
    var $open = $('.open-filter');

    function setPanel(open) {
        $panel.toggleClass('d-none', !open);
        $open.attr('aria-expanded', open ? 'true' : 'false');
        if (open) {
            $root.find('.close-filter').trigger('focus');
        } else {
            $open.trigger('focus');
        }
    }

    $(function () {
        $open.on('click', function () {
            setPanel(true);
        });

        $root.on('click', '.close-filter', function () {
            setPanel(false);
        });

        // Cerrar con Escape.
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && !$panel.hasClass('d-none')) {
                setPanel(false);
            }
        });

        // Abrir / cerrar cada grupo.
        $root.on('click', '.filter-name', function () {
            filter.toggleGroup($(this));
        });

        // Seleccionar: solo marca, se aplica con "Aplicar filtro".
        $root.on('click', '.this-cat, .this-color, .this-size', function (e) {
            e.preventDefault();
            filter.toggleItem($(this));
        });

        $root.on('click', '.filter-reset', function () {
            filter.resetItems($root);
            setPanel(false);
            filter.getProducts();
        });

        $root.on('click', '.filter-run', function () {
            setPanel(false);
            filter.getProducts();
        });
    });
})(jQuery, window, document);
