   
<?php
/**
 * 
 * Template Name: sales
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header();
$date = get_field('count_down');
$banner = get_field('image');
?>
<main id="sales-template-cc2c74">
    <section class="count-down">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1><?= the_title(); ?></h1>
                    <input type="hidden" class="date-init" value="<?= $date; ?>">
                    <?php
                        $countdown_labels = webokids_is_en()
                            ? array('days' => 'Days', 'hours' => 'Hours', 'minutes' => 'Minutes', 'seconds' => 'Seconds')
                            : array('days' => 'Días', 'hours' => 'Horas', 'minutes' => 'Minutos', 'seconds' => 'Segundos');
                    ?>
                    <div id="countdown" data-labels="<?= esc_attr(wp_json_encode($countdown_labels)); ?>"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="products-list">
        <div class="container">
            <?= the_content(); ?>
        </div>
    </section>
    <section class="closed-off d-none">
        <?php if($banner): ?>
            <div class="galleries owl-carousel">
                <?php foreach($banner as $image): ?>
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
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p><?= get_field('text_banner'); ?></p>
                    <a href="<?= esc_url(get_field('link')); ?>">
                        <span class="text">
                            <?php if(get_bloginfo("language") == "en-US"): ?>
                                See more products
                            <?php else: ?>
                                Ver mas productos
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
        </div>
    </section>
</main>
<?php
// La cuenta regresiva se registra antes que los carruseles para que, si la venta ya
// terminó, el banner de cierre esté visible cuando Owl calcula los anchos.
wp_enqueue_script('webokids-sales-countdown');
if ($banner) {
    webokids_enqueue_carousels();
}
get_footer();
