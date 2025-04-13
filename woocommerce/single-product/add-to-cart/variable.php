<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>
	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
	<div class="variations" cellspacing="0" role="presentation">
		<?php foreach ( $attributes as $attribute_name => $options ) : ?>
            <?php
                wc_dropdown_variation_attribute_options(
                    array(
                        'options'   => $options,
                        'attribute' => $attribute_name,
                        'product'   => $product,
                    )
                );
            ?>
            <div class="variations-title">
                <h4 for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
                    <?php echo wc_attribute_label( $attribute_name ); ?>
                </h4>
                <?php if($attribute_name === 'pa_essize'):  ?>
                <?php $size_guide = get_field('size_guide', 'option'); if($size_guide['page_link']): ?>
                    <div class="size-guide">
                        <a href="<?= $size_guide['page_link']; ?>" class="cta">
                            <img src="<?= $size_guide['icon']['url']; ?>" alt="Sice icon" width="<?= $size_guide['icon']['width']; ?>" height="<?= $size_guide['icon']['height']; ?>" class="icon">
                            <span class="text"><?= $size_guide['text']; ?></span>
                        </a>
                    </div>
                <?php endif;
                endif;
                ?>
            </div>
            <ul id="options-color">
                <?php foreach ($options as $option): ?>
                    <li class="">
                        <input type="hidden" class="variation-checkbox" value="<?php echo esc_attr($option); ?>">
                        <span class="checked"></span>
                        <span class="text">
                            <?php echo esc_html($option); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : ''; ?>
        <?php endforeach; ?>
	</div>
		<?php do_action( 'woocommerce_after_variations_table' ); ?>
		<div class="single_variation_wrap">
			<div class="add-tocart">
                <?php 
                    do_action( 'woocommerce_before_single_variation' ); 
                    do_action( 'woocommerce_single_variation' ); 
                    do_action( 'woocommerce_after_single_variation' ); 
                ?>
            </div>
            <div class="wishlist">
                <?= do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
            </div>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
