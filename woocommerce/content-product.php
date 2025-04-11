<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
$product_id = get_the_id();
$product_cat = get_the_terms($product_id, 'product_cat');
?>
<a href="<?= the_permalink(); ?>" class="product-card">
	<div class="image-contain">
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		<span class="price">
			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
		</span>
	</div>
	<div class="text-contain">
		<h2><?php the_title(); ?></h2>
		<p><?= $product_cat[0]->name; ?></p>
	</div>
</a>