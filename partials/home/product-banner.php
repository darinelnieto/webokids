   
<?php
/**
 * 
 * Partial Name: product-banner
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$products_banner = get_field('product_items');
if($products_banner):
?>
<section class="product-banner-partial-998797">
    <?php 
        foreach($products_banner as $key => $item): 
        $id = $item['product_item']->ID;
        $background = get_field('background_imag', $id);
    ?>
        <div class="banner-item">
            <a href="<?= get_permalink($id); ?>">
                <?= wp_get_attachment_image($background['ID'] ?? '', 'full', false, array(
                    'class' => 'background',
                    'loading' => 'lazy',
                    'decoding' => 'async',
                    'alt' => 'Webo fondo ' . get_the_title($id)
                )) ?>
                <?= wp_get_attachment_image(get_field('image_to_banner', $id)['ID'] ?? '', 'large', false, array(
                    'class' => 'feature-image',
                    'loading' => 'lazy',
                    'decoding' => 'async',
                    'alt' => 'Webo producto ' . get_the_title($id)
                )) ?>
                <div class="text-and-cta">
                    <p class="product-name" style="color:<?= $item['name_color'] ?>"><?= get_the_title($id); ?></p>
                    <span class="cta-text test-<?= $key; ?>" style="background:<?= $item['cta_styles']['background']; ?>; color:<?= $item['cta_styles']['color']; ?>;">
                        <?php if(get_bloginfo("language") == "en-US"): ?>
                            Buy here
                        <?php else: ?>
                            Compra aquí
                        <?php endif; ?>
                    </span>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</section>
<?php endif; ?>