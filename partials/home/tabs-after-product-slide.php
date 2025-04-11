   
<?php
/**
 * 
 * Partial Name: tabs-after-product-slide
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$widgets = get_field('companiy_widgets');
if($widgets):
?>
<section class="tabs-after-product-slide-partial-a712ee">
    <div class="container">
        <div class="row">
            <?php foreach($widgets as $item): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="the-widget">
                        <div class="title-and-figure">
                            <img src="<?= $item['figure']['url']; ?>" alt="<?= $item['figure']['title']; ?>" class="figure">
                        </div>
                        <div class="description">
                            <p><?= $item['description']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>