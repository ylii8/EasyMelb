
function loadMap() {
    var melbourne = {lat: -37.8136, lng: 144.9631};
    var map = new google.maps.Map(document.getElementById('map'), {
        center: melbourne,
        zoom: 15
    });
    var marker = new google.maps.Marker({position: melbourne, map: map});

    var lightData = JSON.parse(document.getElementById('lightData').innerHTML);

    showAllLights(lightData);
}

function showAllLights(){
    Array.prototype.forEach.call(lightData, function(data){
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(data.lat, data.lng),
            map:map
        });
        console.log(marker);
    })
}
