<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once get_template_directory() . '/inc/icons.php';
require_once get_template_directory() . '/inc/webp.php';

/**
 * Versión de un asset según su fecha de modificación (cache busting).
 */
function webokids_asset_version( $relative_path ) {
  $file_path = get_template_directory() . $relative_path;
  return file_exists( $file_path ) ? (string) filemtime( $file_path ) : null;
}

/**
 * Ruta de un JS del tema.
 * El fuente vive en js/partials/{name}.js y su espejo minificado en js/partials-min/{name}.min.js
 * (se genera con: php ditto build:partial-js {name}  |  npm run build:js).
 * Con SCRIPT_DEBUG activo se sirve el fuente sin minificar.
 */
function webokids_js_path( $name ) {
  $min = '/js/partials-min/' . $name . '.min.js';
  $src = '/js/partials/' . $name . '.js';
  $use_src = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ! file_exists( get_template_directory() . $min );
  return $use_src ? $src : $min;
}

/**
 * Registra un JS del tema en el footer con carga diferida.
 */
function webokids_register_js( $handle, $name, $deps = array( 'jquery' ) ) {
  $path = webokids_js_path( $name );
  wp_register_script( $handle, get_template_directory_uri() . $path, $deps, webokids_asset_version( $path ), array(
    'in_footer' => true,
    'strategy'  => 'defer',
  ) );
}

/**
 * true si el sitio se está mostrando en inglés.
 */
function webokids_is_en() {
  return get_bloginfo( 'language' ) === 'en-US';
}

/**
 * Texto según el idioma actual (inglés / español).
 */
function webokids_t( $en, $es ) {
  return webokids_is_en() ? $en : $es;
}

/**
 * Atributos target/rel seguros para enlaces (ACF link o string de target).
 */
function webokids_target_attrs( $target ) {
  if ( is_array( $target ) ) {
    $target = $target['target'] ?? '';
  }
  return $target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '';
}

/**
 * Register Theme Styles & Scripts
 * https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
 */
