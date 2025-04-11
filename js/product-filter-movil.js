$('.open-filter').on('click', ()=>{
    $('.filter-movil').removeClass('d-none');
});
$('.close-filter').on('click', ()=>{
    $('.filter-movil').addClass('d-none');
});
/*=========== Filter reset ===========*/
$('.filter-reset').on('click', function(){
    $('.this-item').removeClass('active');
    get_by_category();
    get_by_color();
    get_by_size();
    $('.filter-movil').addClass('d-none');
    get_products();
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
});
function get_by_size(){
    size_list = [];
    var size = $('.this-size.active');
    for(var i = 0; i < size.length; i++){
        size_list.push($(size[i]).attr('href'));
    }
}
/*============= applie filter ==============*/
$('.filter-run').on('click', function(){
    $('.filter-movil').addClass('d-none');
    get_products();
})