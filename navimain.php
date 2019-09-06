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
        .mapboxgl-popup {
            max-width: 400px;
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }
        #instructions {
            position: absolute;
            margin: 60px;
            width: 25%;
            height: 30%;
            top: 0;
            bottom: 20%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            overflow-y: scroll;
            font-family: sans-serif;
            font-size: 0.8em;
            line-height: 2em;
        }

        .duration {
            font-size: 2em;
        }

        @media (max-width: 769px) {
            #instructions{
                font-family: sans-serif;
                font-size: 0.4em;
                height: 30%;
            }

        }
        @media (max-width: 375px) {
            #instructions{
                font-family: sans-serif;
                font-size: 0.2em;
                padding: 7px;
                margin-left: 40px;
                width: 80%;
                height: 18%;
                margin-top: 39rem;
            }

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
        <a class="navbar-brand js-scroll-trigger" href="index.html" style="color: black;"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">Your Guider</a>
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
        <input type="checkbox" id="route" onclick="showRoute()">
        <label for="route" id="route" >Show Route</label>
    </nav>
</div>
<div  id='map' ></div>
<div id="instructions" style="display: none;"></div>
</div>


</body>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
    var map;

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
        getUserLocation();
        drawDrink();
        drawSeat();
        unSelectAll();
        drawToilet();
        getGradient();
        load3D();
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

    function  showRoute() {

        var checkBox = document.getElementById("route");
        if (checkBox.checked == true)
        {
            map.setLayoutProperty('route', 'visibility', 'visible');
            map.setLayoutProperty('end', 'visibility', 'visible');
            document.getElementById("instructions").style.display = "block";

        } else {
            map.setLayoutProperty('route', 'visibility', 'none');
            map.setLayoutProperty('end', 'visibility', 'none');
            document.getElementById("instructions").style.display = "none";
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
        getUserLocation();
        unSelectAll();
        drawToilet();
        getGradient();
        load3D();
    }

    function getUserLocation() {
        if (navigator.geolocation)
            navigator.geolocation.getCurrentPosition(function(position) {
                start = [position.coords.longitude,position.coords.latitude];

                var marker = new mapboxgl.Marker({ color: '#fcd703'})
                    .setLngLat([position.coords.longitude, position.coords.latitude])
                    .setPopup(new mapboxgl.Popup({offset: 25}) // add popups
                     .setHTML('<h3>Your current location</h3>'))
                    .addTo(map);
            });
        else
            console.log("geolocation is not supported");
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
            map.setLayoutProperty('places', 'visibility', 'visible');
            map.setLayoutProperty('cluster-count', 'visibility', 'visible');
            map.setLayoutProperty('unclustered-point', 'visibility', 'visible');
        }
        else
        {
            map.setLayoutProperty("places", 'visibility', 'none');
            map.setLayoutProperty('cluster-count', 'visibility', 'none');
            map.setLayoutProperty('unclustered-point', 'visibility', 'none');
        }
    }

    function getDrink(){

        var checkBox = document.getElementById("drinking_fountains");
        if (checkBox.checked == true)
        {
            map.setLayoutProperty('drink', 'visibility', 'visible');
            map.setLayoutProperty('drink-cluster-count', 'visibility', 'visible');
            map.setLayoutProperty('drink-unclustered-point', 'visibility', 'visible');
        }
        else
        {
            map.setLayoutProperty('drink', 'visibility', 'none');
            map.setLayoutProperty('drink-cluster-count', 'visibility', 'none');
            map.setLayoutProperty('drink-unclustered-point', 'visibility', 'none');
        }
    }

    function getSeats(){

        var checkBox = document.getElementById("seats");
        if (checkBox.checked == true)
        {
            map.setLayoutProperty('seat', 'visibility', 'visible');
            map.setLayoutProperty('seat-cluster-count', 'visibility', 'visible');
            map.setLayoutProperty('seat-unclustered-point', 'visibility', 'visible');
        }
        else
        {
            map.setLayoutProperty('seat', 'visibility', 'none');
            map.setLayoutProperty('seat-cluster-count', 'visibility', 'none');
            map.setLayoutProperty('seat-unclustered-point', 'visibility', 'none');
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

    // pass toilet data to Geojson array
    var locations = <?php get_toilet_locations() ?>;
    var geojson = {};
    geojson['type'] = 'FeatureCollection';
    geojson['features'] = [];

    for (var k in locations) {
        var newFeature = {
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": [parseFloat(locations[k][2]), parseFloat(locations[k][1])]
            },
            "properties": {
                "description": locations[k][0] + '<br>' + "Female: " + locations[k][3] + '<br>' + "Male: " + locations[k][4] + '<br>' + "Wheelchair: " + locations[k][5] + '<br>' + "Baby Facility: " + locations[k][6],
                "icon": "toilet"
            }
        }
        geojson['features'].push(newFeature);
    }
    console.log(geojson);


    function drawToilet(){
        map.on('load', function () {

            // Add a layer showing the places.
            map.addLayer({
                "id": "places",
                "type": "circle",
                "source": {
                    "type": "geojson",
                    "data": geojson,
                    "cluster":true,
                    "clusterMaxZoom":15,
                    "clusterRadius":50
                },
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                "paint": {
                    // Use step expressions (https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions-step)
                    // with three steps to implement three types of circles:
                    //   * Blue, 20px circles when point count is less than 10
                    //   * Yellow, 30px circles when point count is between 10 and 30
                    //   * Pink, 40px circles when point count is greater than or equal to 750
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#51bbd6",
                        10,
                        "#f1f075",
                        30,
                        "#f28cb1"
                    ],
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        100,
                        30,
                        750,
                        40
                    ]
                }
            });

            map.addLayer({
                id: "cluster-count",
                type: "symbol",
                "source": {
                    "type": "geojson",
                    "data": geojson,
                    "cluster":true,
                    "clusterMaxZoom":15,
                    "clusterRadius":50
                },
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 12,
                    'visibility': 'none'
                }
            });

            map.addLayer({
                id: "unclustered-point",
                type: "symbol",
                "source": {
                    "type": "geojson",
                    "data": geojson,
                    "cluster":true,
                    "clusterMaxZoom":15,
                    "clusterRadius":50
                },
                filter: ["!", ["has", "point_count"]],
                "layout": {
                    "icon-image": "{icon}-15",
                    "icon-allow-overlap": true,
                    'visibility': 'none'
                }
            });

            map.on('mouseenter', 'places', function () {
                map.getCanvas().style.cursor = 'pointer';
            });
            map.on('mouseleave', 'places', function () {
                map.getCanvas().style.cursor = '';
            });

// When a click event occurs on a feature in the places layer, open a popup at the
// location of the feature, with description HTML from its properties.
            map.on('click', 'unclustered-point', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                console.log(coordinates);
                var description = e.features[0].properties.description;

// Ensure that if the map is zoomed out such that multiple
// copies of the feature are visible, the popup appears
// over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);
            });

        });
    }

    // pass drink data to Geojson array
    var drinkLocations = <?php get_drink_locations() ?>;
    var drinkGeojson = {};
    drinkGeojson['type'] = 'FeatureCollection';
    drinkGeojson['features'] = [];
    for (var k in drinkLocations) {
        var newFeature = {
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": [parseFloat(drinkLocations[k][2]), parseFloat(drinkLocations[k][1])]
            },
            "properties": {
                "description": drinkLocations[k][0],
                "icon": "beer"
            }
        }
        drinkGeojson['features'].push(newFeature);
    }

    function drawDrink(){
        map.on('load', function () {
// Add a layer showing the places.
            map.addLayer({
                "id": "drink",
                "type": "circle",
                "source": {
                    "type": "geojson",
                    "data": drinkGeojson,
                    "cluster": true,
                    "clusterMaxZoom": 15, // Max zoom to cluster points on
                    "clusterRadius": 50 // Radius of each cluster when clustering points (defaults to 50)
                },
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                "paint": {
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#51bbd6",
                        15,
                        "#f1f075",
                        30,
                        "#f28cb1"
                    ],
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        100,
                        30,
                        750,
                        40
                    ]
                }
            });
            map.addLayer({
                id: "drink-cluster-count",
                type: "symbol",
                "source": {
                    "type": "geojson",
                    "data": drinkGeojson,
                    "cluster": true,
                    "clusterMaxZoom": 15, // Max zoom to cluster points on
                    "clusterRadius": 50 // Radius of each cluster when clustering points (defaults to 50)
                },
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 12,
                    "visibility":"none"
                }
            });

            map.addLayer({
                id: "drink-unclustered-point",
                type: "symbol",
                "source": {
                    "type": "geojson",
                    "data": drinkGeojson,
                    "cluster": true,
                    "clusterMaxZoom": 15, // Max zoom to cluster points on
                    "clusterRadius": 50 // Radius of each cluster when clustering points (defaults to 50)
                },
                filter: ["!", ["has", "point_count"]],
                layout: {
                    "icon-image": "{icon}-15",
                    "icon-allow-overlap": true,
                    "visibility":"none"
                }
            });

