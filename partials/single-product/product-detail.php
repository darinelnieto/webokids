   
<?php
/**
 * 
 * Partial Name: product-detail
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
global $product;
?>
<section class="product-detail-partial-301ebd">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="gallery">

                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="migas-contain">
                    <?php do_action( 'woocommerce_before_main_content' ); ?>
                </div>
                <div class="title-and-price">
                    <h1><?= the_title(); ?></h1>
                    <h3 class="price"><?php wc_get_template('single-product/price.php'); ?></h3>
                </div>
            </div>
        </div>
    </div>
</section>
                    