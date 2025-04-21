   
<?php
/**
 * 
 * Partial Name: footer
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$form = get_field('form_shortcode', 'option');
$instagram_link = get_field('instagram', 'option');
$favicon = get_field('favicon', 'option');
$instagram = get_field('shortcode_instagram', 'option');
$instagram_cta = get_field('cta_instagram', 'option');
?>
<section class="footer-partial-baccbf">
    <div class="intagram-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?= get_field('instagram_title', 'option'); ?></h2>
                    <?php if($instagram_cta): ?>
                        <a href="<?= $instagram_cta['url']; ?>" target="<?= $instagram_cta['target']; ?>" class="instagram-cta d-flex d-md-none">
                            <span class="text"><?= $instagram_cta['title']; ?></span>
                            <span class="icon-suscribe"><i class="fa-regular fa-heart"></i></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?= do_shortcode($instagram); ?>
    </div>
    <div class="footer-content">
        <div class="container">
            <div class="top-content">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-4 mb-4 mb-md-0">
                        <div class="form-contain">
                            <h2><?= get_field('form_text', 'option'); ?></h2>
                            <div class="the-form">
                                <?= do_shortcode($form); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 mb-4 mb-md-0">
                        <h4><?php if(get_bloginfo("language") == "en-US"): ?>MENU<?php else: ?>MENÚ<?php endif; ?></h4>
                        <div class="menu">
                            <?php wp_nav_menu(['menu' => 'Menu 1']); ?>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-4 mb-md-0">
                        <h4><?php if(get_bloginfo("language") == "en-US"): ?>CUSTOMER SERVICE<?php else: ?>SERVICIO AL CLIENTE<?php endif; ?></h4>
                        <div class="menu">
                            <?php wp_nav_menu(['menu' => 'Servicio al cliente']); ?>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 mb-4 mb-md-0">
                        <h4><?php if(get_bloginfo("language") == "en-US"): ?>CONTACT<?php else: ?>CONTACTO<?php endif; ?></h4>
                        <div class="menu">
                            <?php wp_nav_menu(['menu' => 'Contacto']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copi-right-content">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <p class="copy-right"><?= get_field('copyright', 'option'); ?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row justify-content-between align-items-center">
                            <?php if($favicon): ?>
                                <div class="col-12 col-md-2 favicon-content">
                                    <img src="<?= $favicon['url']; ?>" alt="<?= $favicon['title']; ?>">
                                </div>
                            <?php endif; if($instagram_link): ?>
                                <div class="col-12 col-md-3 instagram-content">
                                    <a href="<?= $instagram_link['url']; ?>" target="<?= $instagram_link['target']; ?>">
                                        <i class="fa-brands fa-instagram"></i>
                                        <span><?= $instagram_link['title']; ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
                    