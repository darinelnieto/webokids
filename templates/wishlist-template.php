   
<?php
/**
 * 
 * Template Name: wishlist
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header();
?>
<main id="wishlist-template-613c27">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?= the_title(); ?></h1>
                <div class="the-content">
                    <?= the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>
                    