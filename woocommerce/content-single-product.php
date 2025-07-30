<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
global $product;
$attachment_ids = $product->get_gallery_image_ids();
$featured_image = get_the_post_thumbnail_url();
$key = 0;
$shipping_details = get_field('shipping_details', 'option');
?>
<div class="single-product-template-134541 body-post" id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<div class="product-details">
		<div class="row" id="row-product-details">
			<div class="col-12 col-md-6 col-lg-7">
				<div class="gallery-contain <?php if(wp_is_mobile()): ?>gallery-slide owl-carousel<?php endif; ?>">
					<a href="<?= $featured_image; ?>" class="zoom-trigger">
						<img src="<?= $featured_image; ?>" alt="" class="zoom-image">
					</a>
					<?php foreach ($attachment_ids as $attachment_id): $key++; $image_url = wp_get_attachment_image_src($attachment_id, 'full'); ?>
						<a href="<?= $image_url[0]; ?>" class="zoom-trigger <?php if($key > 3 && !wp_is_mobile()): ?>this-hidden d-none<?php endif; ?>">
							<img src="<?= $image_url[0]; ?>" alt="" class="zoom-image">
						</a>
					<?php endforeach; ?>
				</div>
				<?php if(!wp_is_mobile()): if($key > 3): ?>
					<button class="show-more-img">
						<div class="text more">
							<?php if(get_bloginfo("language") == "en-US"): ?>See more<?php else: ?>Ver más<?php endif; ?>
						</div>
						<div class="text less d-none">
							<?php if(get_bloginfo("language") == "en-US"): ?>see less<?php else: ?>Descripción<?php endif; ?>
						</div>
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23.068" height="23.068" viewBox="0 0 23.068 23.068">
							<defs>
								<clipPath id="clip-path">
								<rect id="Rectángulo_23" data-name="Rectángulo 23" width="23.068" height="23.068" transform="translate(0 0)" fill="none"/>
								</clipPath>
							</defs>
							<g id="Grupo_21" data-name="Grupo 21" transform="translate(0 0)">
								<g id="Grupo_20" data-name="Grupo 20" clip-path="url(#clip-path)">
								<line id="Línea_5" data-name="Línea 5" x2="21.361" y2="21.361" transform="translate(0.707 0.707)" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2"/>
								<path id="Trazado_24" data-name="Trazado 24" d="M22.068,5.187V22.068H5.187" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2"/>
								</g>
							</g>
						</svg>
					</button>
					<?php endif; ?>
					<div class="description-content mt-5 mb-5">
						<h2 class="title"><?php if(get_bloginfo("language") == "en-US"): ?>Description<?php else: ?>Descripción<?php endif; ?></h2>
						<div class="description">
							<?= $product->get_description(); ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="end-sticky"></div>
			</div>
			<div class="col-12 col-md-6 col-lg-5" style="position:relative;">
				<div class="content-product-sticky">
					<div class="migas">
						<?php do_action( 'woocommerce_before_main_content' ); ?>
					</div>
					<div class="description">
						<?php do_action( 'woocommerce_single_product_summary' ); ?>
					</div>
					<?php if($shipping_details): ?>
						<ul class="shipping-details">
							<?php foreach($shipping_details as $item): ?>
								<li>
									<?php if($item['icon']): ?>
										<img src="<?= $item['icon']['url']; ?>" alt="<?= $item['icon']['title']; ?>" width="<?= $item['icon']['width']; ?>" height="<?= $item['icon']['height']; ?>">
									<?php endif; if($item['text']): ?>
										<span class="text-shipping"><?= $item['text']; ?></span>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				<?php if(wp_is_mobile()): ?>
					<div class="description-content mt-5 mb-5">
						<h2 class="title"><?php if(get_bloginfo("language") == "en-US"): ?>Description<?php else: ?>Descripción<?php endif; ?></h2>
						<div class="description">
							<?= $product->get_description(); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="related-product">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="top-content">
						<div class="texts">
							<h2>
								<?php if(get_bloginfo("language") == "en-US"): ?>
									YOU MAY ALSO LIKE...
								<?php else: ?>
									QUIZÁ TAMBIÉN TE GUSTE...
								<?php endif; ?>
							</h2>
						</div>
						<div class="ctas">
							<div class="see-all-contaian">
								<a href="<?= $content['see_all_products']; ?>">
									<span class="text">
										<?php if(get_bloginfo("language") == "en-US"): ?>See all<?php else: ?>Ver todo<?php endif; ?>
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
								</a>
							</div>
							<div class="nav-slide-products">
								<ul>
									<li>
										<a href="#" class="prev">
											<span></span>
										</a>
									</li>
									<li>
										<a href="#" class="next">
											<span></span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?= do_shortcode('[related_products limit="4" columns ="3" orderby="price"]'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?= get_template_directory_uri() ?>/js/sticky.js"></script>