function ditto_scripts() {
  $uri = get_template_directory_uri();

  // Estilos (mismo orden de cascada que antes; style.css solo tiene la cabecera del tema y no se carga).
  wp_enqueue_style( 'main-styles', $uri . '/css/main.bundle.css', array(), webokids_asset_version( '/css/main.bundle.css' ) );
  wp_enqueue_style( 'bootstrap.css', $uri . '/css/bootstrap.min.css', array( 'main-styles' ), webokids_asset_version( '/css/bootstrap.min.css' ) );
  wp_enqueue_style( 'owl-carousel.css', $uri . '/css/owl.carousel.min.css', array( 'bootstrap.css' ), webokids_asset_version( '/css/owl.carousel.min.css' ) );
  // La fuente de texto (Nunito Sans) se instala desde wp-admin › Apariencia › Fuentes; WordPress imprime su @font-face.

  // Se usa el jQuery de WordPress. El jquery-3.5.1 propio del tema reemplazaba al de WP,
  // borraba blockUI y rompía el checkout.js de WooCommerce (no se recalculaba el envío).
  // Se expone el jQuery de WP como $ para scripts inline de plugins/temas que lo esperan.
  wp_enqueue_script( 'jquery' );
  wp_add_inline_script( 'jquery-core', 'window.$ = window.jQuery;' );

  // Librerías: solo se registran; cada partial encola lo que necesita.
  wp_register_script( 'owl-carousel', $uri . '/js/owl.carousel.min.js', array( 'jquery' ), webokids_asset_version( '/js/owl.carousel.min.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
  // Respaldo por si WooCommerce no registra su jquery.zoom (wc-zoom).
  wp_register_script( 'jquery-zoom', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.21/jquery.zoom.min.js', array( 'jquery' ), null, array( 'in_footer' => true, 'strategy' => 'defer' ) );

  // JS del tema (fuente: js/partials, minificado: js/partials-min).
  webokids_register_js( 'webokids-custom', 'custom' );
  webokids_register_js( 'webokids-carousels', 'carousels', array( 'jquery', 'owl-carousel' ) );
  webokids_register_js( 'webokids-sticky', 'sticky' );
  webokids_register_js( 'webokids-product-list', 'product-list' );
  webokids_register_js( 'webokids-product-filter', 'product-filter', array( 'jquery', 'webokids-product-list' ) );
  webokids_register_js( 'webokids-product-filter-movil', 'product-filter-movil', array( 'jquery', 'webokids-product-list' ) );
  webokids_register_js( 'webokids-sales-countdown', 'sales-countdown' );

  wp_localize_script( 'webokids-product-list', 'webokidsProducts', array(
    'endpoint'  => get_site_url() . ( webokids_is_en() ? '' : '/es' ) . '/wp-json/product/list',
    'noResults' => webokids_t( 'No related products found', 'No se encontraron productos relacionados' ),
  ) );

  wp_add_inline_script( 'webokids-custom', 'window._dittoURI_ = ' . wp_json_encode( $uri ) . '; window._dittoURL_ = ' . wp_json_encode( get_site_url() ) . ';', 'before' );

  // Global: header, footer, formularios, etc.
  wp_enqueue_script( 'webokids-custom' );
}
add_action( 'wp_enqueue_scripts', 'ditto_scripts');

/**
 * Encola el JS de la ficha de producto con el zoom de WooCommerce (o el del CDN como respaldo).
 */
function webokids_enqueue_single_product_js() {
  wp_enqueue_script( wp_script_is( 'wc-zoom', 'registered' ) ? 'wc-zoom' : 'jquery-zoom' );
  wp_enqueue_script( 'webokids-sticky' );
}

/**
 * Cloudflare Turnstile (anti-spam de Contact Form 7): CF7 lo carga en todas las páginas
 * porque el formulario del footer está en todo el sitio. Se quita de la carga inicial y
 * js/partials/custom.js (initLazyTurnstile) lo descarga cuando el formulario se acerca
 * a la pantalla o se hace foco en él. Evita su JS y los errores de CSP que genera su
 * iframe en la consola (penalizan en PageSpeed > Prácticas recomendadas).
 */
function webokids_lazy_turnstile() {
  if ( ! wp_script_is( 'cloudflare-turnstile', 'enqueued' ) ) {
    return;
  }
  $src = wp_scripts()->registered['cloudflare-turnstile']->src ?? '';
  if ( ! $src ) {
    return;
  }
  wp_dequeue_script( 'cloudflare-turnstile' );
  wp_add_inline_script( 'webokids-custom', 'window.webokidsTurnstile = ' . wp_json_encode( array( 'src' => $src ) ) . ';', 'before' );
}
add_action( 'wp_enqueue_scripts', 'webokids_lazy_turnstile', 20 );

/**
 * Encola los carruseles (Owl) desde los partials que los usan.
 */
function webokids_enqueue_carousels() {
  wp_enqueue_script( 'webokids-carousels' );
}

/**
 * Preconnect a orígenes externos que se usan en todas las páginas.
 */
function webokids_resource_hints( $urls, $relation_type ) {
  if ( 'preconnect' === $relation_type ) {
    $urls[] = 'https://www.googletagmanager.com';
  }
  return $urls;
}
add_filter( 'wp_resource_hints', 'webokids_resource_hints', 10, 2 );

/**
 * URL del archivo de una fuente instalada en wp-admin › Apariencia › Fuentes.
 */
function webokids_font_library_src( $family, $weight = '400', $style = 'normal' ) {
  $cache_key = 'webokids_font_src_' . md5( $family . $weight . $style );
  $src       = get_transient( $cache_key );
  if ( false !== $src ) {
    return $src;
  }

  $src   = '';
  $faces = get_posts( array(
    'post_type'      => 'wp_font_face',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'no_found_rows'  => true,
  ) );
  foreach ( $faces as $face ) {
    $data = json_decode( $face->post_content, true );
    if ( is_array( $data )
      && trim( $data['fontFamily'] ?? '', '"\' ' ) === $family
      && (string) ( $data['fontWeight'] ?? '' ) === (string) $weight
      && ( $data['fontStyle'] ?? 'normal' ) === $style
      && is_string( $data['src'] ?? null ) ) {
      $src = $data['src'];
      break;
    }
  }

  set_transient( $cache_key, $src, DAY_IN_SECONDS );
  return $src;
}

/**
 * Limpia la caché de URLs de fuentes cuando se instala o borra una fuente.
 */
function webokids_flush_font_cache( $post_id ) {
  if ( in_array( get_post_type( $post_id ), array( 'wp_font_face', 'wp_font_family' ), true ) ) {
    delete_transient( 'webokids_font_src_' . md5( 'Nunito Sans' . '400' . 'normal' ) );
  }
}
add_action( 'save_post', 'webokids_flush_font_cache' );
add_action( 'before_delete_post', 'webokids_flush_font_cache' );

/**
 * Precarga las fuentes que se ven al cargar: Arista (títulos) y Nunito Sans 400 (texto).
 */
function webokids_preload_fonts() {
  $fonts = array_filter( array(
    get_template_directory_uri() . '/fonts/Arista20.woff2',
    webokids_font_library_src( 'Nunito Sans', '400', 'normal' ),
  ) );
  foreach ( $fonts as $font ) {
    echo '<link rel="preload" href="' . esc_url( $font ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
  }
}
add_action( 'wp_head', 'webokids_preload_fonts', 2 );

/**
 * Home: precarga el fondo del primer slide del banner (es el LCP). Empieza la descarga
 * desde el <head>, antes de que el navegador llegue a la <img> del banner.
 */
function webokids_preload_home_banner() {
  if ( ! is_page_template( 'templates/home-template.php' ) || ! function_exists( 'get_field' ) ) {
    return;
  }
  $products = get_field( 'products' );
  if ( empty( $products ) || ! is_array( $products ) ) {
    return;
  }
  $first = reset( $products );
  if ( empty( $first['background_image'] ) || empty( $first['background_img'] ) ) {
    return;
  }
  $background_id = attachment_url_to_postid( $first['background_img'] );
  $src           = $background_id ? wp_get_attachment_image_url( $background_id, 'full' ) : '';
  if ( $src ) {
    echo '<link rel="preload" as="image" href="' . esc_url( $src ) . '" fetchpriority="high">' . "\n";
  }
}
add_action( 'wp_head', 'webokids_preload_home_banner', 1 );

/*================= Render-blocking CSS =================*/

/**
 * true en páginas sin productos ni WooCommerce (contacto, nosotros, guía de tallas, políticas).
 */
function webokids_is_content_page() {
  return is_page_template( array(
    'templates/contact-us-template.php',
    'templates/about-us-template.php',
    'templates/size-guide-template.php',
    'templates/policies-template.php',
  ) );
}

/**
 * Handles de CSS que se cargan sin bloquear el render en la vista actual.
 * Solo van aquí estilos de cosas que no se ven al cargar la página (footer, popups,
 * formularios) o que la vista no usa.
 */
function webokids_deferred_styles() {
  static $cached = null;
  if ( null !== $cached ) {
    return $cached;
  }

  $handles = array(
    'sbi_styles',                     // Instagram Feed (footer).
    'contact-form-7',                 // Formularios (footer / contacto).
    'jquery-selectBox',               // YITH Wishlist.
    'woocommerce_prettyPhoto_css',    // Lightbox de YITH Wishlist.
    'perfect-scrollbar',              // Popup del carrito.
    'perfect-scrollbar-theme',        // Popup del carrito.
    'wcspc-fonts',                    // Popup del carrito.
    'wcspc-frontend',                 // Popup del carrito.
    'photoswipe',                     // Visor de fotos de WooCommerce (se abre al hacer clic).
    'photoswipe-default-skin',
  );

  // El botón de la lista de deseos solo se ve en la ficha de producto y en la lista de deseos.
  $is_wishlist = function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page();
  if ( ! ( function_exists( 'is_product' ) && is_product() ) && ! $is_wishlist ) {
    $handles[] = 'yith-wcwl-main';
    $handles[] = 'yith-wcwl-add-to-wishlist';
  }

  // wc-blocks-style: WooCommerce lo usa para los avisos (añadido al carrito, errores) y para
  // el contenido con bloques. Solo bloquea donde esos avisos se ven al cargar.
  $is_woo_flow = function_exists( 'is_woocommerce' ) && ( is_product() || is_cart() || is_checkout() || is_account_page() );
  $has_blocks  = is_singular() && has_blocks( get_queried_object_id() );
  if ( ! $is_woo_flow && ! $has_blocks ) {
    $handles[] = 'wc-blocks-style';
  }

  // Páginas sin productos: WooCommerce solo hace falta para el popup del carrito.
  if ( webokids_is_content_page() ) {
    $handles[] = 'woocommerce-general';
    $handles[] = 'woocommerce-layout';
    $handles[] = 'woocommerce-smallscreen';
  }

  $cached = apply_filters( 'webokids_deferred_styles', $handles );
  return $cached;
}

/**
 * Carga los CSS de webokids_deferred_styles() sin bloquear el render:
 * media="print" + onload, con <noscript> de respaldo.
 */
function webokids_defer_style_tag( $tag, $handle, $href, $media ) {
  if ( is_admin() || ! in_array( $handle, webokids_deferred_styles(), true ) ) {
    return $tag;
  }
  $media    = ( $media && 'all' !== $media ) ? $media : 'all';
  $deferred = preg_replace( '/\smedia=([\'"])[^\'"]*\1/', '', $tag );
  $deferred = str_replace( '<link ', '<link media="print" onload="this.media=\'' . esc_attr( $media ) . '\';this.onload=null" ', $deferred );
  return $deferred . '<noscript>' . trim( $tag ) . "</noscript>\n";
}
add_filter( 'style_loader_tag', 'webokids_defer_style_tag', 10, 4 );


/**
 * Meta description (no hay plugin SEO instalado).
 */
function webokids_meta_description() {
  $description = '';

  if ( is_front_page() || is_home() ) {
    $description = get_bloginfo( 'description' );
  } elseif ( is_singular() ) {
    $description = get_the_excerpt( get_queried_object_id() );
    if ( ! $description ) {
      $description = get_post_field( 'post_content', get_queried_object_id() );
    }
  } elseif ( is_category() || is_tag() || is_tax() ) {
    $description = term_description();
  }

  if ( ! $description && is_front_page() && function_exists( 'get_field' ) ) {
    $about = get_field( 'about_us' );
    $description = is_array( $about ) ? ( $about['description'] ?? '' ) : '';
  }

  if ( ! $description ) {
    $description = get_bloginfo( 'description' );
  }

  // Último recurso: título de la vista + nombre del sitio (mejor llenar el extracto de cada página).
  if ( ! $description ) {
    $description = trim( wp_get_document_title() );
  }

  $description = wp_trim_words( wp_strip_all_tags( strip_shortcodes( $description ) ), 30, '…' );

  if ( $description ) {
    echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
  }
}
add_action( 'wp_head', 'webokids_meta_description', 1 );

/**
 * Register Navigation Menus
 * https://developer.wordpress.org/reference/functions/register_nav_menus/
 */
function ditto_navigation_menus() {
  $locations = array(
    'main_menu' => __( 'Main Menu', 'text_domain' )
  );
  register_nav_menus( $locations );
}
add_action( 'init', 'ditto_navigation_menus' );

/**
 * Theme support
 * https://developer.wordpress.org/reference/functions/add_theme_support/
 */
add_theme_support( 'custom-logo' );
add_theme_support( 'title-tag' );
// Permite escribir el extracto de las páginas, que se usa como meta description.
add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'html5', array( 'script', 'style', 'search-form', 'gallery', 'caption' ) );

/**
 * Login Styles
 */
function ditto_login_styles() { ?>
  <style type="text/css">
    body {
      background-color: #222 !important;
    }
    #login h1 a, .login h1 a {
      display: none;
    }
    #login h1 img {
      width: 100%;
      max-width: 240px;
      max-height: 180px;
    }
  </style>
  <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
      let loginImg = document.createElement("img");
        loginImg.src = "<?= get_template_directory_uri() ?>/images/pipe-code-logo.svg";
        loginImg.alt = "WordPress login image";
        document.querySelector('#login h1').appendChild(loginImg);
    });
  </script>
