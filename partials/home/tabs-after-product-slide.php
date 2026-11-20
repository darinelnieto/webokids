   
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
    $title = get_field('widgets_title');
?>
<section class="tabs-after-product-slide-partial-a712ee">
    <div class="container">
        <div class="row">
            <?php if($title): ?>
                <div class="col-12 text-center">
                    <h2><?= $title; ?></h2>
                </div>
            <?php endif; foreach($widgets as $item): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="the-widget">
                        <div class="title-and-figure">
                            <?= wp_get_attachment_image($item['figure']['ID'] ?? '', 'large', false, array(
                                'class' => 'figure',
                                'loading' => 'lazy',
                                'decoding' => 'async',
                                'alt' => 'Webo imagen del valor ' . $item['figure']['title']
                            )) ?>
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