// When a click event occurs on a feature in the places layer, open a popup at the
// location of the feature, with description HTML from its properties.
            map.on('click', 'drink-unclustered-point', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                console.log(coordinates);
                var description = e.features[0].properties.description;

// Ensure that if the map is zoomed out such that multiple
// copies of the feature are visible, the popup appears
// over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);
            });

// Change the cursor to a pointer when the mouse is over the places layer.
            map.on('mouseenter', 'drink', function () {
                map.getCanvas().style.cursor = 'pointer';
            });

// Change it back to a pointer when it leaves.
            map.on('mouseleave', 'drink', function () {
                map.getCanvas().style.cursor = '';
            });
        });
    }

    // pass seat data to Geojson array
    var seatLocations = <?php get_seats_locations() ?>;
    var seatGeojson = {};
    seatGeojson['type'] = 'FeatureCollection';
    seatGeojson['features'] = [];
    for (var k in seatLocations) {
        var newFeature = {
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": [parseFloat(seatLocations[k][3]), parseFloat(seatLocations[k][2])]
            },
            "properties": {
                "description": seatLocations[k][1],
                "icon": "picnic-site"
            }
        }
        seatGeojson['features'].push(newFeature);
    }
    console.log(seatGeojson);

    function drawSeat(){
        map.on('load', function () {
// Add a layer showing the places.
            map.addLayer({
                "id": "seat",
                "type": "circle",
                "source": {
                    "type": "geojson",
                    "data": seatGeojson,
                    cluster: true,
                    clusterMaxZoom: 17,
                    clusterRadius: 50
                },
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                paint: {
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#51bbd6",
                        15,
                        "#f1f075",
                        30,
                        "#f28cb1",
                        300,
                        "#f64c4c"
                    ],
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        100,
                        30,
                        750,
                        40
                    ]
                }
            });

            map.addLayer({
                id: "seat-cluster-count",
                type: "symbol",
                "source": {
                    "type": "geojson",
                    "data": seatGeojson,
                    cluster: true,
                    clusterMaxZoom: 17,
                    clusterRadius: 50
                },
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 12,
                    'visibility': 'none'
                }
            });

            map.addLayer({
                id: "seat-unclustered-point",
                type: "symbol",
                "source": {
                    "type": "geojson",
                    "data": seatGeojson,
                    cluster: true,
                    clusterMaxZoom: 17,
                    clusterRadius: 50
                },
                filter: ["!", ["has", "point_count"]],
                layout: {
                    "icon-image": "{icon}-15",
                    "icon-allow-overlap": true,
                    "visibility":"none"
                }
            });

