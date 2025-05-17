   
<?php
/**
 * 
 * Partial Name: product-filter-movil
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$cat = get_terms(['taxonomy' => 'product_cat']);
$color = get_terms(['taxonomy' => 'pa_color']);
$size = get_terms(['taxonomy' => 'pa_essize']);
?>
<div class="product-filter-movil-partial-8fbed6">
    <div class="filter-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <h4 class="text-filter"> <?php if(get_bloginfo("language") == "en-US"): ?>Filter<?php else: ?>Filtrar<?php endif; ?></h4>
                </div>
                <div class="col-6">
                    <div class="controller-filter">
                        <button class="filter-reset">
                            <?php if(get_bloginfo("language") == "en-US"): ?>Remove filter<?php else: ?>Quitar filtro<?php endif; ?>
                        </button>
                        <button class="close-filter">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Filter -->
    <div class="filter-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Applied filters -->
                    <div class="applied-filter">
                        <h5 class="title"> <?php if(get_bloginfo("language") == "en-US"): ?>Applied filter<?php else: ?>Filtros aplicados<?php endif; ?></h5>
                        <ul id="applied-list"></ul>
                    </div>
                    <!-- Filter actions -->
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
                                            <a href="<?= $item->slug; ?>" class="this-cat this-item">
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
                                            <a href="<?= $item->slug; ?>" class="this-color this-item">
                                                <span class="color" style="<?php if(get_term_meta($item->term_id, 'enable_image_color', true)): ?>background-image:url(<?= $image_url; ?>);<?php else: ?>background:<?php echo get_term_meta($item->term_id, 'color_picker', true); endif; ?>"></span>
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
                                            <a href="<?= $item->slug; ?>" class="this-size this-item">
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
            </div>
        </div>
    </div>
    <div class="filter-footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <button class="filter-run">
                        <span class="text">
                            <?php if(get_bloginfo("language") == "en-US"): ?>Apply filter<?php else: ?>Aplicar filtro<?php endif; ?>
                        </span>
                        <span class="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23.068" height="23.068" viewBox="0 0 23.068 23.068">
                                <defs>
                                    <clipPath id="clip-path">
                                    <rect id="Rectángulo_42" data-name="Rectángulo 42" width="23.068" height="23.068" transform="translate(0 0)" fill="none"/>
                                    </clipPath>
                                </defs>
                                <g id="Grupo_43" data-name="Grupo 43" transform="translate(0 0)">
                                    <g id="Grupo_42" data-name="Grupo 42" clip-path="url(#clip-path)">
                                    <line id="Línea_1" data-name="Línea 1" y1="21.361" x2="21.361" transform="translate(0.707 1)" fill="none" stroke="#d0b4a7" stroke-miterlimit="10" stroke-width="2"/>
                                    <line id="Línea_2" data-name="Línea 2" x2="16.881" transform="translate(5.187 1)" fill="none" stroke="#d0b4a7" stroke-miterlimit="10" stroke-width="2"/>
                                    <line id="Línea_3" data-name="Línea 3" y2="16.881" transform="translate(22.068 1)" fill="none" stroke="#d0b4a7" stroke-miterlimit="10" stroke-width="2"/>
                                    </g>
                                </g>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= get_template_directory_uri(); ?>/js/product-filter-movil.js"></script>     