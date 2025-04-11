   
<?php
/**
 * 
 * Partial Name: products-slide
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$content = get_field('products_content');
if($content['product_list']):
?>
<section class="products-slide-partial-3a813f">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="top-content">
                    <div class="texts">
                        <h2><?= $content['title']; ?></h2>
                        <p><?= $content['text']; ?></p>
                    </div>
                    <div class="ctas">
                        <div class="see-all-contaian">
                            <a href="<?= $content['see_all_products']; ?>">
                                <span class="text">
                                    <?php if(get_bloginfo("language") == "en-US"): ?>See all<?php else: ?>Ver todo<?php endif; ?>
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
                            </a>
                        </div>
                        <div class="nav-slide-products">
                            <ul>
                                <li>
                                    <a href="#" class="prev">
                                        <span></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="next">
                                        <span></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="product-list">
                    <?php 
                        foreach($content['product_list'] as $prod){
                            echo do_shortcode('[product id="'. $prod['product'] .'"]');
                        } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(()=>{
        $('.prev').addClass('disabled');
    })
    /*============ esto por si quiere que pase uno por uno ============
    var scroll_left = 0;
    var items = 1;
    $('.nav-slide-products .next').on('click', function(e){
        
        next_product();
        e.preventDefault();
    });
    function next_product(){
        if(4 > items){
            nWidth = (scroll_left + product.width() + 15);
            items++;
        }else{
            $('.next').addClass('disabled');
        }
        scroll_left = nWidth;
        $('.product-list').scrollLeft(scroll_left);
    };
    $('.nav-slide-products .prev').on('click', function(e){
        items--;
        prev_product();
        e.preventDefault();
    });
    function prev_product(){
        if(items < 3){
            nWidth = (scroll_left - product.width() - 15);
            scroll_left = nWidth;
            $('.product-list').scrollLeft(scroll_left);
        }else if(items == 0){
            $('.prev').addClass('disabled');
        }
    } 
    ============== Hast aquí ==============*/
</script>
<?php endif; ?>