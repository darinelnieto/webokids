   
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
                    <div id="countdown"></div>
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
                        <img src="<?= $image['url']; ?>" alt="<?= $image['title']; ?>" width="<?= $image['width']; ?>" height="<?= $image['height']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p><?= get_field('text_banner'); ?></p>
                    <a href="<?= get_field('link') ?>">
                        <span class="text">
                            <?php if(get_bloginfo("language") == "en-US"): ?>
                                See more products
                            <?php else: ?>
                                Ver mas productos
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
        </div>
    </section>
</main>
<?php get_footer(); ?>
<script>
    $(()=>{
        $('.products-list .woocommerce').addClass('row');
        $('.products-list .woocommerce a').addClass('col-6 col-md-4 col-lg-3 mb-4');
    });
    var date_end = $('.date-init').val().trim();

    // Diccionario de meses en español a inglés
    var monthMap = {
        "Ene": "Jan", "Feb": "Feb", "Mar": "Mar", "Abr": "Apr", "May": "May", "Jun": "Jun",
        "Jul": "Jul", "Ago": "Aug", "Sep": "Sep", "Oct": "Oct", "Nov": "Nov", "Dic": "Dec"
    };

    // Extraer el mes en español y reemplazarlo
    var monthRegex = /^(...)\s(\d{1,2}),\s(\d{4})\s(\d{2}):(\d{2}):(\d{2})$/;
    var match = date_end.match(monthRegex);

    if (match) {
        var mesEnEspañol = match[1]; // "Dic"
        var dia = match[2];
        var año = match[3];
        var hora = match[4];
        var minutos = match[5];
        var segundos = match[6];

        if (monthMap[mesEnEspañol]) {
            var mesEnIngles = monthMap[mesEnEspañol];
            date_end = `${mesEnIngles} ${dia}, ${año} ${hora}:${minutos}:${segundos}`;
        }
    }

    var countDownDate = new Date(date_end).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    if(days <= 9){
        days = '0' + Math.floor(distance / (1000 * 60 * 60 * 24));
    }
    if(hours <= 9){
        hours = '0' + Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    }
    if(minutes <= 9){
        minutes = '0' + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    }
    if(seconds <= 9){
        seconds = '0' + Math.floor((distance % (1000 * 60)) / 1000);
    }
    <?php if(get_bloginfo("language") == "en-US"): ?>
        document.getElementById("countdown").innerHTML = "<div class='item-count'><span>" + days + "</span><br><span>Days</span></div><div class='item-count'><span class'date'>" + hours + "</span><br><span class='h-m'>Hours</span></div><div class='item-count'><span class'date'>" + minutes + "</span><br><span class='h-m'>Minutes</span></div><div class='item-count'><span class'date'>" + seconds + "</span><br><span class='h-m'>Seconds</span></div>";
    <?php else: ?>
        document.getElementById("countdown").innerHTML = "<div class='item-count'><span>" + days + "</span><br><span>Días</span></div><div class='item-count'><span class'date'>" + hours + "</span><br><span class='h-m'>Horas</span></div><div class='item-count'><span class'date'>" + minutes + "</span><br><span class='h-m'>Minutos</span></div><div class='item-count'><span class'date'>" + seconds + "</span><br><span class='h-m'>Segundos</span></div>";
    <?php endif; ?>

    // If the count down is finished, write some text
    if (distance < 0) {
        clearInterval(x);
        $(".count-down").addClass('d-none');
        $('.products-list').addClass('d-none');
        $('.closed-off').removeClass('d-none');
    }
    }, 1000);
</script>