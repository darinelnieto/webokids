   
<?php
/**
 * 
 * Partial Name: header
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$social_networks = get_field('social_networks', 'option');
?>
<section class="header-partial-7cbee3">
    <div class="beige-top">
        <div class="container">
            <div class="row">
                <div class="col-12" style="position:relative;">
                    <p class="message"><?= get_field('shipping_message', 'option'); ?></p>
                    <div class="nav-login d-none d-md-block">
                        <?php wp_nav_menu(['menu' => 'My Account']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-contain">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-4 col-md-3">
                    <?php
                        // Logo: mismo marcado que get_custom_logo() (a.custom-logo-link > img.custom-logo),
                        // pero con prioridad alta porque está en la parte visible al cargar.
                        $logo_id   = get_theme_mod('custom_logo');
                        $site_name = get_bloginfo('name', 'display');
                    ?>
                    <a href="<?= esc_url(home_url('/')); ?>" class="custom-logo-link" rel="home"<?php if (is_front_page()): ?> aria-current="page"<?php endif; ?> aria-label="<?= esc_attr($site_name . ' - ' . webokids_t('Home', 'Inicio')); ?>">
                        <?php if ($logo_id): ?>
                            <?= wp_get_attachment_image($logo_id, 'full', false, array(
                                'class'         => 'custom-logo',
                                'alt'           => $site_name,
                                'loading'       => 'eager',
                                'fetchpriority' => 'high',
                                'decoding'      => 'async',
                            )); ?>
                        <?php else: ?>
                            <span class="site-name"><?= esc_html($site_name); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="col-6 nav-contain" id="main-navigation">
                    <div class="menu">
                        <?php wp_nav_menu(['menu'=>'Main header']); ?>
                    </div>
                    <div class="nav-login d-blck d-md-none">
                        <?php wp_nav_menu(['menu' => 'My Account']); ?>
                    </div>
                </div>
                <div class="col-5 col-sm-4 col-lg-3 menu-bar-contain">
                    <div class="ctas-contain">
                        <div class="wishlist-cta">
                            <a href="<?= esc_url(home_url('/wishlist/')); ?>" aria-label="<?= esc_attr(webokids_t('Wishlist', 'Lista de deseos')); ?>" title="<?= esc_attr(webokids_t('Wishlist', 'Lista de deseos')); ?>">
                                <svg aria-hidden="true" focusable="false" id="Grupo_28" data-name="Grupo 28" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33.961" height="29.528" viewBox="0 0 33.961 29.528">
                                    <defs>
                                        <clipPath id="clip-path">
                                        <rect id="Rectángulo_27" data-name="Rectángulo 27" width="33.961" height="29.528" fill="none"/>
                                        </clipPath>
                                    </defs>
                                    <g id="Grupo_27" data-name="Grupo 27" clip-path="url(#clip-path)">
                                        <path id="Trazado_29" data-name="Trazado 29" d="M29.7,16a31.2,31.2,0,0,1-5.249,5.884A30.89,30.89,0,0,1,16.408,27.4h1.184a32.206,32.206,0,0,1-9.064-6.484c-2.3-2.241-4.651-4.775-5.671-7.888-1.228-3.75-.3-8.1,3.475-9.967a7.289,7.289,0,0,1,9.655,3.307,1.182,1.182,0,0,0,2.026,0A7.287,7.287,0,0,1,28.906,3.828c3.923,3.06,3.12,8.41.79,12.168-.8,1.288,1.232,2.467,2.027,1.185,3.034-4.895,3.435-11.682-1.652-15.4a9.641,9.641,0,0,0-14.084,3.4h2.026A9.65,9.65,0,0,0,5.633.805C.721,2.951-.981,8.589.536,13.472c1.314,4.23,4.649,7.68,7.892,10.549a35.9,35.9,0,0,0,6.126,4.472c.9.507,1.99,1.324,3.038.931a17.955,17.955,0,0,0,3.387-1.864A36.956,36.956,0,0,0,31.723,17.181c.823-1.272-1.208-2.45-2.027-1.185"/>
                                    </g>
                                </svg>
                            </a>
                        </div>
                        <div id="wcspc-count" class="wcspc-count wcspc-count-bottom-left car-header" role="button" tabindex="0" aria-label="<?= esc_attr(webokids_t('Open cart', 'Ver carrito')); ?>" title="<?= esc_attr(webokids_t('Cart', 'Carrito')); ?>">
                            <svg aria-hidden="true" focusable="false" id="Grupo_23" data-name="Grupo 23" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23.636" height="29.528" viewBox="0 0 23.636 29.528">
                                <defs>
                                    <clipPath id="clip-path">
                                    <rect id="Rectángulo_24" data-name="Rectángulo 24" width="23.636" height="29.528" fill="none"/>
                                    </clipPath>
                                </defs>
                                <g id="Grupo_22" data-name="Grupo 22" clip-path="url(#clip-path)">
                                    <path id="Trazado_25" data-name="Trazado 25" d="M16.465,29.528H7.171A7.179,7.179,0,0,1,0,22.357V5.892H23.636V22.357a7.178,7.178,0,0,1-7.171,7.171M1.873,7.765V22.357a5.3,5.3,0,0,0,5.3,5.3h9.294a5.3,5.3,0,0,0,5.3-5.3V7.765Z"/>
                                    <path id="Trazado_26" data-name="Trazado 26" d="M18.326,9.957H16.453V6.508a4.635,4.635,0,0,0-9.271,0V9.957H5.309V6.508a6.509,6.509,0,0,1,13.017,0Z"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="bar-menu d-block d-md-none" role="button" tabindex="0" aria-label="<?= esc_attr(webokids_t('Open menu', 'Abrir menú')); ?>" aria-controls="main-navigation" aria-expanded="false">
                        <span class="top"></span>
                        <span class="center"></span>
                        <span class="bottom"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($social_networks): ?>
        <ul class="social-networks">
            <?php foreach($social_networks as $item): ?>
                <li>
                    <?php
                        $social_label = $item['link']['title'] ?: wp_parse_url($item['link']['url'], PHP_URL_HOST);
                    ?>
                    <a href="<?= esc_url($item['link']['url']); ?>"<?= webokids_target_attrs($item['link']); ?> aria-label="<?= esc_attr('Webo ' . $social_label); ?>" title="<?= esc_attr($social_label); ?>">
                        <?= webokids_replace_fa_icons($item['icon']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>       