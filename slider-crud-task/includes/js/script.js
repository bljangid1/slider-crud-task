
//desktopSwiper
let desktopSwiper = new Swiper(".desktopSwiper", {

    slidesPerView:1,
    spaceBetween:0,    

    pagination:{
        el:".desktopSwiper .swiper-pagination",
        clickable:true,
    }

});

//imageSwiper
let imageSwiper = new Swiper(".imageSwiper", {

    slidesPerView:1,
    allowTouchMove:false

});

// SYNC IMAGE AND UPDATE CATEGORY TAB

let currentCategory = null; 

desktopSwiper.on('slideChange', function() {

   
    imageSwiper.slideTo(desktopSwiper.activeIndex);

   
    let activeSlide = $('.desktopSwiper .swiper-slide').eq(desktopSwiper.activeIndex);
    let category = activeSlide.data('category');

    
    if (category !== currentCategory) {
        currentCategory = category;

        
        $('.custom-tab').removeClass('active');
        
        $('.icon-indicator').text('+');

        
        let targetTab = $('.custom-tab[data-category="'+category+'"]');
        targetTab.addClass('active');
       
        targetTab.find('.icon-indicator').text('−');
    }

});


// TAB CLICK
$('.custom-tab').click(function(){

    let category = $(this).data('category');

    $('.custom-tab').removeClass('active');

    $('.icon-indicator').text('+');

    $(this).addClass('active');

    $(this).find('.icon-indicator').text('−');

    let targetIndex = $('.desktopSwiper .swiper-slide[data-category="'+category+'"]').first().index();

    desktopSwiper.slideTo(targetIndex);

    imageSwiper.slideTo(targetIndex);

});


 // mobile swipper
$('.mobileSwiper').each(function(){

    new Swiper(this, {

        slidesPerView:1,

        pagination:{
            el:$(this).find('.swiper-pagination')[0],
            clickable:true
        }

    });

});

//mobile icon togle
$('.collapse').on('show.bs.collapse', function () {

    $('.mobile-icon').text('+');

    $(this).prev().find('.mobile-icon').text('−');

});

$('.collapse').on('hide.bs.collapse', function () {

    $(this).prev().find('.mobile-icon').text('+');

});

