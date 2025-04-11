   
<?php
/**
 * 
 * Partial Name: the-newest
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$the_newest = get_field('the_newest');
?>
<section class="the-newest-partial-67ef94">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="title"><?= $the_newest['title'] ?></h2>
                <a href="<?= $the_newest['cta_shop_here']; ?>" class="main-cta">
                    <?php if(get_bloginfo("language") == "en-US"): ?>
                        Buy the new here
                    <?php else: ?>
                        Compra lo nuevo aquí
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </div>
    <div class="banner-contain">
        <?php if($the_newest['gallery']): ?>
            <div class="galleries owl-carousel">
                <?php foreach($the_newest['gallery'] as $image): ?>
                    <div class="item">
                        <img src="<?= $image['url']; ?>" alt="<?= $image['title']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="banner-texts">
            <h3><?= $the_newest['banner_title']; ?></h3>
            <p><?= $the_newest['banner_description']; ?></p>
            <a href="<?= $the_newest['link_shop']; ?>">
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
<script>
    $('.galleries').owlCarousel({
        autoplay:false,
        loop:false,
        nav:false,
        dots:false,
        margin:0,
        responsive:{
            0:{
                items:1
            },
            640:{
                items:2
            },
            991:{
                items:3
            }
        }
    }).css({'opacity':1});
</script>