<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" action="<?php echo esc_url( $product_url ); ?>" method="get">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<button type="submit" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
		<span class="text">
			<?php echo esc_html( $button_text ); ?>
		</span>
		<span class="svg">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23.068" height="23.068" viewBox="0 0 23.068 23.068">
				<defs>
					<clipPath id="clip-path">
					<rect id="Rectángulo_42" data-name="Rectángulo 42" width="23.068" height="23.068" transform="translate(0 0)" fill="none"/>
					</clipPath>
				</defs>
				<g id="Grupo_43" data-name="Grupo 43" transform="translate(0 0)">
					<g id="Grupo_42" data-name="Grupo 42" clip-path="url(#clip-path)">
					<line id="Línea_1" data-name="Línea 1" y1="21.361" x2="21.361" transform="translate(0.707 1)" fill="none" stroke="#d0b4a7" stroke-miterlimit="10" stroke-width="2"/>
					<line id="Línea_2" data-name="Línea 2" x2="16.881" transform="translate(5.187 1)" fill="none" stroke="#d0b4a7" stroke-miterlimit="10" stroke-width="2"/>
					<line id="Línea_3" data-name="Línea 3" y2="16.881" transform="translate(22.068 1)" fill="none" stroke="#d0b4a7" stroke-miterlimit="10" stroke-width="2"/>
					</g>
				</g>
			</svg>
		</span>
	</button>

	<?php wc_query_string_form_fields( $product_url ); ?>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
