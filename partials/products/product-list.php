   
<?php
/**
 * 
 * Partial Name: product-list
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<section class="product-list-partial-6a6337">
    <div class="container">
        <div class="row">
            <!-- Filter top -->
            <div class="col-12">
                <div class="filter-top">
                    <div class="by-categories">
                        <?php wp_nav_menu(['menu'=>'Product category']); ?>
                    </div>
                    <?php if(!wp_is_mobile()): ?>
                        <button type="button" class="reset-filter">
                            <?php if(get_bloginfo("language") == "en-US"): ?>Remove filter<?php else: ?>Quitar filtro<?php endif; ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Filter left -->
            <?php if(!wp_is_mobile()): ?>
                <div class="col-3 col-lg-2 d-none d-md-block">
                    <?php get_template_part('partials/products/product-filter'); ?>
                </div>
            <?php endif; ?>
            <div class="col-12 col-md-9 col-lg-10">
                <div class="product-list" id="poduct-list" aria-live="polite">
                    <?= the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php wp_enqueue_script('webokids-product-list'); ?>
