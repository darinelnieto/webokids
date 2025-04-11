   
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
        foreach($products_banner as $item): 
        $id = $item['product_item']->ID;
        $background = get_field('background_imag', $id);
    ?>
        <div class="banner-item">
            <a href="<?= get_permalink($id); ?>">
                <img src="<?= $background['url']; ?>" alt="<?= $background['url']; ?>" class="background">
                <img src="<?= get_field('image_to_banner', $id)['url']; ?>" alt="<?= get_the_title($id); ?>" class="feature-image">
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