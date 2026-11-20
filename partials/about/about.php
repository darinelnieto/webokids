   
<?php
/**
 * 
 * Partial Name: about
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$about = get_field('about');
?>
<section class="about-partial-82f4b8">
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-12 col-md-5 col-lg-4">
                <h1><?= the_title(); ?></h1>
            </div>
            <?php if($about['description']): ?>
                <div class="col-12 col-md-7 col-lg-7">
                    <p class="description"><?= $about['description']; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?= wp_get_attachment_image($about['image']['ID'] ?? '', 'large', false, array(
        'class' => 'about-image',
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'decoding' => 'async',
        'alt' => 'Webo image'
    )) ?>
</section>
                    