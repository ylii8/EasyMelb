<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header.php'; ?>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.css' rel='stylesheet' />
    <!-- Geocoder plugin -->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.min.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.css' type='text/css' />
    <!-- Turf.js plugin -->
    <script src='https://npmcdn.com/@turf/turf/turf.min.js'></script>
    <!-- jquery -->
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js">
    </script>
    <style>
    #map { position:absolute; top:0; bottom:0; width:100%; }
    
    .container_map {
        height: 600px;
    }
    
    .filter-box {
        padding: 5px 10px;
        border: 1px solid #e8e8e8;
    }
    
    .marker-filter hr {
        width: 0;
    }

    </style>
</head>

<?php include_once 'locations_model.php'; ?>

<body>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.css' type='text/css' />
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="index.html" style="color: #fdcc52;"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">Your Guider</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" >
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="index.html" style="color: #fdcc52;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#" style="color: #fdcc52;">Map</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  
       <!--  <div class="container">
            <h2>Check out seats, toilets and drinking fountains!</h2>
            </style>
        </div> -->
        <div class="container_map row no-gutters">
            <!-- Filter Checkboxes -->
            
                <style>
                #menu {
                    background: #fff;
                    position: absolute;
                    z-index: 1;
                    top: 60px;
                    right: 129px;
                    border-radius: 3px;
                    width: 120px;
                    border: 1px solid rgba(0, 0, 0, 0.4);
                    font-family: 'Open Sans', sans-serif;
                }
                
                #menu label {
                   
                    font-size: 13px;
                    color: #404040;
                    display: block;
                    margin: 0;
                    padding: 0;
                    padding: 10px;
                    text-decoration: none;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.25);
                    text-align: center;
                }
                
                #menu label:last-child {
                    border: none;
                }
                
                #menu label:hover {
                    background-color: #fdcb50;
                    color: #404040;
                }
                
                #menu label:active {
                    background-color: #ff9609;
                    color: #ffffff;
                }
                
                #menu label:active:hover {
                    background: #ff9609;
                }
                
                #blockLabel {
                    background: #fff;
                    position: absolute;
                    z-index: 1;
                    top: 60px;
                    right: 10px;
                    border-radius: 3px;
                    width: 120px;
                    border: 1px solid rgba(0, 0, 0, 0.4);
                    font-family: 'Open Sans', sans-serif;
                }
                
                #blockLabel label {
                    right: 100px;
                    font-size: 13px;
                    color: #404040;
                    display: block;
                    margin: 0;
                    padding: 0;
                    padding: 10px;
                    text-decoration: none;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.25);
                    text-align: center;
                }
                
                #blockLabel label:last-child {
                    border: none;
                }
                
                #blockLabel label:hover {
                    background-color: #fdcb50;
                    color: #404040;
                }
                
                #blockLabel label:active {
                    background-color: #ff9609;
                    color: #ffffff;
                }
                
                #blockLabel label:active:hover {
                    background: #ff9609;
                }
                </style>
                <script type="text/javascript">
                $(document).ready(function() {


                    $("#blockLabel").hover(function() {
                        $("#menu").css("display", "block");
                    }, function() {
                        $("#menu").css("display", "none");
                    });

                    $("#hideLabel").hover(function() {
                        $("#menu").css("display", "block");
                    }, function() {
                        $("#menu").css("display", "none");
                    });

                });
                </script>
                <div id='blockLabel' style="text-align: left;font-size: 18px; margin-left: 4rem">
                    <label style="right: -1000px;">Change style</label>
                </div>
                <div id='menu' style="text-align: left;font-size: 18px; margin-left: 4rem;display:none;">
                    <div id='hideLabel'>
                        <label for='light' onclick="initmap()">light</label>
                        <label for='streets' onclick="street()">streets</label>
                        <label for='dark' onclick="dark()">dark</label>
                        <label for='satellite' onclick="satellite()">satellite</label>
                    </div>
                </div>
                <style>
                .filter-group {
                    font-size: 13px;
                    font-family: 'Open Sans', sans-serif;
                    position: absolute;
                    top: 100px;
                    right: 10px;
                    z-index: 1;
                    border: 1px solid rgba(0, 0, 0, 0.4);
                    width: 120px;
                    color: #404040;
                }
                
                .filter-group input[type=checkbox]:first-child + label {
                    border-radius: 3px 3px 0 0;
                }
                
                .filter-group label:last-child {
                    border-radius: 0 0 3px 3px;
                    border: none;
                }
                
                .filter-group input[type=checkbox] {
                    display: none;
                }
                
                .filter-group input[type=checkbox] + label {
                    background-color: #3386c0;
                    display: block;
                    cursor: pointer;
                    padding: 10px;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.25);
                    margin-bottom: 0;
                }
                
                .filter-group input[type=checkbox] + label {
                    background-color: #fff;
                    text-transform: capitalize;
                }
                
                .filter-group input[type=checkbox] + label:hover,
                .filter-group input[type=checkbox]:checked + label {
                    background-color: #fdcb50;
                }

                .filter-group input[type=checkbox]:checked + label:before {
                    content: '✔';
                }

                </style>
                <nav id="filter-group" class="filter-group">
                    <input type="checkbox" id="seats" onclick="getSeats()">
                    <label for="seats" id="seats" >Seats</label>
                    <input type="checkbox" id="toilets" onclick="getToilets()">
                    <label for="toilets" id="toilets" >Toilets</label>
                    <input type="checkbox" id="drinking_fountains" onclick="getDrink()">
                    <label for="drinking_fountains" id="drinking_fountains" >Drinking Fountains</label>
                    <input type="checkbox" id="line" onclick="showGradientLayer()">
                    <label for="line" id="line" >Gradient</label>
                    <input type="checkbox" id="3d-buildings" onclick="show3dLayer()">
                    <label for="3d-buildings" id="3d-buildings" >3D</label>
                </nav>
            </div>
            <div  id='map' ></div>
        </div>
  
   
