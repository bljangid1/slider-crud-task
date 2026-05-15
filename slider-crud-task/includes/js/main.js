$(document).ready(function(){
    let activeCategory = $('.tab-btn:first').data('category');
    let current = 0;

    function showSlide(cat,index=0){
        $('.slide, .slide-img').removeClass('active').hide();
        let slides = $('.slide[data-category="'+cat+'"]');
        let imgs = $('.slide-img[data-category="'+cat+'"]');
        slides.eq(index).addClass('active').show();
        imgs.eq(index).addClass('active').show();
        current = index;
    }

    // Initial display
    showSlide(activeCategory);

    // Tab click
    $('.tab-btn').click(function(){
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        activeCategory = $(this).data('category');
        showSlide(activeCategory);
    });

    // Next / Prev buttons
    $('#next').click(function(){
        let slides = $('.slide[data-category="'+activeCategory+'"]');
        let nextIndex = (current+1)%slides.length;
        showSlide(activeCategory,nextIndex);
    });

    $('#prev').click(function(){
        let slides = $('.slide[data-category="'+activeCategory+'"]');
        let prevIndex = (current-1+slides.length)%slides.length;
        showSlide(activeCategory,prevIndex);
    });
});