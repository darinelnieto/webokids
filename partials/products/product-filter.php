   
<?php
/**
 * 
 * Partial Name: product-filter
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$cat = get_terms(['taxonomy' => 'product_cat']);
$color = get_terms(['taxonomy' => 'pa_color']);
$size = get_terms(['taxonomy' => 'pa_essize']);
?>
<div class="product-filter-partial-b72424">
    <div class="filter">
        <?php if($cat): ?>
            <div class="by-category active">
                <div class="filter-name">
                   <h4>
                        <?php if(get_bloginfo("language") == "en-US"): ?>
                            Gender
                        <?php else: ?>
                            Género
                        <?php endif; ?>
                    </h4>
                    <span class="chevron">
                        <svg id="Grupo_10" data-name="Grupo 10" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25.288" height="14.058" viewBox="0 0 25.288 14.058">
                            <defs>
                                <clipPath id="clip-path">
                                <rect id="Rectángulo_18" data-name="Rectángulo 18" width="25.288" height="14.058" transform="translate(0 0)" fill="none"/>
                                </clipPath>
                            </defs>
                            <g id="Grupo_9" data-name="Grupo 9" clip-path="url(#clip-path)">
                                <path id="Trazado_9" data-name="Trazado 9" d="M24.581.707,12.644,12.644.708.707" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2"/>
                            </g>
                        </svg>
                    </span>
                </div>
                <div class="the-filter">
                    <ul>
                        <?php foreach($cat as $item): ?>
                        <li>
                            <a href="<?= $item->slug; ?>" class="this-cat">
                                <span class="checkbox"></span>
                                <span class="name"><?= $item->name; ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php 
            endif; 
            /*================ Filter by color ================*/
            if($color):
        ?>
            <div class="by-color active">
                <div class="filter-name">
                   <h4>Color</h4>
                    <span class="chevron">
                        <svg id="Grupo_10" data-name="Grupo 10" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25.288" height="14.058" viewBox="0 0 25.288 14.058">
                            <defs>
                                <clipPath id="clip-path">
                                <rect id="Rectángulo_18" data-name="Rectángulo 18" width="25.288" height="14.058" transform="translate(0 0)" fill="none"/>
                                </clipPath>
                            </defs>
                            <g id="Grupo_9" data-name="Grupo 9" clip-path="url(#clip-path)">
                                <path id="Trazado_9" data-name="Trazado 9" d="M24.581.707,12.644,12.644.708.707" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2"/>
                            </g>
                        </svg>
                    </span>
                </div>
                <div class="the-filter">
                    <ul>
                        <?php foreach($color as $item): $image = get_term_meta($item->term_id, 'image', true); $image_id = wpm_translate_string($image); $image_url = wp_get_attachment_url($image_id); ?>
                        <li>
                            <a href="<?= $item->slug; ?>" class="this-color">
                                <span class="color" style="background-image:url(<?= $image_url; ?>)"></span>
                                <span class="name"><?= $item->name; ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php 
            endif; 
            /*================ Filter by Size ================*/
            if($size):
        ?>
            <div class="by-size active">
                <div class="filter-name">
                   <h4>
                        <?php if(get_bloginfo("language") == "en-US"): ?>Size<?php else: ?>Talla<?php endif; ?>
                    </h4>
                    <span class="chevron">
                        <svg id="Grupo_10" data-name="Grupo 10" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25.288" height="14.058" viewBox="0 0 25.288 14.058">
                            <defs>
                                <clipPath id="clip-path">
                                <rect id="Rectángulo_18" data-name="Rectángulo 18" width="25.288" height="14.058" transform="translate(0 0)" fill="none"/>
                                </clipPath>
                            </defs>
                            <g id="Grupo_9" data-name="Grupo 9" clip-path="url(#clip-path)">
                                <path id="Trazado_9" data-name="Trazado 9" d="M24.581.707,12.644,12.644.708.707" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2"/>
                            </g>
                        </svg>
                    </span>
                </div>
                <div class="the-filter">
                    <ul>
                        <?php foreach($size as $item): ?>
                        <li>
                            <a href="<?= $item->slug; ?>" class="this-size">
                                <span class="checkbox"></span>
                                <span class="name"><?= $item->name; ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="<?= get_template_directory_uri(); ?>/js/product.js"></script>       