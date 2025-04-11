   
<?php
/**
 * 
 * Template Name: home
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header();
?>
<main id="home-template-a42d4f">
    <?php get_template_part('partials/home/banner'); ?>
    <?php get_template_part('partials/home/about-us'); ?>
    <?php get_template_part('partials/home/product-banner'); ?>
    <?php get_template_part('partials/home/the-newest'); ?>
    <?php get_template_part('partials/home/products-slide'); ?>
    <?php get_template_part('partials/home/tabs-after-product-slide'); ?>
</main>
<?php get_footer(); ?>
                    