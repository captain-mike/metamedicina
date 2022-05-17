jQuery($ =>{

    $('#loader').fadeOut('slow')
    
    window.onbeforeunload = function(){
        $('#loader .image-logo').hide();
        $('#loader').fadeIn('fast');
    }

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
/**
 * for ajax loadings
 */
function showLoading(){
    qs('#loading').classList.remove('d-none')
}
function hideLoading(){
    qs('#loading').classList.add('d-none')
}


function qs(el, all = false){
    if(all)
        return document.querySelectorAll(el)
    
    return document.querySelector(el)
}
//useful for selecting and listening a click event
function clickOnThis(el,fn){
    qs(el).addEventListener('click', fn)
}

//useful for selecting multiple elements and listening a click event on each
function clickOnThese(el,fn){
    qs(el,true).forEach(function(element){
        element.addEventListener('click', fn)
    })
}



document.addEventListener('DOMContentLoaded', function() {

clickOnThis('.mobile-bar .toggle', function(){
    
    this.classList.toggle('open');
    qs('#menu').classList.toggle('open');
    qs('#menu .open',true).forEach(el => el.classList.remove('open'))
    
})

clickOnThese('.menu-item-has-children', function(){
    
    this.classList.add('open')
    qs('.mobile-bar .toggle').classList.add('d-none')
    let runtimeBtn = this.querySelector('.close-sub-menu')
    if(runtimeBtn == null){
        let div = document.createElement('div');
        div.classList.add('close-sub-menu')
        div.innerHTML = '<i class="bi bi-backspace-reverse-fill"></i>'
        div.addEventListener('click', (e) => {
            e.stopPropagation();
            this.classList.remove('open')
            qs('.mobile-bar .toggle').classList.remove('d-none')
        })

        this.prepend(div)
    }

})

    if(typeof TRAINER_ID !== 'undefined'){
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
                    color: '#c2000b',
                    url: el.guid.rendered
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
    }


    /**
     * mobile info bar
     */
    if(qs('#info-button') != null){

        clickOnThis('#info-button',function(){
            
            this.classList.toggle('open')
            qs('#hidden-info').classList.toggle('open')
            
        })
    }

    /** filters */

    //trainer citi/lang/name filters

    let fields = Array.from(qs('#name_filter, #lang_filter, #region_filter',true))
    clickOnThis('#search_other',function(){

        let [name, lang, region] = fields

        let search = new URLSearchParams()
        search.set('filter',1)

        for(let field of fields){
            if(field.value)
            search.set(field.name,field.value)

        }

        location.href = '/'+PAGE_SLUG+'?'+search.toString()
        

    })

    //check if there are active filters and update fields
    let url = new URLSearchParams(location.search)

    if(url.has('filter')){
        for(let field of fields){
            if(url.has(field.name)){
                field.value = url.get(field.name)
            }
        }
    }

    //reset filters



});