// When a click event occurs on a feature in the places layer, open a popup at the
// location of the feature, with description HTML from its properties.
            map.on('click', 'seat-unclustered-point', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                console.log(coordinates);
                var description = e.features[0].properties.description;

// Ensure that if the map is zoomed out such that multiple
// copies of the feature are visible, the popup appears
// over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);
            });

// Change the cursor to a pointer when the mouse is over the places layer.
            map.on('mouseenter', 'seat', function () {
                map.getCanvas().style.cursor = 'pointer';
            });

// Change it back to a pointer when it leaves.
            map.on('mouseleave', 'seat', function () {
                map.getCanvas().style.cursor = '';
            });
        });
    }

    var start;
    var canvas = map.getCanvasContainer();
    getUserLocation();
    // create a function to make a directions request
    function getRoute(end) {

        // make a directions request using cycling profile
        // an arbitrary start will always be the same
        // only the end or destination will change
        // initialize the map canvas to interact with later
        console.log(start);
        console.log(end);
        // an arbitrary start will always be the same
        // only the end or destination will change
        var url = 'https://api.mapbox.com/directions/v5/mapbox/walking/' + start[0] + ',' + start[1] + ';' + end[0] + ',' + end[1] + '?steps=true&geometries=geojson&access_token=' + mapboxgl.accessToken;

        // make an XHR request https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest
        var req = new XMLHttpRequest();
        req.responseType = 'json';
        req.open('GET', url, true);
        req.onload = function() {
            var data = req.response.routes[0];
            var route = data.geometry.coordinates;
            var geojson = {
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'LineString',
                    coordinates: route
                }
            };
            // if the route already exists on the map, reset it using setData
            if (map.getSource('route')) {
                map.getSource('route').setData(geojson);
            } else { // otherwise, make a new request
                map.addLayer({
                    id: 'route',
                    type: 'line',
                    source: {
                        type: 'geojson',
                        data: {
                            type: 'Feature',
                            properties: {},
                            geometry: {
                                type: 'LineString',
                                coordinates: geojson
                            }
                        }
                    },
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round',
                        'visibility': 'none'
                    },
                    paint: {
                        'line-color': '#e04050',
                        'line-width': 5,
                        'line-opacity': 0.75

                    }
                });
            }
            // add turn instructions here at the end
            // get the sidebar and add the instructions
            var instructions = document.getElementById('instructions');
            var steps = data.legs[0].steps;

            var tripInstructions = [];
            for (var i = 0; i < steps.length; i++) {
                tripInstructions.push('<br><li>' + steps[i].maneuver.instruction) + '</li>';
                instructions.innerHTML = '<span class="duration">Trip duration: ' + Math.floor(data.duration / 60) + ' min </span>' + tripInstructions;
            }
        };
        req.send();
    }

    map.on('click', function(e) {
        var coordsObj = e.lngLat;
        canvas.style.cursor = '';
        var coords = Object.keys(coordsObj).map(function(key) {
            return coordsObj[key];
        });
        var end = {
            type: 'FeatureCollection',
            features: [{
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'Point',
                    coordinates: coords
                }
            }
            ]
        };
        if (map.getLayer('end')) {
            map.getSource('end').setData(end);
        } else {
            map.addLayer({
                id: 'end',
                type: 'circle',
                source: {
                    type: 'geojson',
                    data: {
                        type: 'FeatureCollection',
                        features: [{
                            type: 'Feature',
                            properties: {},
                            geometry: {
                                type: 'Point',
                                coordinates: coords
                            }
                        }]
                    }
                },
                paint: {
                    'circle-radius': 5,
                    'circle-color': '#3887be'
                },
                layout: {
                    'visibility': 'none'
                },
            });
        }
        getRoute(coords);
    });


</script>

</html>