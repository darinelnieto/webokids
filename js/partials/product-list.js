/**
 * Webokids - listado de productos (tienda / categorías) y núcleo de los filtros.
 *
 * Fuente:      js/partials/product-list.js
 * Minificado:  js/partials-min/product-list.min.js
 * Compilar:    php ditto build:partial-js product-list   (o npm run build:js)
 *
 * Se encola desde partials/products/product-list.php y expone Webokids.productFilter,
 * que usan product-filter.js (desktop) y product-filter-movil.js (móvil).
 * Configuración (endpoint y textos) llega en window.webokidsProducts desde functions.php.
 */
(function ($, window, document) {
    'use strict';

    if (document.querySelector('.product-list') === null) return;

    var Webokids = window.Webokids = window.Webokids || {};
    var config = window.webokidsProducts || {};
    var $list = $('.product-list');

    /**
     * Valores activos de un tipo de filtro (.this-cat, .this-color, .this-size).
     */
    function collect(selector) {
        return $(selector + '.active').map(function () {
            return $(this).data('value') || $(this).attr('href');
        }).get();
    }

    function renderMessage() {
        var $row = $('<div class="row"><div class="col-12 text-center"><p class="error-message"></p></div></div>');
        $row.find('.error-message').text(config.noResults || '');
        $list.html('').append($row);
    }

    /**
     * Consulta el endpoint con los filtros activos y pinta el resultado.
     */
    function getProducts() {
        var categories = collect('.this-cat');
        var colors = collect('.this-color');
        var sizes = collect('.this-size');

        $list.attr('aria-busy', 'true');

        $.ajax({
            type: 'GET',
            url: config.endpoint,
            data: {
                category: categories.length ? categories : '',
                color: colors.length ? colors : '',
                size: sizes.length ? sizes : ''
            }
        }).done(function (resp) {
            $list.html('').removeClass('show');
            if (resp && resp.length) {
                $list.addClass('row').append(resp.join(''));
                $list.find('.woocommerce').addClass('col-6 col-md-4 mb-4');
            } else {
                renderMessage();
            }
        }).fail(function () {
            renderMessage();
        }).always(function () {
            $list.addClass('show').attr('aria-busy', 'false');
        });
    }

    /**
     * Marca/desmarca un ítem de filtro y actualiza su estado accesible.
     */
    function toggleItem($item, active) {
        $item.toggleClass('active', active).attr('aria-pressed', $item.hasClass('active') ? 'true' : 'false');
    }

    function resetItems($scope) {
        $scope.find('.this-cat, .this-color, .this-size').each(function () {
            toggleItem($(this), false);
        });
    }

    /**
     * Abre/cierra un bloque de filtro (Género, Color, Talla).
     */
    function toggleGroup($name) {
        var $group = $name.parent().toggleClass('active');
        $name.attr('aria-expanded', $group.hasClass('active') ? 'true' : 'false');
    }

    Webokids.productFilter = {
        getProducts: getProducts,
        toggleItem: toggleItem,
        resetItems: resetItems,
        toggleGroup: toggleGroup
    };

    /*============= Estado inicial del listado =============*/
    $(function () {
        $('.columns-4').addClass('row');
        $('.columns-4 a').addClass('col-6 col-md-4 mb-4');
        $list.addClass('show');

        // Marca la categoría actual en el menú superior.
        $('.by-categories ul li a').each(function () {
            if (this.href.trim() === window.location.href) {
                $(this).addClass('active').attr('aria-current', 'page');
            }
        });
    });
})(jQuery, window, document);
