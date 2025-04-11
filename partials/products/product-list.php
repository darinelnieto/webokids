   
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
                        <button class="reset-filter">
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
                <div class="product-list" id="poduct-list">
                    <?= the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    <?php if(get_bloginfo("language") == "en-US"): ?>
        const rout = _dittoURL_ + "/wp-json/product/list";
    <?php else: ?>
        const rout = _dittoURL_ + "/es/wp-json/product/list";
    <?php endif; ?>
    var products = [];
    var error = '<?php if(get_bloginfo("language") == "en-US"): ?>No related products found<?php else: ?>No se encontraron productos relacionados<?php endif; ?>';
    $(()=>{
        $('.columns-4').addClass('row');
        $('.columns-4 a').addClass('col-6 col-md-4 mb-4');
        setTimeout(() => {
            $('.product-list').addClass('show');
        }, 1000);
    });
</script> 