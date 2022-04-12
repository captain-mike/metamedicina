jQuery($ =>{
    $('.owl-carousel').owlCarousel({
        loop:true,
        responsiveClass:true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        smartSpeed:450,
        responsive:{
            0:{
                items:1,
            },
            1000:{
                items:1,
                nav:true
            }
        }
    });
});