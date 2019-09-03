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
    <style>

        #map {
            height: 100%;
            width: 100%;
            border: 1px solid lightyellow;
            background-color:grey;
            shape-outside: ellipse();
        }
        .container_map{
            height:600px;
        }
        .filter-box {
            padding: 5px 10px;
            border: 1px solid #e8e8e8;
        }
        .marker-filter hr{
            width:0;
        }

    </style>
</head>

<body>
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.css' type='text/css' />

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.html"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">Your Guider</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#">Map</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<section class="yellow bg-primary" id="contact">
    <div class="container">
        <h2>Check out seats, toilets and drinking fountains!</h2>

    </div>
    <div class="container_map row no-gutters">
        <!-- Filter Checkboxes -->
        <div class="marker-filter col-lg-2" style="margin-left: 20px;">
            <p style="margin-top: 2rem; font-size: 25px; font-weight: bold;">To find out:</p>
            <span class="filter-box">
            <label for="seats" style="font-size: 18px;">
                <input type="checkbox" name="checkbox" id="seats" onclick="getSeats()">
                Seats
            </label>
        </span>
            <hr>
            <span class="filter-box">
            <label for="toilets" style="font-size: 18px;">
                <input type="checkbox" name="checkbox"  id="toilets" onclick="getToilets()">
                Toilets
            </label>
        </span>
            <hr>
            <span class="filter-box">
            <label for="drinking_fountains" style="font-size: 18px;">
                <input type="checkbox" name="checkbox" id="drinking_fountains" onclick="getDrink()">
                Drinking Fountains
            </label>
        </span>
            <hr>
            <p style="margin-top: 1rem; font-size: 24px; font-weight: bold;">Change map style:</p>
            <div id='menu' style="text-align: left;font-size: 18px; margin-left: 4rem">

                <input id='light-v10' type='radio' name='rtoggle' value='light' checked='checked' onclick="initmap()">
                <label for='light'>light</label>
                <br>
                <input id='streets-v11' type='radio' name='rtoggle' value='streets'onclick="street()" >
                <label  for='streets'>streets</label>
                <br>
                <input id='dark-v10' type='radio' name='rtoggle' value='dark' onclick="dark()" >
                <label for='dark'>dark</label>
                <br>
                <input id='satellite-v9' type='radio' name='rtoggle' value='satellite' onclick="satellite()">
                <label for='satellite'>satellite</label>
            </div>
        </div>
             <div class="col-lg-9" id='map' style="margin-left: 20px"></div>
    </div>
</section>



<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>



<?php include_once 'locations_model.php'; ?>

<script>

    mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
    var map;
    var seatMarkers = [];
    var toiletMarkers = [];
    var drinkMarkers = [];
    var locations;

    initmap();

    function initmap(){
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
    }

    function unSelectAll() {
        var items = document.getElementsByName('checkbox');
        for (var i = 0; i < items.length; i++) {
            if (items[i].type == 'checkbox')
                items[i].checked = false;
        }
    }

    function satellite(){
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

    function dark(){
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

    function street(){
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

    function getUserLocation(){
        if(navigator.geolocation)
            navigator.geolocation.getCurrentPosition(function(position){
                console.log(position);
                var marker = new mapboxgl.Marker({color:'#fcd703'})
                    .setLngLat([position.coords.longitude,position.coords.latitude])
                    .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                        .setHTML('<h3>Your current location</h3>'))
                    .addTo(map);
            });
        else
            console.log("geolocation is not supported");

        // fake user location, just for testing, delete this when publish
        var marker = new mapboxgl.Marker({color:'#fcd703'})
            .setLngLat([144.9639,-37.8136])
            .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                .setHTML('<h3>Fake current location</h3>'))
            .addTo(map);
    }


    function load3D(){
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
                'minzoom': 15,
                'paint': {
                    'fill-extrusion-color': '#aaa',

                    // use an 'interpolate' expression to add a smooth transition effect to the
                    // buildings as the user zooms in
                    'fill-extrusion-height': [
                        "interpolate", ["linear"], ["zoom"],
                        15, 0,
                        15.05, ["get", "height"]
                    ],
                    'fill-extrusion-base': [
                        "interpolate", ["linear"], ["zoom"],
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

    function getGradient(){

        var checkBox = document.getElementById("gradient");
        if (checkBox.checked == true)
        {

        }
        else
        {

        }

    }




</script>







</html>