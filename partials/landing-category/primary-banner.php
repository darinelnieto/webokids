   
<?php
/**
 * 
 * Partial Name: primary-banner
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$banner = get_field('banner_one');
if($banner['gallery']):
?>
<section class="primary-banner-partial-b387b2">
    <div class="banner-contain">
        <?php if($banner['gallery']): ?>
            <div class="galleries owl-carousel">
                <?php foreach($banner['gallery'] as $image): ?>
                    <div class="item">
                        <img src="<?= $image['url']; ?>" alt="<?= $image['title']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="banner-texts" style="color:#fff;">
            <h3><?= $banner['banner_title']; ?></h3>
            <p><?= $banner['banner_description']; ?></p>
            <a href="<?= get_the_permalink($banner['link_shop']->ID); ?>">
                <span class="text">
                    <?php if(get_bloginfo("language") == "en-US"): ?>
                        Buy now
                    <?php else: ?>
                        Comprar ahora
                    <?php endif; ?>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23.068" height="23.068" viewBox="0 0 23.068 23.068">
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