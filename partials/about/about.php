   
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
    <?php if($about['image']): ?>
        <img src="<?= $about['image']['url'] ?>" alt="<?= $about['image']['title'] ?>" width="<?= $about['image']['width']; ?>" height="<?= $about['image']['height'] ?>" class="about-image">
    <?php endif; ?>
</section>
                    