<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Theme Scripts
 * https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
 */
function ditto_scripts() {
  wp_enqueue_style( 'core', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'main-styles', get_template_directory_uri() . '/css/main.bundle.css' );
  wp_enqueue_style('bootstrap.css', get_template_directory_uri() . '/css/bootstrap.min.css');
  wp_enqueue_style('owl-carousel.css', get_template_directory_uri() . '/css/owl.carousel.min.css');

  wp_enqueue_script( 'main-scripts', get_template_directory_uri() . '/js/main.bundle.js', array( 'jquery' ), '', true );
  wp_enqueue_script('jquery.js', get_template_directory_uri() . '/js/jquery-3.5.1.min.js', true);
  wp_enqueue_script('bootstrap.js',  get_template_directory_uri() . '/js/bootstrap.min.js');
  wp_enqueue_script('owl-carousel.js', get_template_directory_uri() . '/js/owl.carousel.min.js');
  wp_enqueue_script('font-awesome.js', get_template_directory_uri() . '/js/font-awesome.js');
  wp_register_script('custom.js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1', true);
  wp_enqueue_script('zoom-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.21/jquery.zoom.min.js', array('jquery'), null, true);
  wp_enqueue_script('custom.js');
}
add_action( 'wp_enqueue_scripts', 'ditto_scripts');

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
