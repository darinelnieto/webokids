Ditto v1.0
=====

> Wordpress theme for developers with composer, nodejs and webpack pre configured.

## Getting Started

* Run php ditto theme:name to rename theme.
* Add NMP packages and Composer packages to start your project.
* Run npm run prod (for production), npm run dev (for development) or npm run watch (for watch mode) to start compile.
* Run php ditto for more shortcuts.

----

Ditto is released under the [MIT License](https://opensource.org/licenses/MIT).

A [PIPE:CODE](https://pipe-code.github.io/) Theme.

© Ditto 2020
## JavaScript del tema (Webokids)

Los JS propios viven en `js/partials/` (fuente, para editar) y se sirven minificados desde su espejo `js/partials-min/`.

* `php ditto build:partial-js` minifica todos los archivos (o `npm run build:js`).
* `php ditto build:partial-js custom` minifica solo `js/partials/custom.js`.
* `npm run build` compila el SCSS en producción y minifica los JS.
* Con `SCRIPT_DEBUG` en `true` (wp-config.php) WordPress carga los archivos fuente sin minificar.

Cada archivo se registra en `functions.php` (`webokids_register_js`) y se encola solo desde el partial que lo usa. Dentro de cada archivo, cada función valida que sus elementos existan antes de registrar eventos.

| Archivo | Dónde se carga |
| --- | --- |
| `custom.js` | Todas las vistas (header, footer, FAQs, guía de tallas, slides de productos, variaciones) |
| `carousels.js` | Partials con Owl Carousel (`webokids_enqueue_carousels()`) |
| `sticky.js` | Ficha de producto (columna sticky, ver más, zoom) |
| `product-list.js` | Listado de productos; núcleo de los filtros (`Webokids.productFilter`) |
| `product-filter.js` | Filtro de escritorio |
| `product-filter-movil.js` | Filtro móvil |
| `sales-countdown.js` | Template de ventas |