<?php }
add_action( 'login_enqueue_scripts', 'ditto_login_styles' );

/**
 * Disable Gutenberg
 */
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);

if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
	  'page_title'    => 'Options theme',
	  'menu_title'    => 'Options theme',
	  'menu_slug'     => 'theme-settings',
	  'capability'    => 'edit_posts',
	  'redirect'      =>  true
	));
  acf_add_options_sub_page(array(
    'page_title'     => 'Footer',
    'menu_title'     => 'Footer',
    'parent_slug'   => 'theme-settings',
  ));
  acf_add_options_sub_page(array(
    'page_title'     => 'Header',
    'menu_title'     => 'Header',
    'parent_slug'   => 'theme-settings',
  ));
  acf_add_options_sub_page(array(
    'page_title'     => 'Products',
    'menu_title'     => 'Products',
    'parent_slug'   => 'theme-settings',
  ));
}
/*================= Product endpoint ==================*/
add_action( 'rest_api_init', function () {
  register_rest_route( 'product', '/list', array(
      array(
          'methods'               => WP_REST_Server::READABLE,
          'callback'              => 'products_list_handler',
          'permission_callback'   => '__return_true',          
      )
  ));
}); 
/*============= Filter =============*/
function products_list_handler($request){
  $categories = $request['category'];
  // $color = $request->get_param('color'); // Obtener el color de la petición

  $tax_query = [];
  $args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'tax_query' => array(
      'relation' => 'AND',
    ),
    'meta_query' => array(),
    'posts_per_page' => -1,
    'orderby'        => 'title',
  ];
  if($request['category'] !== ''){
    array_push($args['tax_query'], [
      'taxonomy' => 'product_cat',
      'field' => 'slug',
      'terms' =>  $request['category']
    ]);
  }
  if($request['color'] !== ''){
    array_push($args['tax_query'], [
      'taxonomy' => 'pa_color',
      'field' => 'slug',
      'terms' =>  $request['color']
    ]);
  }
  if($request['size'] !== ''){
    array_push($args['tax_query'], [
      'taxonomy' => 'pa_essize',
      'field' => 'slug',
      'terms' =>  $request['size']
    ]);
  }

  $query = new WP_Query($args);
  $products = [];

  while ($query->have_posts()) {
      $query->the_post();
      $products[] = do_shortcode('[product id="' . get_the_ID() . '"]');
  }
  wp_reset_postdata();
  return new WP_REST_Response($products, 200);
}
/*=============== Delete result cont and catalog ordering ===============*/
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
/*=========== Zoom gallery ===========*/
function reactivar_zoom_wc() {
  if (is_product()) {
      ?>
      <script>
          jQuery(document).ready(function($) {
              if (!$('.woocommerce-product-gallery').hasClass('wc-product-gallery')) {
                  $('.woocommerce-product-gallery').addClass('wc-product-gallery');
                  $('.woocommerce-product-gallery').each(function() {
                      $(this).wc_product_gallery();
                  });
              }
          });
      </script>
      <?php
  }
}
add_action('wp_footer', 'reactivar_zoom_wc', 25);
add_filter('woocommerce_product_related_products_heading', '__return_empty_string');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_filter('yith_wcwl_wishlist_title', '__return_empty_string');
/*============== Sales =============*/
add_filter('woocommerce_sale_flash', 'custom_sale_percentage_badge', 20, 3);
function custom_sale_percentage_badge($html, $post, $product) {
    if ($product->is_type('variable')) {
        $percentage = 0;
        foreach ($product->get_children() as $child_id) {
            $variation = wc_get_product($child_id);
            if ($variation->is_on_sale()) {
                $regular = (float) $variation->get_regular_price();
                $sale = (float) $variation->get_sale_price();
                if ($regular > 0 && $sale > 0) {
                    $current_percentage = round((($regular - $sale) / $regular) * 100);
                    if ($current_percentage > $percentage) {
                        $percentage = $current_percentage;
                    }
                }
            }
        }
    } else {
        $regular = (float) $product->get_regular_price();
        $sale = (float) $product->get_sale_price();
        $percentage = $regular > 0 && $sale > 0
            ? round((($regular - $sale) / $regular) * 100)
            : 0;
    }

    if ($percentage > 0) {
        return '<span class="onsale">' . $percentage . '% off</span>';
    }

    return $html;
}