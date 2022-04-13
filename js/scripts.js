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


document.addEventListener('DOMContentLoaded', function() {
    fetch('http://metamedicina.test/wp-json/wp/v2/calendar?trainer='+TRAINER_ID)
    .then(data => data.json())
    .then(data => {

        var calendarEl = document.getElementById('calendar-area');
        if(data.length == 0)
        return

        let events = [];
        data.forEach(el => {

                let obj = {
                    start : el.acf.start,
                    end : el.acf.end,
                    title : el.title.rendered,
                    color: '#c2000b'
                }
                events.push(obj)
        })

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale:'it',
            buttonText: {
                today: 'oggi',
                month: 'mese',
                week: 'settimana',
                day: 'giorno'
            },
            events: events
        });
        calendar.render();
    });
});