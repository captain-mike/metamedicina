 //This function takes in latitude and longitude of two location and returns the distance between them as the crow flies (in km)
 function calcCrow(lat1, lon1, lat2, lon2)  {
   var R = 6371; // km
   var dLat = toRad(lat2-lat1);
   var dLon = toRad(lon2-lon1);
   var lat1 = toRad(lat1);
   var lat2 = toRad(lat2);

   var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
     Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
   var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
   var d = R * c;
   return d;
 }

 // Converts numeric degrees to radians
 function toRad(Value)  {
     return Value * Math.PI / 180;
 }

 function delay(callback, ms) {
    var timer = 0;
    return function() {
      var context = this, args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function () {
        callback.apply(context, args);
      }, ms || 0);
    };
  }

 const getCities = 'http://metamedicina.test/wp-json/geo/v1/city?city='
 const getCitiesJson = '/wp-content/themes/metamedicina/json/cities.json'

document.addEventListener('DOMContentLoaded',function(){

    
    let field = document.querySelector('#myCity_filter')
    let target = document.querySelector('#found-cities')
    let searchNearest = document.querySelector('#search_nearest')
    let km = document.querySelectorAll('#km_filter');

    let url = new URLSearchParams(location.search);

    if(url.has('c') && url.has('kmt')){
        field.setAttribute('data-city-info',url.get('c'))
        field.value = JSON.parse(url.get('c')).name
        km.value = url.get('kmt')
    }
    
    field.addEventListener('keyup',delay(function(){
        
        target.classList.add('d-none')
        field.classList.remove('found')
        if(this.value.length >= 3){
            fetch(getCities+this.value).then(data => data.json())
            .then(data => {
                
                target.innerHTML = ''
                target.classList.remove('d-none')
                for(let city of data){
                    let div = document.createElement('div');
                    div.innerHTML = city.name
                    div.addEventListener('click',function(){
                        field.value = city.name
                        target.classList.add('d-none')
                        field.classList.add('found')
                        field.setAttribute('data-city-info',JSON.stringify(city))
                    })
                    target.appendChild(div);
                }
                
            })
        }
        
    }, 500)
    )

    searchNearest.addEventListener('click',function(){
        
        let fields = Array.from(document.querySelectorAll('#myCity_filter, #km_filter'))
        let [city, km] = fields
        let errors = ''

        let cityJson = JSON.parse(city.getAttribute('data-city-info'))
        
        
        for(let field of fields){
            if(!field.value){
                field.style.borderColor = 'red'
                field.nextElementSibling.innerHTML = field.getAttribute('data-error')
                return false
            }else{
                field.style.borderColor = ''
                field.nextElementSibling.innerHTML = ''
            }
        }
        
        if(!city.classList.contains('found')){
            field.style.borderColor = 'red'
            field.nextElementSibling.innerHTML = field.getAttribute('data-error2')
            return false
        }else{  
            field.style.borderColor = ''
            field.nextElementSibling.innerHTML = ''
        }

        fetch(getCitiesJson,{cache: "force-cache"})
        .then(res => res.json())
        .then(res => {
            let near = res.filter(c => {
                let distance = calcCrow(cityJson.lat, cityJson.lng, c.lat, c.lng)
                return distance <= km.value
            })

            let ids = near.map(c => c.id)

            window.location.href = `?cities=${ids}&c=${city.getAttribute('data-city-info')}&kmt=${km.value}`
        })

    })

    

})