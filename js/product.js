$(()=>{
    var cambio = false;
    $('.by-categories  ul li a').each(function(index) {
        if(this.href.trim() == window.location){
            $(this).addClass("active");
            cambio = true;
        }
    });
});
/*============== Filter by category ==============*/
$('.by-category').on('click', '.filter-name', function(){
    $(this).parent().toggleClass('active');
});
/*=========== Select category ===========*/
$('.by-category').on('click', '.this-cat', function(e){
    e.preventDefault();
    $(this).toggleClass('active');
    get_by_category();
    get_products();
});
function get_by_category(){
    category_list = [];
    var categories = $('.this-cat.active');
    for(var i = 0; i < categories.length; i++){
        category_list.push($(categories[i]).attr('href'));
    }
}
/*============== Filter by color ==============*/
$('.by-color').on('click', '.filter-name', function(){
    $(this).parent().toggleClass('active');
});
/*============ Select color ============*/
$('.by-color').on('click', '.this-color', function(e){
    e.preventDefault();
    $(this).toggleClass('active');
    get_by_color();
    get_products();
});
function get_by_color(){
    color_list = [];
    var color = $('.this-color.active');
    for(var i = 0; i < color.length; i++){
        color_list.push($(color[i]).attr('href'));
    }
}
/*============== Filter by size ==============*/
$('.by-size').on('click', '.filter-name', function(){
    $(this).parent().toggleClass('active');
});
/*=========== Select Size ===========*/
$('.by-size').on('click', '.this-size', function(e){
    e.preventDefault();
    $(this).toggleClass('active');
    get_by_size();
    get_products();
});
function get_by_size(){
    size_list = [];
    var size = $('.this-size.active');
    for(var i = 0; i < size.length; i++){
        size_list.push($(size[i]).attr('href'));
    }
}