   
<?php
/**
 * 
 * Template Name: policies
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header();
?>
<main id="policies-template-b62176">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <h1><?= the_title(); ?></h1>
                <div class="content-policies">
                    <?= the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>
                    