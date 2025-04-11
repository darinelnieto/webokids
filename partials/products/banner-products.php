   
<?php
/**
 * 
 * Partial Name: banner-products
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$posttype = get_queried_object();
$cat = get_terms(['taxonomy' => 'product_cat']);
$key = -1;
?>
<section class="banner-products-partial-d0c71c">
    <?php if(!wp_is_mobile()): ?>
    <div class="webo-svg">
        <svg id="Grupo_8" data-name="Grupo 8" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="225.846" height="299.051" viewBox="0 0 225.846 299.051">
            <defs>
                <clipPath id="clip-path">
                <rect id="Rectángulo_17" data-name="Rectángulo 17" width="225.846" height="299.051" fill="none"/>
                </clipPath>
            </defs>
            <g id="Grupo_7" data-name="Grupo 7" clip-path="url(#clip-path)">
                <path id="Trazado_8" data-name="Trazado 8" d="M216.953,142.41A111.439,111.439,0,0,0,183.314,98.3V30.228q0-15.114-9.186-22.672A33.03,33.03,0,0,0,152.489,0,31.152,31.152,0,0,0,131.15,7.853q-8.893,7.855-8.892,22.375V73.919c-3.173-.258-6.377-.418-9.632-.418-3.055,0-6.06.149-9.039.375V30.228q0-15.114-9.187-22.672A33.029,33.029,0,0,0,72.763,0,31.155,31.155,0,0,0,51.422,7.853q-8.894,7.855-8.891,22.375V98.115a112.957,112.957,0,0,0-9.485,8.434A114.127,114.127,0,0,0,8.891,142.41a113.753,113.753,0,0,0,0,88.175A114.512,114.512,0,0,0,33.046,266.3,112.37,112.37,0,0,0,68.761,290.3a110.339,110.339,0,0,0,43.865,8.746,111.434,111.434,0,0,0,44.012-8.746,112.9,112.9,0,0,0,60.315-59.72,113.729,113.729,0,0,0,0-88.175M127.914,97.473a6.882,6.882,0,1,1-6.881,6.881,6.879,6.879,0,0,1,6.881-6.881m-31.247,0a6.882,6.882,0,1,1-6.881,6.881,6.88,6.88,0,0,1,6.881-6.881m63.826,109.55a49.828,49.828,0,0,1-10.968,16.152,52.72,52.72,0,0,1-16.3,10.818,52.028,52.028,0,0,1-40.011,0,50.111,50.111,0,0,1-26.972-26.97,52.021,52.021,0,0,1,0-40.013,52.747,52.747,0,0,1,10.82-16.3,51.438,51.438,0,0,1,56.163-10.969,51.2,51.2,0,0,1,27.269,27.267,52.02,52.02,0,0,1,0,40.013" fill="#fb2929"/>
            </g>
        </svg>
    </div>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-12 banner-content">
                <div class="title <?php if(wp_is_mobile()): ?>title-and-filter<?php endif; ?>">
                    <h1><?= get_field('category_name'); ?></h1>
                    <?php if(wp_is_mobile()): ?>
                        <button class="open-filter">
                            <span class="text">
                                <?php if(get_bloginfo("language") == "en-US"): ?>Filter<?php else: ?>Filtrar<?php endif; ?>
                            </span>
                            <span class="svg">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30.13" height="24.124" viewBox="0 0 30.13 24.124">
                                    <defs>
                                        <clipPath id="clip-path">
                                        <rect id="Rectángulo_19" data-name="Rectángulo 19" width="30.13" height="24.124" transform="translate(0 0)" fill="none"/>
                                        </clipPath>
                                    </defs>
                                    <g id="Grupo_12" data-name="Grupo 12" transform="translate(0 0)">
                                        <g id="Grupo_11" data-name="Grupo 11" clip-path="url(#clip-path)">
                                        <path id="Trazado_10" data-name="Trazado 10" d="M0,11.826a1.141,1.141,0,0,1,1.213-.714c1.588.024,3.176.006,4.764.01.172,0,.273-.017.337-.22a3.911,3.911,0,0,1,7.48.009c.021.063.045.126.075.209H28.984a2.173,2.173,0,0,1,.352.013A.94.94,0,0,1,29.251,13c-.107.008-.215,0-.323,0H13.861a4.071,4.071,0,0,1-.959,1.742,3.912,3.912,0,0,1-6.568-1.468A.333.333,0,0,0,5.95,13c-1.579.011-3.158-.01-4.736.014A1.146,1.146,0,0,1,0,12.3Zm12.082.242A2.036,2.036,0,1,0,10.043,14.1a2.036,2.036,0,0,0,2.039-2.032"/>
                                        <path id="Trazado_11" data-name="Trazado 11" d="M0,19.947a1.2,1.2,0,0,1,1.259-.695c4.873.014,9.746,0,14.619.015a.438.438,0,0,0,.51-.357,3.907,3.907,0,0,1,7.4.062.354.354,0,0,0,.409.294c1.6-.011,3.2-.008,4.8,0a1.717,1.717,0,0,1,.521.065.935.935,0,0,1,.608,1,.916.916,0,0,1-.875.806c-.862.017-1.725.009-2.588.01-.834,0-1.667.005-2.5,0a.3.3,0,0,0-.351.248,3.905,3.905,0,0,1-7.454,0c-.074-.233-.2-.243-.386-.243q-7.4,0-14.8.009A1.1,1.1,0,0,1,0,20.417Zm18.044.266a2.036,2.036,0,1,0,2.024-2.039,2.033,2.033,0,0,0-2.024,2.039"/>
                                        <path id="Trazado_12" data-name="Trazado 12" d="M0,3.707a1.093,1.093,0,0,1,1.168-.733c4.9.012,9.8.005,14.707.014a.437.437,0,0,0,.51-.358,3.9,3.9,0,0,1,7.4.05.37.37,0,0,0,.43.306c1.607-.01,3.215-.013,4.823,0a1.4,1.4,0,0,1,.713.2.823.823,0,0,1,.346.955.89.89,0,0,1-.751.7,2.186,2.186,0,0,1-.38.024c-1.6,0-3.2,0-4.794,0a.319.319,0,0,0-.372.262A3.907,3.907,0,0,1,16.353,5.1c-.074-.232-.2-.242-.385-.242-4.9,0-9.805,0-14.707.01A1.219,1.219,0,0,1,0,4.178ZM20.088,5.95a2.034,2.034,0,1,0-2.044-2.019A2.04,2.04,0,0,0,20.088,5.95"/>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                        </button>
                    <?php endif; ?>
                </div>
                <!-- Filter movil -->
                <?php if(wp_is_mobile()): ?>
                    <div class="filter-movil d-none">
                        <?php get_template_part('partials/products/product-filter-movil'); ?>
                    </div>
                <?php endif; ?>
                <!-- Category desktop -->
                <?php if(!wp_is_mobile()): if($cat): ?>
                    <div class="categories">
                        <div class="row">
                            <?php foreach($cat as $item):
                                $key++; 
                                if($key <= 2): 
                                $thumbnail_id = get_term_meta($item->term_id, 'thumbnail_id', true); 
                                $image_url = wp_get_attachment_image_url($thumbnail_id, 'full');
                            ?>
                                <div class="col-2">
                                    <div class="the-category">
                                        <a href="<?= home_url(); ?>/product-category/<?= $item->slug; ?>" style="background:<?= get_field('category_color', 'category_' . $item->term_id); ?>">
                                            <div class="img-contain">
                                                <img src="<?=  $image_url; ?>" alt="<?= $item->name; ?>">
                                            </div>
                                            <p class="category-name"><?= $item->name; ?></p>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                <?php endif; endif; ?>
            </div>
        </div>
    </div>
</section>
                    