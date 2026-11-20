/**
 * Webokids - filtro de productos en desktop (aplica al hacer clic).
 *
 * Fuente:      js/partials/product-filter.js
 * Minificado:  js/partials-min/product-filter.min.js
 * Compilar:    php ditto build:partial-js product-filter   (o npm run build:js)
 *
 * Se encola desde partials/products/product-filter.php. Depende de product-list.js.
 */
(function ($, window, document) {
    'use strict';

    var root = document.querySelector('.product-filter-partial-b72424');
    var filter = window.Webokids && window.Webokids.productFilter;
    if (root === null || !filter) return;

    var $root = $(root);

    $(function () {
        // Abrir / cerrar cada grupo.
        $root.on('click', '.filter-name', function () {
            filter.toggleGroup($(this));
        });

        // Seleccionar categoría, color o talla: aplica inmediatamente.
        $root.on('click', '.this-cat, .this-color, .this-size', function (e) {
            e.preventDefault();
            filter.toggleItem($(this));
            filter.getProducts();
        });

        // "Quitar filtro" está en el listado (partials/products/product-list.php).
        $('.reset-filter').on('click', function () {
            filter.resetItems($root);
            filter.getProducts();
        });
    });
})(jQuery, window, document);
