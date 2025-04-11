   
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
        <img src="<?= $background_text['url']; ?>" alt="<?= $background_text['title']; ?>" class="background-text">
        <div id="product-content"></div>
    </div>
    <?php if($products): ?>
        <div class="banner-slide owl-carousel">
            <?php foreach($products as $product): ?>
                <div class="item">
                    <input type="hidden" value="<?php if($product['background_image'] === true): ?>background-image:url(<?= $product['background_img']; ?>)<?php else: ?>background:<?php echo $product['color']; endif; ?>;" class="background-value">
                    <input type="hidden" class="image-url" value="<?= $product['product_image']['url'] ?>">
                    <input type="hidden" class="image-title" value="<?= $product['product_image']['title'] ?>">
                    <input type="hidden" class="product-url" value="<?= $product['link']; ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <?php if($nav): ?>
            <ul class="nav-category">
                <?php foreach($nav as $li): ?>
                    <li>
                        <a href="<?= home_url(); ?>/product-category/<?= $li['category']->slug; ?>">
                            <span><?= $li['category']->name; ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23.068" height="23.068" viewBox="0 0 23.068 23.068">
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
        <img src="<?= $logo_bottom['url']; ?>" alt="<?= $logo_bottom['title']; ?>" class="logo-bottom">
        <script>
            $('.banner-slide').owlCarousel({
                autoplay:true,
                loop:true,
                nav:false,
                dots:false,
                margin:0,
                items:1,
                onDragged: callback,
            }).on('changed.owl.carousel', function() {
                callback();
            });
            function callback(){
                $('#product-content').html('');
                var background = $('.banner-slide .owl-item.active .background-value').val();
                var img_url = $('.banner-slide .owl-item.active .image-url').val();
                var img_title = $('.banner-slide .owl-item.active .image-title').val();
                var product_link = $('.banner-slide .owl-item.active .product-url').val();
                $('#product-content').html(`
                    <a href="${product_link}">
                        <div class="product-image-contain" style="${background}">
                            <img src="${img_url}" alt="${img_title}" class="product-image">
                        </div>
                    </a>
                `);
            }
            $(()=>{
                callback();
            });
        </script>
    <?php endif; ?>
</section>
                    