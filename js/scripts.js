jQuery($ =>{
    $('.owl-carousel').owlCarousel({
        loop:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            1000:{
                items:1,
                nav:true,
                loop:false
            }
        }
    });
});