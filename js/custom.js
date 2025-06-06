var screen = $(window).width();
if(screen < 768){
    var state_menu = false;
    $('.bar-menu').on('click', ()=>{
        if(state_menu === false){
            $('.nav-contain').addClass('active');
            state_menu =  true;
        }else{
            $('.nav-contain').removeClass('active');
            state_menu = false;
        }
    });
}
/*============= Header Stiky ==============*/
$(window).on('scroll', function(){
    var height = $(window).scrollTop();
    var scrollTop = $('.header-contain').height() - 10;
    if(height < scrollTop){
        // Scroll down
        $('.header-contain').removeClass('sticky');
    }else{
        // Scroll up
        $('.header-contain').addClass('sticky');
    }
});
/*=========== Policie click ===========*/
$('.policies-container').on('click', 'label', function(){
    var checked = $('input[type="checkbox"]', this);
    if(checked.prop('checked')){
        $('.checkbox', this).addClass('active');
        console.log('activado');
    }else{
        $('.checkbox', this).removeClass('active');
        console.log('desactivado');
    }
});
/*============== Products slide home ===============*/
$('.nav-slide-products .next').on('click', function(e){
    var slide_width = $('.product-list').width();
    $('.product-list').scrollLeft(slide_width+50);
    $('.next').addClass('disabled');
    $('.prev').removeClass('disabled');
    e.preventDefault();
});
$('.nav-slide-products .prev').on('click', function(e){
    $('.product-list').scrollLeft(0);
    $('.next').removeClass('disabled');
    $('.prev').addClass('disabled');
    e.preventDefault();
});
$('.nav-slide-products').on('click', '.disabled', function(e){
    e.preventDefault();
}); 
/*============ Filter products ============*/
var category_list = [];
var color_list = [];
var size_list = [];
function get_products(){
    if(category_list.length == 0){
        category_list = '';
    }
    if(color_list.length == 0){
        color_list = '';
    }
    if(size_list.length == 0){
        size_list = '';
    }
    $.ajax({
        type:'GET',
        url:rout,
        data: {
            category: category_list,
            color: color_list,
            size: size_list,
        }
    }).done(function(resp){
        $('.product-list').html('').removeClass('show');
        if(resp.length > 0){
            for(item of resp){
                $('.product-list').append(`${item}`);
                $('.product-list').addClass('row');
                $('.product-list .woocommerce').addClass('col-6 col-md-4 mb-4');
            }
        }else{
            $('.product-list').html(`
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="error-message">${error}</p>
                    </div>
                </div>
            `)
        }
        $('.product-list').addClass('show');
    }).fail(function(){
        $('.product-list').html(`
            <div class="row">
                <div class="col-12 text-center">
                    <p class="error-message">${error}</p>
                </div>
            </div>
        `)
    });
}
/*================== Product gallery ==================*/
$('.woocommerce-product-gallery__image').on('mouseover', function(){
    $('.woocommerce-product-gallery__image').removeClass('flex-active-slide');
    $(this).addClass('flex-active-slide');
});
$('.zoom-trigger').each(function() {
    $(this).zoom({
        url: $(this).attr('href'),
        magnify: 2
    });
});
/*============== Variations selected ==============*/
$('#options-color').on('click', 'li', function(){
    $('#options-color li').removeClass('active');
    option = $(this).children('.variation-checkbox').val();
    $('#pa_essize').val(option).trigger('change');
    var stock = $('.woocommerce-variation-availability p').text();
    if(stock === 'Agotado' || stock === 'Out of stock'){
        $(this).addClass('disabled');
    }else{
        $(this).addClass('active');
    }
});
/*============= Reset variations =============*/
$('.reset_variations').on('click', function(){
    $('#options-color li').removeClass('active');
});
/*============= FQA =============*/
$('.fqas-list').on('click', '.question', function(){

});
var acc = $('.question');
var i;
for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function(e) {
        this.parentElement.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            $('.fqas-list').removeClass('active');
            this.parentElement.classList.toggle("active");
            $('.answer').css({'display':'none'});
            panel.style.display = "block";
        }
        e.preventDefault();
    });
}
/*=============== Tabs Guide size ===============*/
$('.tab-contoller').on('click', 'a', function(e){
    $('.tab-contoller li').removeClass('active');
    $(this).parent().addClass('active');
    var tab = $(this).attr('href');
    $('.body-tab .the-body').removeClass('active');
    $('.body-tab .'+tab).addClass('active');
    e.preventDefault();
});
/*================ Slide generic banner ================*/
$('.galleries').owlCarousel({
    autoplay:true,
    loop:true,
    nav:false,
    dots:false,
    margin:0,
    responsive:{
        0:{
            items:1,
        },
        640:{
            items:2
        },
        991:{
            items:3
        }
    }
}).css({'opacity':1});