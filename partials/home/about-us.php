   
<?php
/**
 * 
 * Partial Name: about-us
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$about_us = get_field('about_us');
if($about_us['title'] && $about_us['description']):
?>
<section class="about-us-partial-f404e5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-7 text-center">
                <h1><?= $about_us['title']; ?></h1>
                <p><?= $about_us['description']; ?></p>
                <?php if($about_us['page_link']): ?>
                    <a href="<?= $about_us['page_link']; ?>">
                        <?= $about_us['cta_text']; ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>            