</body>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
var map;
var seatMarkers = [];
var toiletMarkers = [];
var drinkMarkers = [];
var locations;

initmap();

function initmap() {
    map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/light-v10', //style URL of map style
        center: [144.96565, -37.81384], //default location when load the map
        zoom: 14, //default zoom level
        // Zero is perpendicular to the surface
        pitch: 45,
        // the compass direction that is "up"
        bearing: -17.6,
        antialias: true
    });
    load3D();
    getUserLocation();
    unSelectAll();
    getGradient();

}

function unSelectAll() {
    var items = document.getElementsByName('checkbox');
    for (var i = 0; i < items.length; i++) {
        if (items[i].type == 'checkbox')
            items[i].checked = false;
    }
}

function  show3dLayer() {

    var checkBox = document.getElementById("3d-buildings");
    if (checkBox.checked == true) {
        map.setLayoutProperty("3d-buildings", 'visibility', 'visible');
    } else {
        map.setLayoutProperty("3d-buildings", 'visibility', 'none');
    }
}

function  showGradientLayer() {

    var checkBox = document.getElementById("line");
    if (checkBox.checked == true)
    {
        map.setLayoutProperty('line', 'visibility', 'visible');
    } else {
        map.setLayoutProperty('line', 'visibility', 'none');
    }
}

function satellite() {
    map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/satellite-v9', //style URL of map style
        center: [144.96565, -37.81384], //default location when load the map
        zoom: 14, //default zoom level
        // Zero is perpendicular to the surface
        pitch: 45,
        // the compass direction that is "up"
        bearing: -17.6,
        antialias: true
    });
    getUserLocation();
    unSelectAll();
}

function dark() {
    map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/dark-v10', //style URL of map style
        center: [144.96565, -37.81384], //default location when load the map
        zoom: 14, //default zoom level
        // Zero is perpendicular to the surface
        pitch: 45,
        // the compass direction that is "up"
        bearing: -17.6,
        antialias: true
    });
    load3D();
    getUserLocation();
    unSelectAll();
}

function street() {
    map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11', //style URL of map style
        center: [144.96565, -37.81384], //default location when load the map
        zoom: 14, //default zoom level
        // Zero is perpendicular to the surface
        pitch: 45,
        // the compass direction that is "up"
        bearing: -17.6,
        antialias: true
    });
    load3D();
    getUserLocation();
    unSelectAll();
}

function getUserLocation() {
    if (navigator.geolocation)
        navigator.geolocation.getCurrentPosition(function(position) {
            console.log(position);
            var marker = new mapboxgl.Marker({
                    color: '#fcd703'
                })
                .setLngLat([position.coords.longitude, position.coords.latitude])
                .setPopup(new mapboxgl.Popup({
                        offset: 25
                    }) // add popups
                    .setHTML('<h3>Your current location</h3>'))
                .addTo(map);
        });
    else
        console.log("geolocation is not supported");

    // fake user location, just for testing, delete this when publish
    var marker = new mapboxgl.Marker({
            color: '#fcd703'
        })
        .setLngLat([144.9639, -37.8136])
        .setPopup(new mapboxgl.Popup({
                offset: 25
            }) // add popups
            .setHTML('<h3>Fake current location</h3>'))
        .addTo(map);
}


