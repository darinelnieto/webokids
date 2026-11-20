   
<?php
/**
 * 
 * Partial Name: secondary-banner
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$banner = get_field('banner_two');
if($banner['gallery']):
?>
<section class="secondary-banner-partial-77f06b">
    <div class="banner-contain">
        <?php if($banner['gallery']): ?>
            <?php webokids_enqueue_carousels(); ?>
            <div class="galleries owl-carousel">
                <?php foreach($banner['gallery'] as $image): ?>
                    <div class="item">
                        <?= wp_get_attachment_image($image['ID'] ?? '', 'full', false, array(
                            'loading' => 'lazy',
                            'decoding' => 'async',
                            'alt' => 'Webo banner ' . ($image['title'] ?? '')
                        )) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="banner-texts">
            <h3><?= $banner['banner_title']; ?></h3>
            <p><?= $banner['banner_description']; ?></p>
            <a href="<?= esc_url(get_the_permalink($banner['link_shop']->ID)); ?>" aria-label="<?= esc_attr(webokids_t('Buy now: ', 'Comprar ahora: ')); ?><?= esc_attr(wp_strip_all_tags($banner['banner_title'] ?? '')); ?>">
                <span class="text">
                    <?php if(get_bloginfo("language") == "en-US"): ?>
                        Buy now
                    <?php else: ?>
                        Comprar ahora
                    <?php endif; ?>
                </span>
                <svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23.068" height="23.068" viewBox="0 0 23.068 23.068">
                    <defs>
                        <clipPath id="clip-path">
                        <rect id="Rectángulo_44" data-name="Rectángulo 44" width="23.068" height="23.068" transform="translate(0 0)" fill="none"/>
                        </clipPath>
                    </defs>
                    <g id="Grupo_59" data-name="Grupo 59" transform="translate(0 0)">
                        <g id="Grupo_58" data-name="Grupo 58" clip-path="url(#clip-path)">
                        <line id="Línea_1" data-name="Línea 1" y1="21.361" x2="21.361" transform="translate(0.707 1)" fill="none" stroke="#000000" stroke-miterlimit="10" stroke-width="2"/>
                        <line id="Línea_2" data-name="Línea 2" x2="16.881" transform="translate(5.187 1)" fill="none" stroke="#000000" stroke-miterlimit="10" stroke-width="2"/>
                        <line id="Línea_3" data-name="Línea 3" y2="16.881" transform="translate(22.068 1)" fill="none" stroke="#000000" stroke-miterlimit="10" stroke-width="2"/>
                        </g>
                    </g>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>    