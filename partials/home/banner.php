   
<?php
/**
 * 
 * Partial Name: banner
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$background_text = get_field('text_background');
$products = get_field('products');
$nav = get_field('nav_category');
$logo_bottom = get_field('logo_bottom');
?>
<section class="banner-partial-0ed400">
    <div class="banner-contain">
        <div id="product-content"></div>
    </div>
    <?php if($products): ?>
        <div class="banner-slide owl-carousel">
            <?php foreach($products as $slide_index => $product): $is_first_slide = ($slide_index === array_key_first($products)); ?>
                <div class="item">
                    <a href="<?= esc_url($product['link']); ?>" aria-label="<?= esc_attr(webokids_t('View product ', 'Ver producto ') . ($product['product_image']['title'] ?? '')); ?>">
                        <?php
                            // Fondo del slide como <img> (antes background-image inline): el navegador lo
                            // descubre desde el HTML, toma prioridad alta en el primer slide y usa WebP.
                            $background_id = ($product['background_image'] === true && !empty($product['background_img']))
                                ? attachment_url_to_postid($product['background_img'])
                                : 0;
                        ?>
                        <div class="product-image-contain"<?php if (!$background_id): ?> style="background:<?= esc_attr($product['background_image'] === true ? 'transparent' : $product['color']); ?>;"<?php endif; ?>>
                            <?php if ($background_id): ?>
                                <?php
                                    // Sin sizes="auto": con object-fit: cover el navegador elegiría la versión
                                    // del ancho de la caja (768px en móvil) y el fondo se vería borroso.
                                    add_filter('wp_img_tag_add_auto_sizes', '__return_false');
                                ?>
                                <?= wp_get_attachment_image($background_id, 'full', false, array(
                                    'class' => 'background-image',
                                    'loading' => $is_first_slide ? 'eager' : 'lazy',
                                    'fetchpriority' => $is_first_slide ? 'high' : 'auto',
                                    'decoding' => 'async',
                                    // Con object-fit: cover el fondo se amplía hasta el alto del slide (78vh/100vh),
                                    // así que se usa siempre la imagen completa, como cuando era background-image.
                                    'sizes' => '1920px',
                                    'alt' => '',
                                )) ?>
                                <?php remove_filter('wp_img_tag_add_auto_sizes', '__return_false'); ?>
                            <?php endif; ?>
                            <?= wp_get_attachment_image($background_text['ID'] ?? '', 'large', false, array(
                                'class' => 'background-text',
                                'loading' => $is_first_slide ? 'eager' : 'lazy',
                                'fetchpriority' => $is_first_slide ? 'high' : 'auto',
                                'decoding' => 'async',
                                'alt' => 'Webo texto de fondo'
                            )) ?>
                            <?= wp_get_attachment_image($product['product_image']['ID'] ?? '', 'large', false, array(
                                'class' => 'product-image',
                                'loading' => $is_first_slide ? 'eager' : 'lazy',
                                'fetchpriority' => $is_first_slide ? 'high' : 'auto',
                                'decoding' => 'async',
                                'alt' => 'Webo producto ' . ($product['product_image']['title'] ?? '')
                            )) ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if($nav): ?>
            <ul class="nav-category">
                <?php foreach($nav as $li): ?>
                    <li>
                        <a href="<?= esc_url(home_url('/product-category/' . $li['category']->slug . '/')); ?>">
                            <span><?= $li['category']->name; ?></span>
                            <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23.068" height="23.068" viewBox="0 0 23.068 23.068">
                                <defs>
                                    <clipPath id="clip-path">
                                    <rect id="Rectángulo_44" data-name="Rectángulo 44" width="23.068" height="23.068" transform="translate(0 0)" fill="none"/>
                                    </clipPath>
                                </defs>
                                <g id="Grupo_59" data-name="Grupo 59" transform="translate(0 0)">
                                    <g id="Grupo_58" data-name="Grupo 58" clip-path="url(#clip-path)">
                                    <line id="Línea_1" data-name="Línea 1" y1="21.361" x2="21.361" transform="translate(0.707 1)" fill="none" stroke="#d0b4a7" stroke-miterlimit="10" stroke-width="2"/>
                                    <line id="Línea_2" data-name="Línea 2" x2="16.881" transform="translate(5.187 1)" fill="none" stroke="#d0b4a7" stroke-miterlimit="10" stroke-width="2"/>
                                    <line id="Línea_3" data-name="Línea 3" y2="16.881" transform="translate(22.068 1)" fill="none" stroke="#d0b4a7" stroke-miterlimit="10" stroke-width="2"/>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?= wp_get_attachment_image($logo_bottom['ID'] ?? '', 'large', false, array(
            'class' => 'logo-bottom',
            'loading' => 'eager',
            'decoding' => 'async',
            'alt' => 'Webo logo'
        )) ?>
        <?php webokids_enqueue_carousels(); ?>
    <?php endif; ?>
</section>
                    