function load3D() {
    // The 'building' layer in the mapbox-streets vector source contains building-height
    // data from OpenStreetMap.

    map.on('load', function() {
        // Insert the layer beneath any symbol layer.
        var layers = map.getStyle().layers;

        var labelLayerId;
        for (var i = 0; i < layers.length; i++) {
            if (layers[i].type === 'symbol' && layers[i].layout['text-field']) {
                labelLayerId = layers[i].id;
                break;
            }
        }

        map.addLayer({
            'id': '3d-buildings',
            'source': 'composite',
            'source-layer': 'building',
            'filter': ['==', 'extrude', 'true'],
            'type': 'fill-extrusion',
            'layout': {
                'visibility': 'none'
            },
            'minzoom': 15,
            'paint': {
                'fill-extrusion-color': '#aaa',

                // use an 'interpolate' expression to add a smooth transition effect to the
                // buildings as the user zooms in
                'fill-extrusion-height': [
                    "interpolate", ["linear"],
                    ["zoom"],
                    15, 0,
                    15.05, ["get", "height"]
                ],
                'fill-extrusion-base': [
                    "interpolate", ["linear"],
                    ["zoom"],
                    15, 0,
                    15.05, ["get", "min_height"]
                ],
                'fill-extrusion-opacity': .6
            }
        }, labelLayerId);
    });

}


 function getToilets(){

     var checkBox = document.getElementById("toilets");
     if (checkBox.checked == true)
     {
         locations = <?php get_toilet_locations() ?>;
         var markers = [];
         var i ;
         for (i = 0; i < locations.length; i++)
         {
             var marker = new mapboxgl.Marker({color:'#ff1744'})
                 .setLngLat([locations[i][2], locations[i][1]])
                 .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                     .setHTML('<h3>'+ 'Detailed location:' +'</h3><p>' + locations[i][0] + '</p>'))
                 .addTo(map);

             markers.push(marker);

         }
         toiletMarkers = markers;
     }
     else
     {
         for (var i = 0; i < toiletMarkers.length; i++) {
             toiletMarkers[i].remove();
         }
     }
 }

 function getDrink(){

     var checkBox = document.getElementById("drinking_fountains");
     if (checkBox.checked == true)
     {
         locations = <?php get_drink_locations() ?>;
         var markers = [];
         var i ;
         for (i = 0; i < locations.length; i++)
         {
             var marker = new mapboxgl.Marker()
                 .setLngLat([locations[i][2], locations[i][1]])

                 .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                 .setHTML('<h3>'+ 'Detailed location:' +'</h3><p style=\"text-align: Left;\">' + locations[i][0] + '</p>'))
                 .addTo(map);

             markers.push(marker);

         }
         drinkMarkers = markers;
     }
     else
     {
         for (var i = 0; i < drinkMarkers.length; i++) {
             drinkMarkers[i].remove();
         }
     }
 }

 function getSeats(){

     var checkBox = document.getElementById("seats");
     if (checkBox.checked == true)
     {
         locations = <?php get_seats_locations() ?>;

         var markers = [];
         var i ;
         for (i = 0; i < locations.length; i++)
         {
             var marker = new mapboxgl.Marker({color: '#79c142'})
                 .setLngLat([locations[i][3], locations[i][2]])
                 .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                     .setHTML('<h3>'+ 'Detailed location:' +'</h3><p>' + locations[i][1] + '</p>'))
                 .addTo(map);

             markers.push(marker);

         }
         seatMarkers = markers;
     }
     else
     {
         for (var i = 0; i < seatMarkers.length; i++) {
             seatMarkers[i].remove();
         }
     }
 }


function getGradient() {

    var geojson = 'Footpath steepness.geojson';
    map.on('load', function() {
        // 'line-gradient' can only be used with GeoJSON sources
        // and the source must have the 'lineMetrics' option set to true
        map.addSource('line', {
            type: 'geojson',
            lineMetrics: true,
            data: geojson
        });

        // the layer must be of type 'line'
        map.addLayer({
            type: 'line',
            source: 'line',
            id: 'line',
            paint: {
                'line-color': 'red',
                'line-width': 3,
                // 'line-gradient' must be specified using an expression
                // with the special 'line-progress' property
                'line-gradient': [
                    'interpolate', ['linear'],
                    ['line-progress'],
                    0, "blue",
                    0.1, "royalblue",
                    0.3, "cyan",
                    0.5, "lime",
                    0.7, "yellow",
                    1, "red"
                ]
            },
            layout: {
                'visibility': 'none',
                'line-cap': 'round',
                'line-join': 'round'
            }
        });
    });

}
</script>

</html>