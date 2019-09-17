<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<title>Place the geocoder input outside the map</title>
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.1/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.1/mapbox-gl.css' rel='stylesheet' />
<style>
body { margin:0; padding:0; }
#map { position:absolute; top:0; bottom:0; width:100%; }
</style>
</head>
<body>

<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.1/mapbox-gl-geocoder.min.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.1/mapbox-gl-geocoder.css' type='text/css' />
<style>
    .geocoder {
        position:absolute;
        z-index:1;
        width:20%;
        left:50%;
        margin-left:-45%;
        top:60px;
    }
    .endGeocoder {
        position:absolute;
        z-index:1;
        width:20%;
        left:50%;
        margin-left:-23%;
        top:60px;
    }
    .my_button {
        position: absolute;
        z-index: 1;
        margin-top: 52px;
        margin-left: 20px;
        background-color: #0d95e8;
        font-family:'Roboto',sans-serif;
        border:0.1em solid #FFFFFF;
        color:#FFFFFF;
        text-align:center;
    }
    .my_button:hover{
        color:#000000;
    }
    @media all and (max-width:30em){
         .my_button{
            margin:10rem auto;
             }
    }
.mapboxgl-ctrl-geocoder { min-width:100%; }
</style>
<div id='map'></div>
<div id='geocoder' class='geocoder'></div>
<div id='endGeocoder' class='endGeocoder'></div>
<div ><button type="button" class="my_button" onclick="navi()">GO!</button></div>

<script>
mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqbGF0NDBrcjE3OTEzcG1xamlnYmx6ZG0ifQ.sENGOs1iCipx9_poX73l8g';
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v11',
center: [-79.4512, 43.6568],
zoom: 13
});

var geocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    countries: 'au',
    placeholder:'Set an origin',
    marker: {
        color: 'blue'
    },
    types: 'poi',
    render: function(item) {
        var maki = item.properties.maki || 'marker';
        return "<div class='geocoder-dropdown-item'><img class='geocoder-dropdown-icon' src='https://unpkg.com/@mapbox/maki@6.1.0/icons/" + maki + "-15.svg'><span class='geocoder-dropdown-text'>" + item.text + "</span></div>";
    },
    mapboxgl: mapboxgl
});

geocoder.on('result', function(ev) {
    var searchResult = ev.result.geometry;
    console.log(searchResult);
    start = searchResult.coordinates;

});

geocoder.on('clear', function(ev) {
    if (map.getSource('route')) {
        map.removeLayer('route');
        map.removeSource('route');
    }
    document.getElementById("instructions").style.display = "none";
    start=null;
});

var endGeocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    countries: 'au',
    placeholder:'Set the destination',
    marker: {
        color: 'orange'
    },
    types: 'poi',
    render: function(item) {
        var maki = item.properties.maki || 'marker';
        return "<div class='geocoder-dropdown-item'><img class='geocoder-dropdown-icon' src='https://unpkg.com/@mapbox/maki@6.1.0/icons/" + maki + "-15.svg'><span class='geocoder-dropdown-text'>" + item.text + "</span></div>";
    },
    mapboxgl: mapboxgl
});

endGeocoder.on('result', function(ev) {
    var searchResult = ev.result.geometry;
    console.log(searchResult);
    end = searchResult.coordinates;
    getRoute(end);
});

endGeocoder.on('clear', function(ev) {
    if (map.getSource('route')) {
        map.removeLayer('route');
        map.removeSource('route');
    }
    document.getElementById("instructions").style.display = "none";
    end=null;
});

document.getElementById('geocoder').appendChild(geocoder.onAdd(map));
document.getElementById('endGeocoder').appendChild(endGeocoder.onAdd(map));
</script>

</body>
</html>