$(window).scroll(function() {
    var screen = $(window).width();
    if (screen > 768) {
        var windowScrol = $(window).scrollTop();
        var position = $('.body-post').offset().top;
        var heightContent = $('.end-sticky').offset().top - 720;
        if (windowScrol >= position) {
            $('.content-product-sticky').addClass('sticky');
        }
        if (windowScrol >= heightContent) {
            $('.content-product-sticky').removeClass('sticky');
            $('#row-product-details').addClass('align-items-end');
        }
        if (windowScrol < position) {
            $('.content-product-sticky').removeClass('sticky');
            $('#row-product-details').removeClass('align-items-end');
        }
    }
});
/*=============== Gallery read more ================*/
var show_more = false;
$('.show-more-img').on('click', (e)=>{
    if(show_more === false){
        $('.this-hidden').removeClass('d-none');
        $('.show-more-img .more').addClass('d-none');
        $('.show-more-img .less').removeClass('d-none');
        show_more = true;
    }else{
        $('.this-hidden').addClass('d-none');
        $('.show-more-img .more').removeClass('d-none');
        $('.show-more-img .less').addClass('d-none');
        show_more = false;
    }
    e.preventDefault();
});
$('.gallery-slide').owlCarousel({
    autoplay:false,
    loop:false,
    nav:false,
    dots:true,
    margin:0,
    items:1
});